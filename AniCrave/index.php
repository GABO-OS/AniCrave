<?php
// Start yung session para ma-track ang login status
session_start();
// Include natin yung connect.php para sa database access
include 'connect.php';

// Fetch details para sa "Trending Now" section
$frieren = getAnimeByTitle($con, "Frieren: Beyond Journey's End");
$spyfam = getAnimeByTitle($con, "Spy x Family Season 2");
$diaries = getAnimeByTitle($con, "The Apothecary Diaries");
$shangrila = getAnimeByTitle($con, "Shangri-La Frontier");
$solo = getAnimeByTitle($con, "Solo Leveling");

// Fetch details para sa "Popular This Season" section
$aot = getAnimeByTitle($con, "Attack on Titan Final Season");
$onepiece = getAnimeByTitle($con, "One Piece");
$jjk = getAnimeByTitle($con, "Jujutsu Kaisen 2nd Season");
$demonslayer = getAnimeByTitle($con, "Kimetsu no Yaiba: Swordsmith Village Arc");
$mushoku = getAnimeByTitle($con, "Mushoku Tensei: Jobless Reincarnation Season 2");
?>

<?php
// Display yung header component
include 'includes/header.php';
?>

<!-- Hero Section: Welcome banner -->
<section class="hero">
    <div class="container hero-container">
        <h1>The next-generation anime platform</h1>
        <p class="hero-subtitle">Track, share, and discover your favorite anime and manga with AniList.</p>

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
        <div class="section-header">
            <h2>TRENDING NOW</h2>
        </div>
        <div class="anime-grid" id="anime-list">
            <!-- Frieren Card -->
            <a href="details-frieren.php" class="anime-card" data-title="Frieren: Beyond Journey's End"
                data-genres="Adventure, Drama, Fantasy" data-year="2023" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($frieren['cover_image']) ? $frieren['cover_image'] : 'img/freiren.jpg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Frieren: Beyond Journey's End</div>
            </a>
            <!-- Spy x Family Card -->
            <a href="details-spy-family.php" class="anime-card" data-title="Spy x Family Season 2"
                data-genres="Action, Comedy" data-year="2023" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($spyfam['cover_image']) ? $spyfam['cover_image'] : 'img/spyfam.jpg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Spy x Family Season 2</div>
            </a>
            <!-- Apothecary Diaries Card -->
            <a href="details-apothecary-diaries.php" class="anime-card" data-title="The Apothecary Diaries"
                data-genres="Drama, Mystery" data-year="2023" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($diaries['cover_image']) ? $diaries['cover_image'] : 'img/diaries.jpg'; ?>"
                        alt="The Apothecary Diaries Cover">
                </div>
                <div class="card-title">The Apothecary Diaries</div>
            </a>
            <!-- Shangri-La Frontier Card -->
            <a href="details-shangrila-frontier.php" class="anime-card" data-title="Shangri-La Frontier"
                data-genres="Action, Adventure, Fantasy" data-year="2023" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($shangrila['cover_image']) ? $shangrila['cover_image'] : 'img/shangri-la.jpg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Shangri-La Frontier</div>
            </a>
            <!-- Solo Leveling Card -->
            <a href="details-solo-leveling.php" class="anime-card" data-title="Solo Leveling"
                data-genres="Action, Adventure, Fantasy" data-year="2024" data-season="Winter">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($solo['cover_image']) ? $solo['cover_image'] : 'img/solo-leveling.avif'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Solo Leveling</div>
            </a>
        </div>

        <!-- Popular Section Grid -->
        <div class="section-header" style="margin-top: 40px;">
            <h2>POPULAR THIS SEASON</h2>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="anime-grid">
            <!-- AOT Card -->
            <a href="details-aot.php" class="anime-card" data-title="Attack on Titan Final Season"
                data-genres="Action, Drama" data-year="2023" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($aot['cover_image']) ? $aot['cover_image'] : 'img/aot.jpeg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Attack on Titan Final Season</div>
            </a>
            <!-- One Piece Card -->
            <a href="details-one-piece.php" class="anime-card" data-title="One Piece" data-genres="Action, Adventure"
                data-year="1999" data-season="Fall">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($onepiece['cover_image']) ? $onepiece['cover_image'] : 'img/op.avif'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">One Piece</div>
            </a>
            <!-- JJK Card -->
            <a href="details-jjk.php" class="anime-card" data-title="Jujutsu Kaisen 2nd Season"
                data-genres="Action, Fantasy" data-year="2023" data-season="Summer">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($jjk['cover_image']) ? $jjk['cover_image'] : 'img/jjk.jpg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Jujutsu Kaisen 2nd Season</div>
            </a>
            <!-- Demon Slayer Card -->
            <a href="details-demon-slayer.php" class="anime-card" data-title="Kimetsu no Yaiba: Swordsmith Village Arc"
                data-genres="Action, Fantasy" data-year="2023" data-season="Spring">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($demonslayer['cover_image']) ? $demonslayer['cover_image'] : 'img/demon.jpg'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Kimetsu no Yaiba: Swordsmith Village Arc</div>
            </a>
            <!-- Mushoku Tensei Card -->
            <a href="details-mushoku-tensei.php" class="anime-card"
                data-title="Mushoku Tensei: Jobless Reincarnation Season 2" data-genres="Adventure, Drama, Fantasy"
                data-year="2023" data-season="Summer">
                <div class="cover-image" style="background-color: #333;">
                    <img src="<?php echo !empty($mushoku['cover_image']) ? $mushoku['cover_image'] : 'img/tensei.webp'; ?>"
                        alt="Anime Cover">
                </div>
                <div class="card-title">Mushoku Tensei: Jobless Reincarnation Season 2</div>
            </a>
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

        // Main filter function
        function filterAnime() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedGenre = genreSelect.value;
            const selectedYear = yearSelect.value;
            const selectedSeason = seasonSelect.value;

            animeCards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                const genres = card.getAttribute('data-genres') || '';
                const year = card.getAttribute('data-year') || '';
                const season = card.getAttribute('data-season') || '';

                // Check matches for each filter criteria
                const matchesSearch = title.includes(searchTerm);
                const matchesGenre = selectedGenre === '' || genres.includes(selectedGenre);
                const matchesYear = selectedYear === '' || year === selectedYear;
                const matchesSeason = selectedSeason === '' || season === selectedSeason;

                // Show and hide card results through display property
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