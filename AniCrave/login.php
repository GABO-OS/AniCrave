<?php
session_start();
include('connect.php');

$error = "";
$success = "";

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'signup') {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            // Check if email already exists
            $check_sql = "SELECT * FROM `signup` WHERE email = '$email'";
            $check_result = mysqli_query($con, $check_sql);
            if (mysqli_num_rows($check_result) > 0) {
                $error = "Email already registered!";
            } else {
                // Hash the password
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $sql = "INSERT INTO `signup` (username, email, password_hashed) VALUES ('$username', '$email', '$password_hashed')";
                if (mysqli_query($con, $sql)) {
                    $success = "Registration successful! You can now login.";
                } else {
                    $error = "Registration failed: " . mysqli_error($con);
                }
            }
        }
    } elseif ($_POST['action'] == 'login') {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM `signup` WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Verify password using password_verify
            if (password_verify($password, $user['password_hashed'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
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
        </div>
    </header>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2 id="form-title">Login</h2>
                <p id="form-subtitle">Welcome back to AniCrave</p>
            </div>

            <form class="auth-form" id="login-form" method="POST" action="login.php">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="sub" class="submit-btn">Login</button>
            </form>

            <form class="auth-form hidden" id="register-form" method="POST" action="login.php">
                <input type="hidden" name="action" value="signup">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit" name="sub" class="submit-btn">Sign Up</button>
            </form>

            <div class="auth-footer">
                <p id="toggle-text">Don't have an account? <a href="#" id="toggle-form">Sign Up</a></p>
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
        const toggleLink = document.getElementById('toggle-form');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const formTitle = document.getElementById('form-title');
        const formSubtitle = document.getElementById('form-subtitle');
        const toggleText = document.getElementById('toggle-text');

        // Show PHP messages using SweetAlert
        <?php if ($error): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $error; ?>',
                confirmButtonColor: '#3DB4F2'
            });
        <?php endif; ?>

        <?php if ($success): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success; ?>',
                confirmButtonColor: '#3DB4F2'
            });
        <?php endif; ?>

        // Helper to show error
        function showError(form, message) {
            let errorDiv = form.querySelector('.error-message');
            if (!errorDiv) {
                // Insert error div at the top of the form
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                form.insertBefore(errorDiv, form.firstChild);
            }
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        function clearError(form) {
            const errorDiv = form.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }

        let isLogin = true;

        function toggleHandler(e) {
            e.preventDefault();
            isLogin = !isLogin;

            clearError(loginForm);
            clearError(registerForm);

            if (isLogin) {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                formTitle.textContent = 'Login';
                formSubtitle.textContent = 'Welcome back to AniCrave';
                toggleLink.textContent = 'Sign Up';
                toggleText.childNodes[0].nodeValue = "Don't have an account? ";
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                formTitle.textContent = 'Sign Up';
                formSubtitle.textContent = 'Join the community';
                toggleLink.textContent = 'Login';
                toggleText.childNodes[0].nodeValue = "Already have an account? ";
            }
        }

        // Use onclick to ensure clean event binding
        toggleLink.onclick = toggleHandler;

        // Form Validation before submission
        loginForm.addEventListener('submit', (e) => {
            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;

            if (!email || !password) {
                e.preventDefault();
                showError(loginForm, 'Please fill in all fields.');
            }
        });

        registerForm.addEventListener('submit', (e) => {
            const username = registerForm.querySelector('input[name="username"]').value;
            const email = registerForm.querySelector('input[name="email"]').value;
            const password = registerForm.querySelector('input[name="password"]').value;
            const confirmPassword = registerForm.querySelector('input[name="confirm_password"]').value;

            if (!username || !email || !password || !confirmPassword) {
                e.preventDefault();
                showError(registerForm, 'Please fill in all fields.');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showError(registerForm, 'Password must be at least 6 characters long.');
                return;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                showError(registerForm, 'Passwords do not match.');
                return;
            }
        });
    </script>
</body>

</html>