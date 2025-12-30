<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

// Handle Profile Updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $bio = mysqli_real_escape_string($con, $_POST['bio']);

    // Handle Profile Picture Upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "img/profiles/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
        $new_filename = "profile_" . $user_id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
            // Update DB with new picture
            $update_pic_sql = "UPDATE signup SET profile_picture = '$profile_picture' WHERE id = '$user_id'";
            mysqli_query($con, $update_pic_sql);
        }
    }

    $sql = "UPDATE signup SET 
            username = '$username', 
            email = '$email', 
            gender = '$gender', 
            birthday = '$birthday', 
            contact = '$contact', 
            bio = '$bio' 
            WHERE id = '$user_id'";

    if (mysqli_query($con, $sql)) {
        $_SESSION['username'] = $username;
        $success = "Profile updated successfully!";
    } else {
        $error = "Update failed: " . mysqli_error($con);
    }
}

// Fetch Current User Data
$sql = "SELECT * FROM signup WHERE id = '$user_id'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <header class="navbar">
        <div class="container navbar-container">
            <div class="logo">
                AniCrave
            </div>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="favorites.php">Favorites</a>
                <a href="account.php">Profile</a>
            </nav>

            <div class="auth-buttons">
                <a href="login.php" class="signup">Logout</a>
            </div>
        </div>
    </header>

    <div class="account-container">
        <div class="container">
            <h1 class="account-title">Account Settings</h1>

            <div class="account-content">
                <!-- Profile Picture Section -->
                <div class="profile-picture-section">
                    <div class="profile-picture-container">
                        <img src="<?php echo $user['profile_picture'] ?? ''; ?>"
                            alt="Profile Picture" id="profile-preview">
                        <div class="profile-overlay">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                    <form id="account-form" method="POST" action="account.php" enctype="multipart/form-data"
                        class="account-form">
                        <input type="hidden" name="action" value="update_profile">
                        <input type="file" id="profile-upload" name="profile_picture" accept="image/*"
                            style="display: none;">
                        <button type="button" class="upload-btn"
                            onclick="document.getElementById('profile-upload').click()">
                            <i class="fa-solid fa-upload"></i> Upload Picture
                        </button>
                        <p class="upload-hint">JPG, PNG or GIF. Max size 5MB.</p>
                </div>

                <!-- Account Information Form -->
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
                                <option value="other" <?php echo ($user['gender'] == 'other') ? 'selected' : ''; ?>>Other
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

                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <button type="reset" class="cancel-btn">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-minimal">
            <div class="footer-logo">AniCrave</div>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-social">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-discord"></i></a>
            </div>
            <div class="footer-copyright">
                &copy; 2024 AniCrave. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Change tracking
        let isDirty = false;

        // Show PHP messages using SweetAlert
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

        <?php if ($error): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $error; ?>',
                confirmButtonColor: '#3DB4F2'
            });
        <?php endif; ?>

        // Profile picture upload preview
        const profileUpload = document.getElementById('profile-upload');
        const profilePreview = document.getElementById('profile-preview');

        profileUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                // Check file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: 'File size must be less than 5MB',
                        confirmButtonColor: '#3DB4F2'
                    });
                    profileUpload.value = ''; // Clear selection
                    return;
                }

                // Check file type
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please upload an image file (JPG, PNG, or GIF)',
                        confirmButtonColor: '#3DB4F2'
                    });
                    profileUpload.value = ''; // Clear selection
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    profilePreview.src = event.target.result;
                    isDirty = true; // Mark as changed
                };
                reader.readAsDataURL(file);
            }
        });

        // Load saved profile data on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Track any changes to the form
            accountForm.addEventListener('input', () => {
                isDirty = true;
            });

            // Browser-level navigation warning
            window.addEventListener('beforeunload', (e) => {
                if (isDirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });

        // Form submission frontend validation
        const accountForm = document.getElementById('account-form');
        accountForm.addEventListener('submit', (e) => {
            // No longer prevent default, allow PHP to handle it
            // but we reset isDirty so the beforeunload doesn't trigger
            isDirty = false;
        });

        // Cancel button
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