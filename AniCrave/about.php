<?php
// Start yung session para ma-access ang user data
session_start();
// Include the database connection file para if ever kailangan natin mag-query
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Browser tab title -->
    <title>About Us - AniCrave</title>
    <!-- Description for search engines (SEO) -->
    <meta name="description"
        content="Learn about AniCrave, your ultimate destination for discovering and tracking anime. Find out about our mission and features.">
    <!-- Main style sheet -->
    <link rel="stylesheet" href="styles.css">
    <!-- Font pre-connections for speed -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome for UI icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <?php
    // Insert common header component
    include 'includes/header.php';
    ?>

    <!-- Hero Section: Visual introduction sa page -->
    <section class="about-hero">
        <div class="about-hero-content">
            <h1>About AniCrave</h1>
            <p class="hero-subtitle">Your ultimate destination for discovering and tracking anime</p>
        </div>
    </section>

    <!-- Main Container para sa page content -->
    <main class="about-container container">

        <!-- Features Showcase area -->
        <section class="about-section">
            <div class="section-header">
                <div class="section-icon"><i class="fas fa-star"></i></div>
                <h2>Key Features</h2>
            </div>
            <!-- Grid for highlighting specific features -->
            <div class="features-grid">
                <!-- Feature 1 Card -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-search"></i></div>
                    <h3>Smart Discovery</h3>
                    <p>Advanced filtering and search tools to help you find exactly what you're looking for, from
                        trending hits to hidden gems.</p>
                </div>
                <!-- Feature 2 Card -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-list"></i></div>
                    <h3>Track Progress</h3>
                    <p>Keep a comprehensive list of what you've watched, what you're currently viewing, and what's on
                        your plan-to-watch list.</p>
                </div>
                <!-- Feature 3 Card -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-heart"></i></div>
                    <h3>Personalized Favorites</h3>
                    <p>Build your own collection of top-rated series and share your taste with the community through
                        your custom profile.</p>
                </div>
            </div>
        </section>

    </main>

    <?php
    // Insert common footer component
    include 'includes/footer.php';
    ?>

</body>

</html>