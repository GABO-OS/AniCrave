<?php
// Start yung session para ma-track ang login status
session_start();
// Include natin yung connect.php para sa database access
include 'connect.php';

// Pag-load ng "Pick by Admin" section gamit ang function sa connect.php
$admin_picks = getAnimeBySection($con, 'PICK BY ADMIN');

// Pag-fetch ng mga anime na "Trending Now"
$trending_anime = getAnimeBySection($con, 'TRENDING NOW');

// Pag-fetch ng mga anime na sikat ngayong season
$popular_anime = getAnimeBySection($con, 'POPULAR THIS SEASON');
?>

<?php
// Display yung header component
include 'includes/header.php';
?>

<!-- Hero Section: Welcome banner -->
<section class="hero">
    <div class="container hero-container">
        <h1>The next-generation anime platform</h1>
        <p class="hero-subtitle">Track, share, and discover your favorite anime and manga with AniCrave.</p>

        <!-- CTA button papunta sa login page -->
        <a href="login.php" class="cta-button">Join Now <i class="fa-solid fa-angle-right"></i></a>
    </div>
</section>

<!-- Filter Section: UI para sa search at filters -->
<section class="filters-section">
    <div class="container">
        <div class="filters-bar">
            <!-- Search input field -->
            <div class="search-input-group">
                <label>Search</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="search-input">
                </div>
            </div>

            <!-- Genre selection dropdown -->
            <div class="filter-group">
                <label>Genres</label>
                <select id="genre-filter">
                    <option value="">Any</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Drama">Drama</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                </select>
            </div>

            <!-- Year selection dropdown -->
            <div class="filter-group">
                <label>Year</label>
                <select id="year-filter">
                    <option value="">Any</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                </select>
            </div>

            <!-- Season selection dropdown -->
            <div class="filter-group">
                <label>Season</label>
                <select id="season-filter">
                    <option value="">Any</option>
                    <option value="Fall">Fall</option>
                    <option value="Summer">Summer</option>
                    <option value="Spring">Spring</option>
                    <option value="Winter">Winter</option>
                </select>
            </div>

        </div>
    </div>
</section>

<!-- Content Sections: Grid display ng anime cards -->
<main class="content-wrapper">
    <div class="container">

        <!-- Pick by Admin Section -->
        <div class="section-header">
            <h2 style="color: var(--primary-blue);"><i class="fa-solid fa-star" style="margin-right: 10px;"></i>PICK BY
                ADMIN</h2>
        </div>
        <div class="anime-grid">
            <?php
            // I-loop yung bawat anime card sa "Pick by Admin" section
            foreach ($admin_picks as $anime): ?>
                <a href="details.php?id=<?php echo $anime['id']; ?>" class="anime-card"
                    data-title="<?php echo htmlspecialchars($anime['title']); ?>"
                    data-genres="<?php echo htmlspecialchars($anime['genres']); ?>"
                    data-year="<?php echo $anime['year']; ?>"
                    data-season="<?php echo htmlspecialchars($anime['season']); ?>">
                    <div class="cover-image" style="background-color: #333;">
                        <!-- Pag walang cover image, gamitin yung default-cover.jpg -->
                        <img src="<?php echo !empty($anime['cover_image']) ? $anime['cover_image'] : 'img/default-cover.jpg'; ?>"
                            alt="<?php echo htmlspecialchars($anime['title']); ?>">
                    </div>
                    <div class="card-title"><?php echo htmlspecialchars($anime['title']); ?></div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Trending Section -->
        <div class="section-header" style="margin-top: 40px;">
            <h2>TRENDING NOW</h2>
        </div>
        <div class="anime-grid">
            <?php foreach ($trending_anime as $anime): ?>
                <a href="details.php?id=<?php echo $anime['id']; ?>" class="anime-card"
                    data-title="<?php echo htmlspecialchars($anime['title']); ?>"
                    data-genres="<?php echo htmlspecialchars($anime['genres']); ?>"
                    data-year="<?php echo $anime['year']; ?>"
                    data-season="<?php echo htmlspecialchars($anime['season']); ?>">
                    <div class="cover-image" style="background-color: #333;">
                        <img src="<?php echo !empty($anime['cover_image']) ? $anime['cover_image'] : 'img/default-cover.jpg'; ?>"
                            alt="<?php echo htmlspecialchars($anime['title']); ?>">
                    </div>
                    <div class="card-title"><?php echo htmlspecialchars($anime['title']); ?></div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Popular Section (Restored) -->
        <div class="section-header" style="margin-top: 40px;">
            <h2>POPULAR THIS SEASON</h2>
        </div>
        <div class="anime-grid">
            <?php foreach ($popular_anime as $anime): ?>
                <a href="details.php?id=<?php echo $anime['id']; ?>" class="anime-card"
                    data-title="<?php echo htmlspecialchars($anime['title']); ?>"
                    data-genres="<?php echo htmlspecialchars($anime['genres']); ?>"
                    data-year="<?php echo $anime['year']; ?>"
                    data-season="<?php echo htmlspecialchars($anime['season']); ?>">
                    <div class="cover-image" style="background-color: #333;">
                        <img src="<?php echo !empty($anime['cover_image']) ? $anime['cover_image'] : 'img/default-cover.jpg'; ?>"
                            alt="<?php echo htmlspecialchars($anime['title']); ?>">
                    </div>
                    <div class="card-title"><?php echo htmlspecialchars($anime['title']); ?></div>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php
// Display yung footer component
include 'includes/footer.php';
?>

<script>
    // Hintayin muna ma-load yung DOM bago i-run yung script
    document.addEventListener('DOMContentLoaded', () => {
        // Grab values from filter inputs
        const searchInput = document.getElementById('search-input');
        const genreSelect = document.getElementById('genre-filter');
        const yearSelect = document.getElementById('year-filter');
        const seasonSelect = document.getElementById('season-filter');

        // Select lahat ng anime cards
        const animeCards = document.querySelectorAll('.anime-card');

        // Main filter function para sa Search at Dropdowns
        function filterAnime() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedGenre = genreSelect.value;
            const selectedYear = yearSelect.value;
            const selectedSeason = seasonSelect.value;

            animeCards.forEach(card => {
                // Kunin yung data attributes ng bawat card para i-compare sa filter
                const title = card.getAttribute('data-title').toLowerCase();
                const genres = card.getAttribute('data-genres') || '';
                const year = card.getAttribute('data-year') || '';
                const season = card.getAttribute('data-season') || '';

                // Tignan kung nagma-match lahat ng piniling filter
                const matchesSearch = title.includes(searchTerm);
                const matchesGenre = selectedGenre === '' || genres.includes(selectedGenre);
                const matchesYear = selectedYear === '' || year === selectedYear;
                const matchesSeason = selectedSeason === '' || season === selectedSeason;

                // Hanapin kung dapat bang ipakita o itago yung card
                if (matchesSearch && matchesGenre && matchesYear && matchesSeason) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Setup event listeners for filtering tuwing may pagbabago
        searchInput.addEventListener('input', filterAnime);
        genreSelect.addEventListener('change', filterAnime);
        yearSelect.addEventListener('change', filterAnime);
        seasonSelect.addEventListener('change', filterAnime);
    });
</script>
</body>

</html>