<?php
include 'connect.php';
$anime = getAnimeByTitle($con, "Spy x Family Season 2") ?: [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spy x Family Season 2 - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="login.php" class="login">Login</a>
                <a href="login.php" class="signup">Sign Up</a>
            </div>
        </div>
    </header>

    <div class="details-banner"
        style="background-image: url('<?php echo !empty($anime['banner_image']) ? $anime['banner_image'] : 'img/spyfam-banner.png'; ?>');">
        <div class="banner-shadow"></div>
    </div>

    <div class="container details-header-container">
        <div class="details-cover">
            <img src="<?php echo $anime['cover_image'] ?? 'img/spyfam.jfif'; ?>" alt="Spy x Family Cover">
            <div class="action-buttons">
                <button class="btn-action-fav" id="fav-btn">
                    <span>Add to Favorites</span>
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="details-title-section">
            <h1>Spy x Family Season 2</h1>
            <p class="breadcrumbs">SPY×FAMILY Season 2</p>
            <p class="description-text">
                <?php echo !empty($anime['description']) ? nl2br($anime['description']) : 'Peace at the nations of Ostania and Westalis is a precarious thing. To maintain it, the master spy "Twilight" must take on his most difficult mission yet: get married, have a kid, and play family.<br><br>In this second season, the Forger family continues their secret lives while navigating the challenges of everyday life and undercover missions. Anya\'s school life at Eden Academy becomes more intense as she strives to help Loid with Operation Strix, while Yor\'s secret life as the "Thorn Princess" leads to unexpected complications.'; ?>
            </p>
        </div>
    </div>

    <div class="container details-content-grid">
        <div class="details-sidebar">
            <div class="info-block">
                <div class="info-item">
                    <span class="label">Format</span>
                    <span class="value"><?php echo !empty($anime['type']) ? $anime['type'] : 'TV'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Episodes</span>
                    <span class="value">12</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value"><?php echo !empty($anime['status']) ? $anime['status'] : 'Finished'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Season</span>
                    <span
                        class="value"><?php echo (!empty($anime['season']) && !empty($anime['year'])) ? $anime['season'] . ' ' . $anime['year'] : 'Fall 2023'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Average Score</span>
                    <span class="value">85%</span>
                </div>
                <div class="info-item">
                    <span class="label">Studios</span>
                    <span class="value">WIT Studio, CloverWorks</span>
                </div>
                <div class="info-item">
                    <span class="label">Genres</span>
                    <span
                        class="value"><?php echo !empty($anime['genres']) ? $anime['genres'] : 'Action, Comedy'; ?></span>
                </div>
            </div>

            <div class="sidebar-section">
                <h4>Tags</h4>
                <div class="tags-list">
                    <span class="tag">Espionage</span>
                    <span class="tag">Family Life</span>
                    <span class="tag">School</span>
                    <span class="tag">Assassin</span>
                </div>
            </div>
        </div>

        <div class="details-body">
            <section class="content-section">
                <h3>Characters</h3>
                <div class="character-grid">
                    <?php
                    $characters = (!empty($anime['id']) ? getCharactersByAnimeId($con, $anime['id']) : null) ?: [
                        ['name' => 'Loid Forger', 'role' => 'Main', 'image_url' => 'img/loid-main.jpg'],
                        ['name' => 'Anya Forger', 'role' => 'Main', 'image_url' => 'img/anya-main.jpg'],
                        ['name' => 'Yor Forger', 'role' => 'Main', 'image_url' => 'img/yor-main.jpg']
                    ];

                    foreach ($characters as $char) {
                        ?>
                        <div class="character-card">
                            <div class="char-img">
                                <img src="<?php echo $char['image_url']; ?>" alt="<?php echo $char['name']; ?>">
                            </div>
                            <div class="char-details">
                                <div class="char-name"><?php echo $char['name']; ?></div>
                                <div class="char-role"><?php echo $char['role']; ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', () => {
            const favBtn = document.getElementById('fav-btn');

            const currentAnime = {
                title: "Spy x Family Season 2",
                cover: "img/spyfam.jfif",
                url: "details-spy-family.php"
            };

            const favorites = JSON.parse(localStorage.getItem('aniCraveFavorites')) || [];
            const isFavorite = favorites.some(anime => anime.title === currentAnime.title);

            if (isFavorite) {
                favBtn.style.backgroundColor = '#ff6b6b';
                favBtn.innerHTML = '<span>Added to Favorites</span> <i class="fa-solid fa-heart"></i>';
            }

            favBtn.addEventListener('click', () => {
                let favorites = JSON.parse(localStorage.getItem('aniCraveFavorites')) || [];
                const isFav = favorites.some(anime => anime.title === currentAnime.title);

                if (!isFav) {
                    favorites.push(currentAnime);
                    localStorage.setItem('aniCraveFavorites', JSON.stringify(favorites));
                    favBtn.style.backgroundColor = '#ff6b6b';
                    favBtn.innerHTML = '<span>Added to Favorites</span> <i class="fa-solid fa-heart"></i>';
                } else {
                    favorites = favorites.filter(anime => anime.title !== currentAnime.title);
                    localStorage.setItem('aniCraveFavorites', JSON.stringify(favorites));
                    favBtn.style.backgroundColor = '';
                    favBtn.innerHTML = '<span>Add to Favorites</span> <i class="fa-regular fa-heart"></i>';
                }
            });
        });
    </script>
</body>

</html>