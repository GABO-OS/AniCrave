<?php
session_start();
include('connect.php');

// Security Check: Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";
$anime_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($anime_id <= 0) {
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch existing data
$fetch_sql = "SELECT * FROM anime WHERE id = ?";
$stmt = mysqli_prepare($con, $fetch_sql);
mysqli_stmt_bind_param($stmt, "i", $anime_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$anime = mysqli_fetch_assoc($result);

if (!$anime) {
    header("Location: admin_dashboard.php");
    exit();
}

// Logic para sa pagbura ng character
if (isset($_GET['delete_char'])) {
    $char_id = intval($_GET['delete_char']);
    // SQL query para burahin yung specific character ID na naka-link sa anime na 'to
    $delete_sql = "DELETE FROM characters WHERE id = ? AND anime_id = ?";
    $del_stmt = mysqli_prepare($con, $delete_sql);
    mysqli_stmt_bind_param($del_stmt, "ii", $char_id, $anime_id);
    // Pagkatapos ma-execute, mag-refresh ang page para mawala sa listahan
    if (mysqli_stmt_execute($del_stmt)) {
        header("Location: edit_anime.php?id=$anime_id&msg=char_deleted");
        exit();
    }
}

// Logic para sa pag-dagdag ng bagong character habang nasa edit page
if (isset($_POST['add_character'])) {
    $char_name = mysqli_real_escape_string($con, $_POST['new_char_name']);
    $char_role = mysqli_real_escape_string($con, $_POST['new_char_role']);
    $char_image_path = "img/default-char.jpg";

    // Pag-handle ng bagong upload na character image
    if (isset($_FILES['new_char_image']) && $_FILES['new_char_image']['error'] == 0) {
        $char_img_name = "char_" . time() . "_" . basename($_FILES["new_char_image"]["name"]);
        $char_target_file = "img/" . $char_img_name;
        if (move_uploaded_file($_FILES["new_char_image"]["tmp_name"], $char_target_file)) {
            $char_image_path = "img/" . $char_img_name;
        }
    }

    // Isaksak yung bagong character data sa 'characters' table
    $char_sql = "INSERT INTO characters (anime_id, name, char_role, image_url) VALUES (?, ?, ?, ?)";
    $char_stmt = mysqli_prepare($con, $char_sql);
    mysqli_stmt_bind_param($char_stmt, "isss", $anime_id, $char_name, $char_role, $char_image_path);
    if (mysqli_stmt_execute($char_stmt)) {
        header("Location: edit_anime.php?id=$anime_id&msg=char_added");
        exit();
    }
}

// Fetch existing characters
$char_sql = "SELECT * FROM characters WHERE anime_id = ?";
$char_stmt = mysqli_prepare($con, $char_sql);
mysqli_stmt_bind_param($char_stmt, "i", $anime_id);
mysqli_stmt_execute($char_stmt);
$char_result = mysqli_stmt_get_result($char_stmt);
$characters = mysqli_fetch_all($char_result, MYSQLI_ASSOC);

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_anime'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $genres = mysqli_real_escape_string($con, $_POST['genres']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $season = mysqli_real_escape_string($con, $_POST['season']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $episodes = (int) $_POST['episodes'];
    $score = (int) $_POST['average_score'];
    $studio = mysqli_real_escape_string($con, $_POST['studio']);
    $section = mysqli_real_escape_string($con, $_POST['section']);


    // File Upload Logic
    $target_dir = "img/";
    $cover_path = $anime['cover_image'];
    $banner_path = $anime['banner_image'];

    // Cover Image Update
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $cover_name = time() . "_" . basename($_FILES["cover_image"]["name"]);
        $target_file = $target_dir . $cover_name;
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            $cover_path = "img/" . $cover_name;
        }
    }

    // Banner Image Update
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $banner_name = "banner_" . time() . "_" . basename($_FILES["banner_image"]["name"]);
        $target_file = $target_dir . $banner_name;
        if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
            $banner_path = "img/" . $banner_name;
        }
    }

    if (empty($error)) {
        // SQL query para i-update ang existing record, gumagamit ng '?' placeholder para mas safe
        $update_sql = "UPDATE `anime` SET 
                        title = ?, 
                        description = ?, 
                        genres = ?, 
                        year = ?, 
                        season = ?, 
                        type = ?, 
                        status = ?, 
                        cover_image = ?, 
                        banner_image = ?, 
                        episodes = ?, 
                        average_score = ?, 
                        studio = ?,
                        section = ?
                      WHERE id = ?";

        $update_stmt = mysqli_prepare($con, $update_sql);
        // I-bind yung mga variables natin sa mga '?' sa query sa taas
        mysqli_stmt_bind_param(
            $update_stmt,
            "sssssssssiissi",
            $title,
            $description,
            $genres,
            $year,
            $season,
            $type,
            $status,
            $cover_path,
            $banner_path,
            $episodes,
            $score,
            $studio,
            $section,
            $anime_id
        );

        if (mysqli_stmt_execute($update_stmt)) {
            // Pag successful ang update, balik sa Admin Dashboard
            header("Location: admin_dashboard.php?msg=updated");
            exit();
        } else {
            $error = "Database Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anime - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .characters-section {
            margin-top: 20px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .character-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .char-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .char-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .char-info h4 {
            margin: 0;
            font-size: 0.95rem;
        }

        .char-info p {
            margin: 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .btn-delete-char {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff4d4d;
            border: none;
            background: none;
            cursor: pointer;
            padding: 5px;
        }

        .add-char-form {
            background: rgba(52, 152, 219, 0.05);
            padding: 20px;
            border-radius: 8px;
            border: 1px dashed var(--primary-blue);
        }
    </style>
</head>

<body class="admin-page">

    <div class="admin-container">
        <div class="admin-header">
            <h1>Edit Anime</h1>
            <p style="color: var(--text-muted);">Modify details for: <?php echo htmlspecialchars($anime['title']); ?>
            </p>
        </div>

        <div class="form-container">
            <?php if ($error): ?>
                <div class="message-box error">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="message-box success">
                    <i class="fa-solid fa-circle-check"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form id="edit-anime-form" action="edit_anime.php?id=<?php echo $anime_id; ?>" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label>Anime Title</label>
                    <input type="text" name="title" class="form-control"
                        value="<?php echo htmlspecialchars($anime['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="5"
                        required><?php echo htmlspecialchars($anime['description']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Genres (comma separated)</label>
                        <input type="text" name="genres" class="form-control"
                            value="<?php echo htmlspecialchars($anime['genres']); ?>" required
                            placeholder="Adventure, Fantasy, Drama">
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" name="year" class="form-control"
                            value="<?php echo htmlspecialchars($anime['year']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Season</label>
                        <select name="season" class="form-control">
                            <option value="Winter" <?php if ($anime['season'] == 'Winter')
                                echo 'selected'; ?>>Winter
                            </option>
                            <option value="Spring" <?php if ($anime['season'] == 'Spring')
                                echo 'selected'; ?>>Spring
                            </option>
                            <option value="Summer" <?php if ($anime['season'] == 'Summer')
                                echo 'selected'; ?>>Summer
                            </option>
                            <option value="Fall" <?php if ($anime['season'] == 'Fall')
                                echo 'selected'; ?>>Fall</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Format</label>
                        <select name="type" class="form-control">
                            <option value="TV" <?php if ($anime['type'] == 'TV')
                                echo 'selected'; ?>>TV Series</option>
                            <option value="Movie" <?php if ($anime['type'] == 'Movie')
                                echo 'selected'; ?>>Movie</option>
                            <option value="OVA" <?php if ($anime['type'] == 'OVA')
                                echo 'selected'; ?>>OVA</option>
                            <option value="Special" <?php if ($anime['type'] == 'Special')
                                echo 'selected'; ?>>Special
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-row three-cols">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Ongoing" <?php if ($anime['status'] == 'Ongoing')
                                echo 'selected'; ?>>Ongoing
                            </option>
                            <option value="Completed" <?php if ($anime['status'] == 'Completed')
                                echo 'selected'; ?>>
                                Completed</option>
                            <option value="Upcoming" <?php if ($anime['status'] == 'Upcoming')
                                echo 'selected'; ?>>Upcoming
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Episodes</label>
                        <input type="number" name="episodes" class="form-control"
                            value="<?php echo $anime['episodes']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Average Score (%)</label>
                        <input type="number" name="average_score" class="form-control"
                            value="<?php echo $anime['average_score']; ?>" min="0" max="100">
                    </div>
                </div>

                <div class="form-group">
                    <label>Studio</label>
                    <input type="text" name="studio" class="form-control"
                        value="<?php echo htmlspecialchars($anime['studio']); ?>" placeholder="e.g., Madhouse, MAPPA">
                </div>

                <div class="form-group">
                    <label>Display Section</label>
                    <select name="section" class="form-control">
                        <option value="NONE" <?php echo ($anime['section'] == 'NONE') ? 'selected' : ''; ?>>None</option>
                        <option value="PICK BY ADMIN" <?php echo ($anime['section'] == 'PICK BY ADMIN') ? 'selected' : ''; ?>>Pick by Admin</option>
                        <option value="TRENDING NOW" <?php echo ($anime['section'] == 'TRENDING NOW') ? 'selected' : ''; ?>>Trending Now</option>
                        <option value="POPULAR THIS SEASON" <?php echo ($anime['section'] == 'POPULAR THIS SEASON') ? 'selected' : ''; ?>>Popular This Season</option>
                    </select>
                </div>



                <div class="form-row">
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input type="file" name="cover_image" class="form-control">
                        <small style="color: var(--text-muted); display: block; margin-top: 5px;">Current:
                            <?php echo basename($anime['cover_image']); ?></small>
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="banner_image" class="form-control">
                        <small style="color: var(--text-muted); display: block; margin-top: 5px;">Current:
                            <?php echo basename($anime['banner_image']); ?></small>
                    </div>
                </div>

            </form>

            <!-- Character Management Section -->
            <div class="characters-section">
                <h2 style="margin-bottom: 20px;">Characters</h2>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'char_deleted'): ?>
                    <div class="message-box success" style="margin-bottom: 15px;">Character removed.</div>
                <?php endif; ?>
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'char_added'): ?>
                    <div class="message-box success" style="margin-bottom: 15px;">New character added.</div>
                <?php endif; ?>

                <div class="character-list">
                    <?php if (empty($characters)): ?>
                        <p style="color: var(--text-muted);">No characters added yet.</p>
                    <?php else: ?>
                        <?php foreach ($characters as $char): ?>
                            <div class="char-item">
                                <img src="<?php echo $char['image_url']; ?>" alt="<?php echo $char['name']; ?>">
                                <div class="char-info">
                                    <h4><?php echo htmlspecialchars($char['name']); ?></h4>
                                    <p><?php echo htmlspecialchars($char['char_role']); ?></p>
                                </div>
                                <a href="edit_anime.php?id=<?php echo $anime_id; ?>&delete_char=<?php echo $char['id']; ?>"
                                    class="btn-delete-char" onclick="return confirm('Remove this character?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="add-char-form">
                    <h3 style="font-size: 1rem; margin-bottom: 15px; color: var(--primary-blue);">Add New Character</h3>
                    <form action="edit_anime.php?id=<?php echo $anime_id; ?>" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Character Name</label>
                                <input type="text" name="new_char_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="new_char_role" class="form-control">
                                    <option value="Main">Main</option>
                                    <option value="Supporting">Supporting</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Character Image</label>
                            <input type="file" name="new_char_image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" name="add_character" class="btn-submit"
                            style="padding: 10px 20px; font-size: 0.9rem;">
                            <i class="fa-solid fa-user-plus"></i> Add Character
                        </button>
                    </form>
                </div>

                <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" name="update_anime" form="edit-anime-form" class="btn-submit"
                        style="flex: 2;">
                        Save Changes
                    </button>
                    <a href="admin_dashboard.php" class="btn-submit"
                        style="flex: 1; background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); text-align: center; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>