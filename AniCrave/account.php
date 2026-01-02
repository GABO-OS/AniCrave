<?php
// Initiation of session for user status check
session_start();
// Include DB config
include 'connect.php';

// Check if logged in na si user, redirect to login if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Variables setup for form processing
$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

// Processing profile update via POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    // Sanitize user inputs to prevent injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $bio = mysqli_real_escape_string($con, $_POST['bio']);

    // Handle profile picture update if there is an uploaded file
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "img/profiles/";
        // Auto-create directory if missing
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
        // Construct unique filename using timestamp
        $new_filename = "profile_" . $user_id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        // Move the file from temp to final destination
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
            $update_pic_sql = "UPDATE signup SET profile_picture = '$profile_picture' WHERE id = '$user_id'";
            mysqli_query($con, $update_pic_sql);
        }
    }

    // Run the main update query for profile fields
    $sql = "UPDATE signup SET 
            username = '$username', 
            email = '$email', 
            gender = '$gender', 
            birthday = '$birthday', 
            contact = '$contact', 
            bio = '$bio' 
            WHERE id = '$user_id'";

    if (mysqli_query($con, $sql)) {
        // Update session username para mag-sync sa UI
        $_SESSION['username'] = $username;
        $success = "Profile updated successfully!";
    } else {
        $error = "Update failed: " . mysqli_error($con);
    }
}

// Query latest user data to display sa form
$sql = "SELECT * FROM signup WHERE id = '$user_id'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Security failsafe: if user is missing in DB, force logout
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<?php
// Load navbar component
include 'includes/header.php';
?>

<div class="account-container">
    <div class="container">
        <div class="account-header">
            <h1 class="account-title">Account Settings</h1>
            <p class="account-subtitle">Manage your profile and account preferences</p>
        </div>

        <div class="account-content">
            <!-- Main profile form with file upload support -->
            <form id="account-form" method="POST" action="account.php" enctype="multipart/form-data"
                class="account-form">
                <input type="hidden" name="action" value="update_profile">

                <!-- Profile picture selection area -->
                <div class="profile-picture-section">
                    <div class="profile-picture-container">
                        <!-- Preview of current or default profile pic -->
                        <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'img/default-profile.png'; ?>"
                            alt="Profile Picture" id="profile-preview">
                        <div class="profile-overlay">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                    <!-- Hidden input for file picking -->
                    <input type="file" id="profile-upload" name="profile_picture" accept="image/*"
                        style="display: none;">
                    <button type="button" class="upload-btn"
                        onclick="document.getElementById('profile-upload').click()">
                        <i class="fa-solid fa-upload"></i> Upload Picture
                    </button>
                    <p class="upload-hint">JPG, PNG or GIF. Max size 5MB.</p>
                </div>

                <!-- Form fields for text and dropdown inputs -->
                <div class="account-form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter username"
                                value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter email"
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select gender</option>
                                <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male
                                </option>
                                <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>
                                    Female</option>
                                <option value="other" <?php echo ($user['gender'] == 'other') ? 'selected' : ''; ?>>
                                    Other
                                </option>
                                <option value="prefer-not" <?php echo ($user['gender'] == 'prefer-not') ? 'selected' : ''; ?>>Prefer not to say</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="contact">Contact Number</label>
                            <input type="tel" id="contact" name="contact" placeholder="Enter contact number"
                                value="<?php echo htmlspecialchars($user['contact']); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" rows="4"
                                placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
                        </div>
                    </div>

                    <!-- Submission buttons -->
                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <button type="reset" class="cancel-btn">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Load footer component
include 'includes/footer.php';
?>


<script>
    // State tracker for unsaved changes
    let isDirty = false;

    // Trigger success SweetAlert if success variable is present
    <?php if ($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: '<?php echo $success; ?>',
            confirmButtonColor: '#3DB4F2',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>

    // Trigger error SweetAlert on failures
    <?php if ($error): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $error; ?>',
            confirmButtonColor: '#3DB4F2'
        });
    <?php endif; ?>

    // Dynamic preview logic for image uploads
    const profileUpload = document.getElementById('profile-upload');
    const profilePreview = document.getElementById('profile-preview');

    profileUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            // Validation: sizing check
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'File size must be less than 5MB',
                    confirmButtonColor: '#3DB4F2'
                });
                profileUpload.value = '';
                return;
            }

            // Validation: type check
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please upload an image file (JPG, PNG, or GIF)',
                    confirmButtonColor: '#3DB4F2'
                });
                profileUpload.value = '';
                return;
            }

            // Read and preview the image locally
            const reader = new FileReader();
            reader.onload = (event) => {
                profilePreview.src = event.target.result;
                isDirty = true;
            };
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const accountForm = document.getElementById('account-form');

        // Track changes to form inputs
        accountForm.addEventListener('input', () => {
            isDirty = true;
        });

        // Prevention for accidental data loss on navigation
        window.addEventListener('beforeunload', (e) => {
            if (isDirty) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    });

    // Reset dirty state on form submit
    const accountForm = document.getElementById('account-form');
    accountForm.addEventListener('submit', (e) => {
        isDirty = false;
    });

    // Confirmation logic for discarding changes via cancel btn
    document.querySelector('.cancel-btn').addEventListener('click', (e) => {
        e.preventDefault();

        if (isDirty) {
            Swal.fire({
                title: 'Discard Changes?',
                text: 'You have unsaved modifications. Are you sure you want to discard them?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#3DB4F2',
                confirmButtonText: 'Yes, discard',
                cancelButtonText: 'No, keep editing'
            }).then((result) => {
                if (result.isConfirmed) {
                    isDirty = false;
                    location.reload();
                }
            });
        } else {
            location.reload();
        }
    });
</script>
</body>

</html>