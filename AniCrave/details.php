<?php
// Start session for user monitoring
session_start();

// Include database connection
include 'connect.php';

// Check if an ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Kunin yung ID galing sa URL (?id=1) para malaman kung anong anime ang idi-display
$anime_id = mysqli_real_escape_string($con, $_GET['id']);

// Hanapin yung anime details sa database gamit yung ID
$sql = "SELECT * FROM anime WHERE id = '$anime_id'";
$result = mysqli_query($con, $sql);
$anime = mysqli_fetch_assoc($result);

// Kapag walang ganung ID na nahanap, ibalik sa home page
if (!$anime) {
    header("Location: index.php");
    exit();
}

// Logic for favorite check
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_sql = "SELECT id FROM favorites WHERE user_id = '$user_id' AND anime_id = '$anime_id'";
    $check_result = mysqli_query($con, $check_sql);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $is_favorite = true;
    }
}
?>

<!-- Include header component -->
<?php include 'includes/header.php'; ?>

<!-- Content Block: Interactive Banner -->
<div class="details-banner"
    style="background-image: url('<?php echo !empty($anime['banner_image']) ? $anime['banner_image'] : 'img/default-banner.jpg'; ?>');">
    <div class="banner-shadow"></div>
</div>

<!-- Main Section: Anime Meta and Description -->
<div class="container details-header-container">
    <div class="details-cover">
        <img src="<?php echo !empty($anime['cover_image']) ? $anime['cover_image'] : 'img/default-cover.jpg'; ?>"
            alt="Anime Cover">
        <div class="action-buttons">
            <button class="btn-action-fav <?php echo $is_favorite ? 'active' : ''; ?>" id="fav-btn"
                data-id="<?php echo $anime['id']; ?>"
                style="<?php echo $is_favorite ? 'background-color: #ff6b6b;' : ''; ?>">
                <span>
                    <?php echo $is_favorite ? 'Added to Favorites' : 'Add to Favorites'; ?>
                </span>
                <i class="fa-<?php echo $is_favorite ? 'solid' : 'regular'; ?> fa-heart"></i>
            </button>
        </div>
    </div>
    <div class="details-title-section">
        <h1>
            <?php echo htmlspecialchars($anime['title']); ?>
        </h1>
        <p class="breadcrumbs">
            <?php echo htmlspecialchars($anime['type']); ?> &bull;
            <?php echo htmlspecialchars($anime['status']); ?>
        </p>
        <p class="description-text">
            <?php echo !empty($anime['description']) ? nl2br(htmlspecialchars($anime['description'])) : 'No description available for this anime.'; ?>
        </p>
    </div>
</div>

<!-- Layout: Detailed Specs and Character List -->
<div class="container details-content-grid">
    <div class="details-sidebar">
        <div class="info-block">
            <div class="info-item">
                <span class="label">Format</span>
                <span class="value">
                    <?php echo htmlspecialchars($anime['type']); ?>
                </span>
            </div>
            <div class="info-item">
                <span class="label">Status</span>
                <span class="value">
                    <?php echo htmlspecialchars($anime['status']); ?>
                </span>
            </div>
            <div class="info-item">
                <span class="label">Season</span>
                <span class="value">
                    <?php echo htmlspecialchars($anime['season'] . ' ' . $anime['year']); ?>
                </span>
            </div>
            <div class="info-item">
                <span class="label">Genres</span>
                <span class="value">
                    <?php echo htmlspecialchars($anime['genres']); ?>
                </span>
            </div>
        </div>

        <div class="sidebar-section">
            <h4>Tags</h4>
            <div class="tags-list">
                <?php
                $tags = explode(',', $anime['genres']);
                foreach ($tags as $tag): ?>
                    <span class="tag">
                        <?php echo trim(htmlspecialchars($tag)); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="details-body">
        <section class="content-section">
            <h3>Characters</h3>
            <div class="character-grid">
                <?php
                // Tawagin yung function galing sa connect.php para kuhanin lahat ng characters ng anime na 'to
                $characters = getCharactersByAnimeId($con, $anime['id']);
                if (!empty($characters)):
                    // I-loop para isa-isang ipakita yung mga characters sa grid
                    foreach ($characters as $char):
                        ?>
                        <div class="character-card">
                            <div class="char-img">
                                <img src="<?php echo htmlspecialchars($char['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($char['name']); ?>">
                            </div>
                            <div class="char-details">
                                <div class="char-name">
                                    <?php echo htmlspecialchars($char['name']); ?>
                                </div>
                                <div class="char-role">
                                    <?php echo htmlspecialchars($char['char_role']); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                else:
                    // Message kapag wala pang nilalagay na characters sa database para sa anime na 'to
                    echo "<p style='color: var(--text-muted);'>No characters listed for this anime.</p>";
                endif;
                ?>
            </div>
        </section>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Favorite functionality hook -->
<script src="js/details.js"></script>
</body>

</html>