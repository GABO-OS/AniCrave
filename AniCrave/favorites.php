<?php
// Start yung session para sa favorites check
session_start();
// Include the database configuration
include 'connect.php';
?>



<body>

    <?php
    // Pull the site-wide header
    include 'includes/header.php';
    ?>

    <!-- Hero Section for the user's collection -->
    <section class="hero" style="min-height: 200px; padding: 40px 0;">
        <div class="container">
            <h1>Your Favorites</h1>
            <p class="hero-subtitle">Manage your personal anime collection.</p>
        </div>
    </section>

    <!-- Main content container para sa list of favorite anime -->
    <main class="content-wrapper">
        <div class="container">
            <div class="section-header">
                <h2>Saved Anime</h2>
            </div>

            <div class="anime-grid" id="favorites-grid">
                <?php
                // Kapag naka-login, kunin lahat ng anime na "heart" ng gumagamit
                $has_favorites = false;
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    // SQL query para pag-samahin yung 'anime' table at 'favorites' table
                    $sql = "SELECT a.* FROM anime a 
                            JOIN favorites f ON a.id = f.anime_id 
                            WHERE f.user_id = '$user_id'
                            ORDER BY f.added_at DESC";
                    $result = mysqli_query($con, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $has_favorites = true;
                        while ($anime = mysqli_fetch_assoc($result)) {
                            $details_page = "details.php?id=" . $anime['id'];
                            ?>
                            <div class="anime-card" id="anime-<?php echo $anime['id']; ?>">
                                <a href="<?php echo $details_page; ?>" style="display:block; color:inherit; text-decoration:none;">
                                    <div class="cover-image" style="background-color: #333;">
                                        <img src="<?php echo $anime['cover_image']; ?>"
                                            alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                    </div>
                                    <div class="card-title"><?php echo htmlspecialchars($anime['title']); ?></div>
                                </a>
                                <button class="remove-btn"
                                    onclick="removeFavorite(<?php echo $anime['id']; ?>, '<?php echo addslashes($anime['title']); ?>')"
                                    style="margin-top: 10px; width: 100%; padding: 5px; background: #ff6b6b; border: none; border-radius: 4px; color: white; cursor: pointer; font-weight: 600;">
                                    Remove
                                </button>
                            </div>
                            <?php
                        }
                    }
                }

                if (!$has_favorites): ?>
                    <!-- Message if walang nakitang data sa list -->
                    <p id="empty-message" style="color: var(--text-muted); grid-column: 1 / -1; text-align: center;">
                        <?php echo isset($_SESSION['user_id']) ? "You haven't added any favorites yet." : "Please login to see your favorites."; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php
    // Pull the site-wide footer
    include 'includes/footer.php';
    ?>

    <script>
        // Function para sa pag-remove ng favorite gamit ang SweetAlert toolkit
        window.removeFavorite = function (animeId, title) {
            Swal.fire({
                title: 'Remove from Favorites?',
                text: `Sigurado ka bang tatanggalin si "${title}" sa collection mo?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#3DB4F2',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tawagin yung toggle_favorite API para mawala sa database
                    fetch('toggle_favorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ anime_id: animeId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Kapag burado na sa database, alisin na rin yung card sa browser UI
                                const card = document.getElementById(`anime-${animeId}`);
                                if (card) {
                                    card.remove();

                                    // Pag wala nang natira sa listahan, i-refresh yung page para lumabas ang "empty" message
                                    const grid = document.getElementById('favorites-grid');
                                    if (grid.querySelectorAll('.anime-card').length === 0) {
                                        location.reload();
                                    }
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: 'Anime has been removed from your favorites.',
                                    confirmButtonColor: '#3DB4F2',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message || 'Something went wrong!',
                                    confirmButtonColor: '#3DB4F2'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        };
    </script>
</body>

</html>