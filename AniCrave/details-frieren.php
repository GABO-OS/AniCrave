<?php
include 'connect.php';
$anime = getAnimeByTitle($con, "Frieren: Beyond Journey's End") ?: [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frieren: Beyond Journey's End - AniCrave</title>
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

    <!-- Banner Section -->
    <div class="details-banner"
        style="background-image: url('<?php echo !empty($anime['banner_image']) ? $anime['banner_image'] : 'img/freiren-banner.jpg'; ?>');">
        <div class="banner-shadow"></div>
    </div>


    <div class="container details-header-container">
        <div class="details-cover">
            <img src="<?php echo $anime['cover_image'] ?? 'img/freiren.jpg'; ?>" alt="Frieren Cover">
            <div class="action-buttons">
                <button class="btn-action-fav" id="fav-btn">
                    <span>Add to Favorites</span>
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="details-title-section">
            <h1>Frieren: Beyond Journey's End</h1>
            <p class="breadcrumbs">Sousou no Frieren</p> <!-- English/Alternative title as breadcrumb/subtitle -->
            <p class="description-text">
                <?php echo !empty($anime['description']) ? nl2br($anime['description']) : 'The Demon King has been defeated, and the victorious party returns home before disbanding. The four heroes—mage Frieren, hero Himmel, priest Heiter, and warrior Eisen—reminisce about their decade-long journey as the moment to bid each other farewell arrives. But the passing of time is different for elves, thus Frieren witnesses her companions slowly pass away one by one.<br><br>Before his death, Heiter manages to foist a young human apprentice called Fern onto Frieren. Driven by the elf\'s passion for collecting a myriad of magic spells, the pair embarks on a seemingly aimless journey, revisiting the places that the heroes of yore had visited. Along their travels, Frieren slowly confronts her regrets of missed opportunities to form deeper bonds with her now-deceased comrades.'; ?>
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="container details-content-grid">
        <!-- Sidebar Info -->
        <div class="details-sidebar">
            <div class="info-block">
                <div class="info-item">
                    <span class="label">Format</span>
                    <span class="value"><?php echo !empty($anime['type']) ? $anime['type'] : 'TV'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Episodes</span>
                    <span class="value">28</span>
                </div>
                <div class="info-item">
                    <span class="label">Episode Duration</span>
                    <span class="value">24 mins</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value"><?php echo !empty($anime['status']) ? $anime['status'] : 'Finished'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Start Date</span>
                    <span class="value">Sep 29, 2023</span>
                </div>
                <div class="info-item">
                    <span class="label">Season</span>
                    <span
                        class="value"><?php echo (!empty($anime['season']) && !empty($anime['year'])) ? $anime['season'] . ' ' . $anime['year'] : 'Fall 2023'; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Average Score</span>
                    <span class="value">91%</span>
                </div>
                <div class="info-item">
                    <span class="label">Studios</span>
                    <span class="value">Madhouse</span>
                </div>
                <div class="info-item">
                    <span class="label">Genres</span>
                    <span
                        class="value"><?php echo !empty($anime['genres']) ? $anime['genres'] : 'Adventure, Drama, Fantasy'; ?></span>
                </div>
            </div>

            <div class="sidebar-section">
                <h4>Tags</h4>
                <div class="tags-list">
                    <span class="tag">Magic</span>
                    <span class="tag">Iyashikei</span>
                    <span class="tag">Elf</span>
                    <span class="tag">Female Protagonist</span>
                </div>
            </div>
        </div>

        <!-- Main Body (Relations, Characters, Staff, etc.) -->
        <div class="details-body">
            <section class="content-section">
                <h3>Characters</h3>
                <div class="character-grid">
                    <?php
                    $characters = (!empty($anime['id']) ? getCharactersByAnimeId($con, $anime['id']) : null) ?: [
                        ['name' => 'Frieren', 'role' => 'Main', 'image_url' => 'img/freiren-main.jfif'],
                        ['name' => 'Fern', 'role' => 'Main', 'image_url' => 'img/fern-main.jpg'],
                        ['name' => 'Stark', 'role' => 'Main', 'image_url' => 'img/stark-main.jfif']
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
        document.addEventListener('DOMContentLoaded', () => {
            const favBtn = document.getElementById('fav-btn');

            const currentAnime = {
                title: "Frieren: Beyond Journey's End",
                cover: "img/freiren.jpg",
                url: "details-frieren.php"
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