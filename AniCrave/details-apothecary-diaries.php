<?php
// Magsimula ng session upang ma-access ang user information (tulad ng $_SESSION['user_id'])
session_start();

// Isama ang connect.php para magkaroon ng access sa database connection ($con) at functions
include 'connect.php';

// Hanapin ang detalye ng anime base sa pamagat gamit ang utility function na getAnimeByTitle
$anime = getAnimeByTitle($con, 'The Apothecary Diaries');

// Kung walang nahanap na anime, bumalik sa index.php
if (!$anime) {
    header('Location: index.php');
    exit();
}

// Kunin ang lahat ng characters na kabilang sa anime na ito gamit ang anime ID
$characters = getCharactersByAnimeId($con, $anime['id']);

// Default state: hindi favorite ang anime na ito
$is_favorite = false;

// Kung ang user ay naka-login, suriin kung ang anime na ito ay nasa kanilang favorites list sa database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $anime_id = $anime['id'];

    // SQL query para hanapin ang records sa favorites table gamit ang user_id at anime_id
    $check_sql = "SELECT id FROM favorites WHERE user_id = '$user_id' AND anime_id = '$anime_id'";
    $check_result = mysqli_query($con, $check_sql);

    // Kung may nahanap na row, ibig sabihin ay nasa favorites na ito ng user
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $is_favorite = true;
    }
}
?>

<!-- Isama ang header component ng website -->
<?php include 'includes/header.php'; ?>

<!-- Banner section: nagpapakita ng malaking imahe sa itaas ng pahina -->
<div class="details-banner"
    style="background-image: url('<?php echo $anime['banner_image'] ?? 'img/diaries-banner.png'; ?>');">
    <!-- Gradient shadow para sa visual effect sa ilalim ng banner -->
    <div class="banner-shadow"></div>
</div>

<!-- Main content container para sa header info ng anime -->
<div class="container details-header-container">
    <!-- Bahagi ng pabalat (cover) at action buttons -->
    <div class="details-cover">
        <!-- Ipakita ang cover image ng anime; kung wala, gumamit ng fallback -->
        <img src="<?php echo $anime['cover_image'] ?? 'img/diaries.png'; ?>" alt="The Apothecary Diaries Cover">

        <!-- Buttons para sa interaction (tulad ng Favorite) -->
        <div class="action-buttons">
            <!-- Favorite button: nagbabago ang hitsura base sa $is_favorite status -->
            <button class="btn-action-fav <?php echo $is_favorite ? 'active' : ''; ?>" id="fav-btn"
                data-id="<?php echo $anime['id']; ?>"
                style="<?php echo $is_favorite ? 'background-color: #ff6b6b;' : ''; ?>">
                <!-- Ipakita ang tamang text base sa status -->
                <span><?php echo $is_favorite ? 'Added to Favorites' : 'Add to Favorites'; ?></span>
                <!-- Ipakita ang tamang heart icon (solid kung favorite, regular kung hindi) -->
                <i class="fa-<?php echo $is_favorite ? 'solid' : 'regular'; ?> fa-heart"></i>
            </button>
        </div>
    </div>

    <!-- Title at description section -->
    <div class="details-title-section">
        <!-- Pamagat ng anime -->
        <h1>The Apothecary Diaries</h1>
        <!-- Romaji or Alternative Title -->
        <p class="breadcrumbs">Kusuriya no Hitorigoto</p>
        <!-- Story summary / Description -->
        <p class="description-text">
            Maomao, a young woman trained in the art of herbal medicine, is forced to work as a lowly servant in the
            inner palace. Though she yearns for her life outside its walls, she isn't one to complain.
            <br><br>
            When she hears that the emperor's infants are falling ill, she begins to investigate the cause, using
            her knowledge of poisons and medicine to solve the mysteries of the court. Her intelligence soon catches
            the eye of a powerful eunuch, Jinshi, who enlists her help in navigating the dangerous political waters
            of the palace.
        </p>
    </div>
</div>

