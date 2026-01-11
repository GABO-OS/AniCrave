<?php
session_start();
include('connect.php');

// Security Check: Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Kunin ang mga statistics para sa dashboard (bilang ng anime at users)
$anime_count_query = "SELECT COUNT(*) as count FROM anime";
$anime_count_res = mysqli_query($con, $anime_count_query);
$anime_count = mysqli_fetch_assoc($anime_count_res)['count'];

$user_count_query = "SELECT COUNT(*) as count FROM users WHERE role = 'user'";
$user_count_res = mysqli_query($con, $user_count_query);
$user_count = mysqli_fetch_assoc($user_count_res)['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>

    <?php include 'includes/header.php'; ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <p style="color: var(--text-muted);">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>
            </p>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="message-box success" style="margin-bottom: 30px;">
                <i class="fa-solid fa-circle-check"></i> Anime updated successfully!
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Anime</h3>
                <div class="value">
                    <?php echo $anime_count; ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>Registered Users</h3>
                <div class="value">
                    <?php echo $user_count; ?>
                </div>
            </div>
        </div>

        <h2 style="margin-bottom: 20px; color: var(--text-main); margin-top: 40px;">Manage Anime</h2>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Episodes</th>
                        <th>Score</th>
                        <th>Studio</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Hanapin lahat ng anime sa listahan, unahin ang pinakabago
                    $all_anime_query = "SELECT * FROM anime ORDER BY id DESC";
                    $all_anime_res = mysqli_query($con, $all_anime_query);
                    while ($anime = mysqli_fetch_assoc($all_anime_res)):
                        ?>
                        <tr>
                            <!-- Image preview ng anime cover -->
                            <td><img src="<?php echo !empty($anime['cover_image']) ? $anime['cover_image'] : 'img/default-cover.jpg'; ?>"
                                    width="40" height="60" style="object-fit: cover; border-radius: 4px;"></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($anime['title']); ?></td>
                            <td><?php echo $anime['episodes']; ?></td>
                            <td><?php echo $anime['average_score'] > 0 ? $anime['average_score'] . '%' : '-'; ?></td>
                            <td><?php echo htmlspecialchars($anime['studio'] ?? '-'); ?></td>
                            <td>
                                <!-- Quick links para sa pag-view at pag-edit -->
                                <a href="details.php?id=<?php echo $anime['id']; ?>" class="table-action-btn"
                                    title="View"><i class="fa-solid fa-eye"></i></a>
                                <a href="edit_anime.php?id=<?php echo $anime['id']; ?>" class="table-action-btn"
                                    title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <h2 style="margin-bottom: 20px; color: var(--text-main); margin-top: 40px;">Quick Actions</h2>
        <div class="admin-actions">
            <!-- Add Anime Button -->
            <a href="add_anime.php" class="action-btn">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add New Anime</span>
            </a>

            <!-- Future Feature: Manage Users -->
            <a href="promote_user.php" class="action-btn">
                <i class="fa-solid fa-users-gear"></i>
                <span>Manage Users</span>
            </a>
        </div>
    </div>

    <!-- Styles for the new table -->
    <style>
        .admin-table-container {
            background-color: var(--bg-hover);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-main);
        }

        .admin-table th,
        .admin-table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table th {
            background-color: rgba(255, 255, 255, 0.03);
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-table tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .table-action-btn {
            color: var(--text-muted);
            margin-right: 10px;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .table-action-btn:hover {
            color: var(--primary-blue);
        }
    </style>

    <?php include 'includes/footer.php'; ?>

</body>

</html>