<?php
// Database connection parameters setup
$dbserver = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "anicrave";

// Establish connection to MySQL server
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $dbname);

// Verify if successful yung connection, otherwise terminate the script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

/**
 * Utility function to fetch anime data by title
 * @param mysqli $con DB connection object
 * @param string $title Target anime title
 * @return array|null Returns associative array of anime or null
 */
function getAnimeByTitle($con, $title)
{
    // Sanitize the title to prevent SQL attacks
    $title = mysqli_real_escape_string($con, $title);
    $sql = "SELECT * FROM anime WHERE title = '$title' LIMIT 1";
    $result = mysqli_query($con, $sql);

    // Fetch and return the row if data exists
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/**
 * Utility function to fetch characters for a specific anime
 * @param mysqli $con DB connection object
 * @param int $animeId ID of the parent anime
 * @return array Collection of character records
 */
function getCharactersByAnimeId($con, $animeId)
{
    // Secure the ID parameter
    $animeId = mysqli_real_escape_string($con, $animeId);
    $sql = "SELECT * FROM characters WHERE anime_id = '$animeId'";
    $result = mysqli_query($con, $sql);
    $characters = [];

    // Iterate through result set and accumulate rows
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $characters[] = $row;
        }
    }
    return $characters;
}
?>