<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <section class="hero" style="min-height: 200px; padding: 40px 0;">
        <div class="container">
            <h1>Your Favorites</h1>
            <p class="hero-subtitle">Manage your personal anime collection.</p>
        </div>
    </section>

    <main class="content-wrapper">
        <div class="container">
            <div class="section-header">
                <h2>Saved Anime</h2>
            </div>
            <div class="anime-grid" id="favorites-grid">
                <!-- Favorites will be rendered here by JS -->
                <p id="empty-message" style="color: var(--text-muted); grid-column: 1 / -1; text-align: center;">You
                    haven't added any favorites yet.</p>
            </div>
        </div>
    </main>

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
            const favoritesGrid = document.getElementById('favorites-grid');
            const emptyMessage = document.getElementById('empty-message');

            function loadFavorites() {
                const favorites = JSON.parse(localStorage.getItem('aniCraveFavorites')) || [];

                if (favorites.length > 0) {
                    emptyMessage.style.display = 'none';
                    favoritesGrid.innerHTML = ''; // Clear empty message/previous content

                    favorites.forEach(anime => {
                        const card = document.createElement('div');
                        card.className = 'anime-card';

                        card.innerHTML = `
                            <a href="${anime.url || 'details.php'}" style="display:block; color:inherit; text-decoration:none;">
                                <div class="cover-image" style="background-color: #333;">
                                    <img src="${anime.cover}" alt="${anime.title}">
                                </div>
                                <div class="card-title">${anime.title}</div>
                            </a>
                            <button class="remove-btn" data-title="${anime.title.replace(/"/g, '&quot;')}" style="margin-top: 10px; width: 100%; padding: 5px; background: #ff6b6b; border: none; border-radius: 4px; color: white; cursor: pointer; font-weight: 600;">Remove</button>
                        `;

                        // Add event listener to the remove button
                        const removeBtn = card.querySelector('.remove-btn');
                        removeBtn.addEventListener('click', function () {
                            removeFavorite(this.dataset.title);
                        });

                        favoritesGrid.appendChild(card);
                    });
                } else {
                    favoritesGrid.innerHTML = '';
                    favoritesGrid.appendChild(emptyMessage);
                    emptyMessage.style.display = 'block';
                }
            }

            // Expose remove function globally
            window.removeFavorite = function (title) {
                Swal.fire({
                    title: 'Remove from Favorites?',
                    text: `Are you sure you want to remove "${title}" from your favorites?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff6b6b',
                    cancelButtonColor: '#3DB4F2',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let favorites = JSON.parse(localStorage.getItem('aniCraveFavorites')) || [];
                        favorites = favorites.filter(anime => anime.title !== title);
                        localStorage.setItem('aniCraveFavorites', JSON.stringify(favorites));
                        loadFavorites(); // Re-render

                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Anime has been removed from your favorites.',
                            confirmButtonColor: '#3DB4F2',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            };

            loadFavorites();
        });
    </script>
</body>

</html>
