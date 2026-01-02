<?php
// Siguraduhin na may session at database connection bago mag-render ng header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AniCrave </title>
    <!-- Cache Busting implementation to force-load the latest CSS assets -->
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <!-- Pre-connect and fetch fonts through the network -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <!-- Icon set integration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 library integration -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- Main Site Navigation Bar -->
    <header class="navbar">
        <div class="container navbar-container">
            <!-- Branding element -->
            <div class="logo">
                AniCrave
            </div>
            <!-- Internal nav pointers -->
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="favorites.php">Favorites</a>
            </nav>

            <!-- User Auth state controls -->
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])):
                    // Fetch profile picture for the dropdown
                    $header_user_id = $_SESSION['user_id'];
                    $header_sql = "SELECT profile_picture FROM signup WHERE id = '$header_user_id'";
                    $header_result = mysqli_query($con, $header_sql);
                    $header_user = mysqli_fetch_assoc($header_result);
                    $profile_pic = !empty($header_user['profile_picture']) ? $header_user['profile_picture'] : '';
                    ?>
                    <div class="profile-dropdown">
                        <a href="account.php" class="profile-icon-link">
                            <?php if ($profile_pic): ?>
                                <img src="<?php echo $profile_pic; ?>" alt="Profile"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <i class="fa-solid fa-user"></i>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu">
                            <a href="account.php" class="dropdown-item">
                                <i class="fa-solid fa-circle-user"></i>
                                <span>Profile</span>
                            </a>
                            <a href="favorites.php" class="dropdown-item">
                                <i class="fa-solid fa-heart"></i>
                                <span>Favorites</span>
                            </a>
                            <a href="logout.php" class="dropdown-item logout-item">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="login">Log In</a>
                    <a href="login.php" class="signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>