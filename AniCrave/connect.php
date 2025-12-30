<?php
$dbserver = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "anicrave";

$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connection Successfull";
}

/**
 * Fetch anime details by title
 * @param mysqli $con Database connection
 * @param string $title Anime title
 * @return array|null Anime data or null if not found
 */
function getAnimeByTitle($con, $title)
{
    $title = mysqli_real_escape_string($con, $title);
    $sql = "SELECT * FROM anime WHERE title = '$title' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/**
 * Fetch characters by anime ID
 * @param mysqli $con Database connection
 * @param int $animeId Anime ID
 * @return array List of characters
 */
function getCharactersByAnimeId($con, $animeId)
{
    $animeId = mysqli_real_escape_string($con, $animeId);
    $sql = "SELECT * FROM characters WHERE anime_id = '$animeId'";
    $result = mysqli_query($con, $sql);
    $characters = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $characters[] = $row;
        }
    }
    return $characters;
}
?>