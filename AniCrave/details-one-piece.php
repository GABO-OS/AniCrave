<?php
include 'connect.php';
$anime = getAnimeByTitle($con, "One Piece");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Piece - AniCrave</title>
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
        style="background-image: url('<?php echo $anime['banner_image'] ?? 'img/op-banner.jpg'; ?>');">
        <div class="banner-shadow"></div>
    </div>


    <div class="container details-header-container">
        <div class="details-cover">
            <img src="<?php echo $anime['cover_image'] ?? 'img/op.avif'; ?>" alt="One Piece Cover">
            <div class="action-buttons">
                <button class="btn-action-fav" id="fav-btn">
                    <span>Add to Favorites</span>
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="details-title-section">
            <h1>One Piece</h1>
            <p class="breadcrumbs">ONE PIECE</p>
            <p class="description-text">
                Monkey D. Luffy, a boy whose body gained the properties of rubber after unintentionally eating a Devil
                Fruit, sets off from the East Blue Sea in search of the titular "One Piece" treasure and to claim the
                title of King of the Pirates.
                <br><br>
                Along his journey, he recruits a diverse crew, the Straw Hat Pirates, including a swordsman, a
                navigator, a sniper, a cook, a doctor, an archaeologist, a shipwright, a musician, and a helmsman.
                Together, they face powerful enemies and explore the vast, wondrous world of the Grand Line.
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
                    <span class="value">1100+</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value">Releasing</span>
                </div>
                <div class="info-item">
                    <span class="label">Year</span>
                    <span class="value">1999 - Present</span>
                </div>
                <div class="info-item">
                    <span class="label">Average Score</span>
                    <span class="value">88%</span>
                </div>
                <div class="info-item">
                    <span class="label">Studios</span>
                    <span class="value">Toei Animation</span>
                </div>
                <div class="info-item">
                    <span class="label">Genres</span>
                    <span class="value">Action, Adventure, Comedy, Fantasy</span>
                </div>
            </div>

            <div class="sidebar-section">
                <h4>Tags</h4>
                <div class="tags-list">
                    <span class="tag">Pirates</span>
                    <span class="tag">Super Power</span>
                    <span class="tag">Shounen</span>
                    <span class="tag">Expansive World</span>
                </div>
            </div>
        </div>

        <div class="details-body">
            <section class="content-section">
                <h3>Characters</h3>
                <div class="character-grid">
                    <?php
                    $characters = getCharactersByAnimeId($con, $anime['id']) ?: [
                        ['name' => 'Monkey D. Luffy', 'role' => 'Captain', 'image_url' => 'img/luffy.jpg'],
                        ['name' => 'Roronoa Zoro', 'role' => 'Swordsman', 'image_url' => 'img/zoro.jpg'],
                        ['name' => 'Nami', 'role' => 'Navigator', 'image_url' => 'img/nami.jpg'],
                        ['name' => 'Vinsmoke Sanji', 'role' => 'Cook', 'image_url' => 'img/sanji.jpg'],
                        ['name' => 'Tony Tony Chopper', 'role' => 'Doctor', 'image_url' => 'img/chopper.jpg'],
                        ['name' => 'Ussop', 'role' => 'Sniper', 'image_url' => 'img/usopp.jpg'],
                        ['name' => 'Brook', 'role' => 'Musician', 'image_url' => 'img/brook.jpg'],
                        ['name' => 'Franky', 'role' => 'Shipwright', 'image_url' => 'img/franky.jpg'],
                        ['name' => 'Jimbei', 'role' => 'Helmsman', 'image_url' => 'img/jinbe.jpg'],
                        ['name' => 'Nico Robin', 'role' => 'Archaeologist', 'image_url' => 'img/robin.jpg']
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
                title: "One Piece",
                cover: "img/op.avif",
                url: "details-one-piece.php"
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