<?php
include 'connect.php';
$anime = getAnimeByTitle($con, "Kimetsu no Yaiba: Swordsmith Village Arc");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kimetsu no Yaiba: Swordsmith Village Arc - AniCrave</title>
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
        style="background-image: url('<?php echo $anime['banner_image'] ?? 'img/demon-banner.webp'; ?>');">
        <div class="banner-shadow"></div>
    </div>


    <div class="container details-header-container">
        <div class="details-cover">
            <img src="<?php echo $anime['cover_image'] ?? 'img/demon.jpg'; ?>"
                alt="Demon Slayer Cover">
            <div class="action-buttons">
                <button class="btn-action-fav" id="fav-btn">
                    <span>Add to Favorites</span>
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="details-title-section">
            <h1>Kimetsu no Yaiba: Swordsmith Village Arc</h1>
            <p class="breadcrumbs">Demon Slayer: Swordsmith Village Arc</p>
            <p class="description-text">
                Tanjiro's journey leads him to the Swordsmith Village, where he must have his sword repaired by the
                legendary smith, Hotaru Haganezuka.
                <br><br>
                However, danger follows as Upper Rank demons from Muzan Kibutsuji's elite appear to lay waste to the
                village. Tanjiro, alongside the Love Hashira Mitsuri Kanroji and the Mist Hashira Muichiro Tokito, must
                defend the smiths and uncover new strengths to survive the onslaught.
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
                    <span class="value">11</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value">Finished</span>
                </div>
                <div class="info-item">
                    <span class="label">Season</span>
                    <span class="value">Spring 2023</span>
                </div>
                <div class="info-item">
                    <span class="label">Average Score</span>
                    <span class="value">84%</span>
                </div>
                <div class="info-item">
                    <span class="label">Studios</span>
                    <span class="value">ufotable</span>
                </div>
                <div class="info-item">
                    <span class="label">Genres</span>
                    <span class="value">Action, Fantasy</span>
                </div>
            </div>

            <div class="sidebar-section">
                <h4>Tags</h4>
                <div class="tags-list">
                    <span class="tag">Historical</span>
                    <span class="tag">Samurai</span>
                    <span class="tag">Demons</span>
                    <span class="tag">Supernatural</span>
                </div>
            </div>
        </div>

        <div class="details-body">
            <section class="content-section">
                <h3>Characters</h3>
                <div class="character-grid">
                    <?php
                    $characters = getCharactersByAnimeId($con, $anime['id']) ?: [
                        ['name' => 'Tanjiro Kamado', 'role' => 'Water/Sun Breathing', 'image_url' => 'img/tanjiro-main.webp'],
                        ['name' => 'Nezuko Kamado', 'role' => 'Demon Sister of Tanjiro', 'image_url' => 'img/nezuko-main.jpg'],
                        ['name' => 'Zenitsu Agatsuma', 'role' => 'Thunder Breathing', 'image_url' => 'img/zenitsu-main.jpg'],
                        ['name' => 'Inosuke Hashibira', 'role' => 'Beast Breathing', 'image_url' => 'img/inosuke-main.jpg']
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
                title: "Kimetsu no Yaiba: Swordsmith Village Arc",
                cover: "img/demon.jpg",
                url: "details-demon-slayer.php"
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