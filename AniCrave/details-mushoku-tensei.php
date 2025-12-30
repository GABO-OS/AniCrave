<?php
include 'connect.php';
$anime = getAnimeByTitle($con, "Mushoku Tensei: Jobless Reincarnation Season 2");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mushoku Tensei: Jobless Reincarnation Season 2 - AniCrave</title>
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
        style="background-image: url('<?php echo $anime['banner_image'] ?? 'img/tensei-banner.webp'; ?>');">
        <div class="banner-shadow"></div>
    </div>


    <div class="container details-header-container">
        <div class="details-cover">
            <img src="<?php echo $anime['cover_image'] ?? 'img/tensei.webp'; ?>"
                alt="Mushoku Tensei Cover">
            <div class="action-buttons">
                <button class="btn-action-fav" id="fav-btn">
                    <span>Add to Favorites</span>
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="details-title-section">
            <h1>Mushoku Tensei: Jobless Reincarnation Season 2</h1>
            <p class="breadcrumbs">Mushoku Tensei II: Isekai Ittara Honki Dasu</p>
            <p class="description-text">
                Rudeus Greyrat's journey continues in the second season, as he deals with the aftermath of the
                Mana Calamity and his separation from Eris. Now heading north, he aims to find his mother, Zenith,
                while carving out a name for himself as a powerful adventurer.
                <br><br>
                This season focuses on Rudeus's growth as an individual, his experiences at the Ranoa Academy of Magic,
                and his reunion with familiar faces from his past. The world continues to expand, revealing more of its
                rich history and the complex lives of those who inhabit it.
            </p>
        </div>
    </div>

    <div class="container details-content-grid">
        <div class="details-sidebar">
            <div class="info-block">
                <div class="info-item">
                    <span class="label">Format</span>
                    <span class="value">TV</span>
                </div>
                <div class="info-item">
                    <span class="label">Episodes</span>
                    <span class="value">24</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value">Finished</span>
                </div>
                <div class="info-item">
                    <span class="label">Season</span>
                    <span class="value">Summer 2023 - Spring 2024</span>
                </div>
                <div class="info-item">
                    <span class="label">Average Score</span>
                    <span class="value">83%</span>
                </div>
                <div class="info-item">
                    <span class="label">Studios</span>
                    <span class="value">Studio Bind</span>
                </div>
                <div class="info-item">
                    <span class="label">Genres</span>
                    <span class="value">Adventure, Drama, Fantasy</span>
                </div>
            </div>

            <div class="sidebar-section">
                <h4>Tags</h4>
                <div class="tags-list">
                    <span class="tag">Isekai</span>
                    <span class="tag">Magic</span>
                    <span class="tag">Coming of Age</span>
                    <span class="tag">Ecchi</span>
                </div>
            </div>
        </div>

        <div class="details-body">
            <section class="content-section">
                <h3>Characters</h3>
                <div class="character-grid">
                    <?php
                    $characters = getCharactersByAnimeId($con, $anime['id']) ?: [
                        ['name' => 'Rudeus Greyrat', 'role' => 'Main', 'image_url' => 'img/rudeus.jpg'],
                        ['name' => 'Sylphitte (Fitz)', 'role' => 'Rudeus First Wife', 'image_url' => 'fitz-main.jfif'],
                        ['name' => 'Roxy Migurdia', 'role' => 'Rudeus Second Wife', 'image_url' => 'roxy-main.webp'],
                        ['name' => 'Eris Boreas Greyrat', 'role' => 'Rudeus Third Wife', 'image_url' => 'eris-main.webp'],
                        ['name' => 'Norn Greyrat & Aisha Greyrat', 'role' => 'Young Half-Sisters', 'image_url' => 'img/norn & aisha-main.webp'],
                        ['name' => 'Zenith Greyrat', 'role' => 'Rudeus Mother', 'image_url' => 'img/zenith-main.jpeg']

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
                title: "Mushoku Tensei: Jobless Reincarnation Season 2",
                cover: "img/tensei.webp",
                url: "details-mushoku-tensei.php"
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