<!-- Grid layout para sa sidebar (stats) at main body (characters) -->
<div class="container details-content-grid">
    <!-- Sidebar: nagpapakita ng metadata gaya ng genre, episodes, at status -->
    <div class="details-sidebar">
        <div class="info-block">
            <!-- Format: TV, Movie, etc. -->
            <div class="info-item">
                <span class="label">Format</span>
                <span class="value">TV</span>
            </div>
            <!-- Bilang ng episodes -->
            <div class="info-item">
                <span class="label">Episodes</span>
                <span class="value">24</span>
            </div>
            <!-- Status: Finished, Ongoing -->
            <div class="info-item">
                <span class="label">Status</span>
                <span class="value">Finished</span>
            </div>
            <!-- Season kung kailan ipinalabas -->
            <div class="info-item">
                <span class="label">Season</span>
                <span class="value">Fall 2023</span>
            </div>
            <!-- Average score base sa ratings -->
            <div class="info-item">
                <span class="label">Average Score</span>
                <span class="value">88%</span>
            </div>
            <!-- Studios na gumawa ng anime -->
            <div class="info-item">
                <span class="label">Studios</span>
                <span class="value">TOHO animation STUDIO, OLM</span>
            </div>
            <!-- Genres list -->
            <div class="info-item">
                <span class="label">Genres</span>
                <span class="value">Drama, Mystery</span>
            </div>
        </div>

        <!-- Tags section para sa mas specific na categories -->
        <div class="sidebar-section">
            <h4>Tags</h4>
            <div class="tags-list">
                <span class="tag">Historical</span>
                <span class="tag">Medical</span>
                <span class="tag">Palace</span>
                <span class="tag">Detective</span>
            </div>
        </div>
    </div>

    <!-- Main Body: Pangunahing nilalaman ng pahina -->
    <div class="details-body">
        <section class="content-section">
            <!-- List ng mga characters sa kabilang sa serye -->
            <h3>Characters</h3>
            <!-- Grid container para sa character cards -->
            <div class="character-grid">
                <?php
                // Hanapin ang characters sa DB; kung wala, gumamit ng hardcoded default data
                $characters = getCharactersByAnimeId($con, $anime['id']) ?: [
                    ['name' => 'Maomao', 'role' => 'Main', 'image_url' => 'img/maomao-main.jpg'],
                    ['name' => 'Jinshi', 'role' => 'Main', 'image_url' => 'img/jinshi-main.webp']
                ];

                // I-loop ang bawat character para ma-render sa HTML
                foreach ($characters as $char) {
                    ?>
                    <div class="character-card">
                        <!-- Imahe ng character -->
                        <div class="char-img">
                            <img src="<?php echo $char['image_url']; ?>" alt="<?php echo $char['name']; ?>">
                        </div>
                        <!-- Detalye: Pangalan at Role (Main/Supporting) -->
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

<!-- Isama ang footer component ng website -->
<?php include 'includes/footer.php'; ?>

<!-- Client-side logic gamit ang JavaScript -->
<script>
    // Siguraduhin na loaded na ang DOM bago patakbuhin ang script
    document.addEventListener('DOMContentLoaded', () => {
        // Kunin ang favorite button element
        const favBtn = document.getElementById('fav-btn');

        // Magdagdag ng click event listener sa favorite button
        favBtn.addEventListener('click', () => {
            // Kunin ang anime ID mula sa data-id attribute ng button
            const animeId = favBtn.getAttribute('data-id');

            // Tumawag sa toggle_favorite.php API gamit ang fetch
            fetch('toggle_favorite.php', {
                method: 'POST', // Gamit ang POST method para magpadala ng data
                headers: {
                    'Content-Type': 'application/json', // Ipaalam sa server na JSON ang ipinadalang body
                },
                // I-convert ang JS object sa JSON string
                body: JSON.stringify({ anime_id: animeId })
            })
                // I-parse ang server response bilang JSON
                .then(response => response.json())
                .then(data => {
                    // Kung matagumpay ang request sa server
                    if (data.status === 'success') {
                        // Kung ang anime ay idinagdag sa favorites
                        if (data.action === 'added') {
                            // Baguhin ang kulay at text ng button para maging "Added"
                            favBtn.style.backgroundColor = '#ff6b6b';
                            favBtn.innerHTML = '<span>Added to Favorites</span> <i class="fa-solid fa-heart"></i>';

                            // Ipakita ang success alert gamit ang SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: 'Added!',
                                text: 'Anime has been added to your favorites.',
                                confirmButtonColor: '#3DB4F2',
                                timer: 1500, // Awtomatikong mawawala pagkaraan ng 1.5 segundo
                                showConfirmButton: false
                            });
                        } else {
                            // Kung ang anime ay tinanggal sa favorites
                            // Ibalik sa orihinal na hitsura ang button
                            favBtn.style.backgroundColor = '';
                            favBtn.innerHTML = '<span>Add to Favorites</span> <i class="fa-regular fa-heart"></i>';

                            // Ipakita ang notification na tinanggal na ang anime
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: 'Anime has been removed from your favorites.',
                                confirmButtonColor: '#3DB4F2',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        // Kung may error o hindi naka-login ang user
                        Swal.fire({
                            icon: 'error',
                            title: 'Wait!',
                            text: data.message || 'Please login to add favorites.',
                            confirmButtonColor: '#3DB4F2'
                        });
                    }
                })
                // Saluhin ang anumang network or server errors
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to communicate with the server.',
                        confirmButtonColor: '#3DB4F2'
                    });
                });
        });
    });
</script>
</body>

</html>