<?php
session_start();
include('connect.php');

// Security Check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

// Handle Form Submission
if (isset($_POST['submit_anime'])) {
    // Kinukuha at sini-sanitize lahat ng galing sa form inputs para safe sa database
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $genres = mysqli_real_escape_string($con, $_POST['genres']);
    $year = (int) $_POST['year'];
    $season = mysqli_real_escape_string($con, $_POST['season']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $episodes = (int) $_POST['episodes'];
    $score = (int) $_POST['average_score'];
    $studio = mysqli_real_escape_string($con, $_POST['studio']);
    $section = mysqli_real_escape_string($con, $_POST['section']);


    // File Upload Logic
    $target_dir = "img/";

    // Logic para sa pag-upload ng Cover Image
    $cover_path = "";
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        // Gawa ng unique name gamit ang current time para hindi mag-conflict
        $cover_name = time() . "_" . basename($_FILES["cover_image"]["name"]);
        $target_file = $target_dir . $cover_name;
        // I-move yung file mula sa temporary folder papunta sa img/ folder natin
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            $cover_path = "img/" . $cover_name;
        } else {
            $error = "Failed to upload cover image.";
        }
    }

    // Banner Image
    $banner_path = "";
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $banner_name = "banner_" . time() . "_" . basename($_FILES["banner_image"]["name"]);
        $target_file = $target_dir . $banner_name;
        if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
            $banner_path = "img/" . $banner_name;
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO `anime` (title, description, genres, year, season, type, status, cover_image, banner_image, episodes, average_score, studio, section) 
                VALUES ('$title', '$description', '$genres', '$year', '$season', '$type', '$status', '$cover_path', '$banner_path', '$episodes', '$score', '$studio', '$section')";

        if (mysqli_query($con, $sql)) {
            // Kunin yung ID ng bagong gawang anime para i-link sa characters mamaya
            $anime_id = mysqli_insert_id($con);
            $success = "Anime inserted successfully!";

            // Dito nagsisimula yung dynamic Character insertion
            if (isset($_POST['char_name']) && is_array($_POST['char_name'])) {
                foreach ($_POST['char_name'] as $index => $name) {
                    if (!empty($name)) {
                        // I-sanitize bawat field ng character
                        $role = mysqli_real_escape_string($con, $_POST['char_role'][$index]);
                        $char_name_escaped = mysqli_real_escape_string($con, $name);
                        $char_image_path = "img/default-char.jpg"; // Default kung walang upload

                        // Pag-upload ng character image sa img/ folder
                        if (isset($_FILES['char_image']['name'][$index]) && $_FILES['char_image']['error'][$index] == 0) {
                            $char_img_name = "char_" . time() . "_" . $index . "_" . basename($_FILES["char_image"]["name"][$index]);
                            $char_target_file = $target_dir . $char_img_name;
                            if (move_uploaded_file($_FILES["char_image"]["tmp_name"][$index], $char_target_file)) {
                                $char_image_path = "img/" . $char_img_name;
                            }
                        }

                        // I-save na yung character sa database, naka-link sa $anime_id
                        $char_sql = "INSERT INTO characters (anime_id, name, char_role, image_url) 
                                     VALUES ('$anime_id', '$char_name_escaped', '$role', '$char_image_path')";
                        mysqli_query($con, $char_sql);
                    }
                }
            }
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
    <title>Add Anime - Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .character-row {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
            align-items: flex-end;
            border: 1px solid var(--border-color);
        }

        .btn-remove-char {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-add-char {
            background: rgba(61, 180, 242, 0.1);
            color: var(--primary-blue);
            border: 1px dashed var(--primary-blue);
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 20px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-add-char:hover {
            background: rgba(61, 180, 242, 0.2);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel {
            flex: 1;
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            border-color: #ff4d4d;
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.05);
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2 style="margin-bottom: 20px;">Add New Anime</h2>

            <?php if ($error): ?>
                <div class="message-box error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="message-box success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Genres (comma separated)</label>
                    <input type="text" name="genres" class="form-control" placeholder="Action, Adventure, Fantasy">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" name="year" class="form-control" value="2024">
                    </div>
                    <div class="form-group">
                        <label>Season</label>
                        <select name="season" class="form-control">
                            <option value="Winter">Winter</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Fall">Fall</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="TV">TV Series</option>
                            <option value="Movie">Movie</option>
                            <option value="OVA">OVA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Episodes</label>
                        <input type="number" name="episodes" class="form-control" value="0">
                    </div>
                    <div class="form-group">
                        <label>Average Score (0-100)</label>
                        <input type="number" name="average_score" class="form-control" value="0" min="0" max="100">
                    </div>
                </div>

                <div class="form-group">
                    <label>Studio</label>
                    <input type="text" name="studio" class="form-control" placeholder="e.g., Madhouse, Ufotable">
                </div>

                <div class="form-group">
                    <label>Display Section</label>
                    <select name="section" class="form-control">
                        <option value="NONE">None</option>
                        <option value="PICK BY ADMIN">Pick by Admin</option>
                        <option value="TRENDING NOW">Trending Now</option>
                        <option value="POPULAR THIS SEASON">Popular This Season</option>
                    </select>
                </div>



                <div class="form-row">
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input type="file" name="cover_image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="banner_image" class="form-control">
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 20px 0;">
                <h3 style="margin-bottom: 15px;">Characters</h3>
                <div id="character-container">
                    <!-- Dynamic Rows Here -->
                </div>
                <button type="button" class="btn-add-char" id="add-char-btn">
                    <i class="fa-solid fa-plus"></i> Add Character
                </button>

                <div class="form-actions">
                    <button type="submit" name="submit_anime" class="btn-submit" style="flex: 2;">
                        Add Anime
                    </button>
                    <a href="admin_dashboard.php" class="btn-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // JS para sa dynamic character rows
        document.getElementById('add-char-btn').addEventListener('click', function () {
            const container = document.getElementById('character-container');
            const row = document.createElement('div');
            row.className = 'character-row';
            // Dito gumagawa ng panibagong set ng input fields tuwing iki-click yung button
            row.innerHTML = `
                <div class="form-group" style="flex: 2;">
                    <label>Name</label>
                    <input type="text" name="char_name[]" class="form-control" placeholder="e.g., Eren Yeager" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Role</label>
                    <select name="char_role[]" class="form-control">
                        <option value="Main">Main</option>
                        <option value="Supporting">Supporting</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 2;">
                    <label>Image</label>
                    <input type="file" name="char_image[]" class="form-control" accept="image/*">
                </div>
                <button type="button" class="btn-remove-char" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            container.appendChild(row);
        });

        // I-auto click para may isang default row agad pag-load ng page
        document.getElementById('add-char-btn').click();
    </script>
</body>

</html>