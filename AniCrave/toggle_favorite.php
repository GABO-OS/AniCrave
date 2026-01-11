<?php
session_start();
include 'connect.php';

// Sabihing JSON ang format ng sagot
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login muna bago ang lahat.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get data from request
$data = json_decode(file_get_contents('php://input'), true);
$anime_id = isset($data['anime_id']) ? intval($data['anime_id']) : 0;

if ($anime_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid anime ID.']);
    exit();
}

// Tignan muna natin sa 'favorites' table kung nakalista na 'tong anime para sa user na 'to
$check_sql = "SELECT id FROM favorites WHERE user_id = ? AND anime_id = ?";
$stmt = mysqli_prepare($con, $check_sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $anime_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Kapag andun na (nahanap yung row), ibig sabihin gusto na ni user na alisin sa collection
    $delete_sql = "DELETE FROM favorites WHERE user_id = ? AND anime_id = ?";
    $stmt = mysqli_prepare($con, $delete_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $anime_id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'action' => 'removed', 'message' => 'Removed from favorites.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove from favorites.']);
    }
} else {
    // Kapag wala pa sa listahan, ibig sabihin gusto ni user i-save 'to muna
    // Kunin ang title ng anime para sa redundancy sa favorites table
    $title_sql = "SELECT title FROM anime WHERE id = ?";
    $title_stmt = mysqli_prepare($con, $title_sql);
    mysqli_stmt_bind_param($title_stmt, "i", $anime_id);
    mysqli_stmt_execute($title_stmt);
    $title_result = mysqli_stmt_get_result($title_stmt);
    $anime_data = mysqli_fetch_assoc($title_result);
    $anime_title = $anime_data['title'] ?? 'Unknown';

    // Isaksak yung bagong entry sa favorites table
    $insert_sql = "INSERT INTO favorites (user_id, anime_id, anime_title) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_sql);
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $anime_id, $anime_title);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'action' => 'added', 'message' => 'Added to favorites!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add to favorites.']);
    }
}
?>