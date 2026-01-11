<?php
// Database connection parameters setup
$dbserver = "sql213.infinityfree.com";
$dbuser = "if0_40865806";
$dbpassword = "anicrave2025";
$dbname = "if0_40865806_anicrave";

// Establish connection to MySQL server
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $dbname);

// Verify if successful yung connection, otherwise terminate the script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Utility function to fetch anime data by title //
function getAnimeByTitle($con, $title)
{
    // I-sanitize yung title para iwas sa SQL attacks or hacking
    $title = mysqli_real_escape_string($con, $title);
    // SQL query para hanapin yung anime base sa title, isa lang ang kukunin
    $sql = "SELECT * FROM anime WHERE title = '$title' LIMIT 1";
    // I-execute yung query sa database
    $result = mysqli_query($con, $sql);

    // Kapag may nahanap na data, i-return yung result as associative array
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    // Kapag wala, null ang ibabalik
    return null;
}

// Utility function para kuhanin lahat ng characters ng isang specific anime //
function getCharactersByAnimeId($con, $animeId)
{
    // Siguraduhing safe yung ID bago gamitin sa query
    $animeId = mysqli_real_escape_string($con, $animeId);
    // SQL query para kuhanin lahat ng characters na naka-link sa anime ID na 'to
    $sql = "SELECT * FROM characters WHERE anime_id = '$animeId'";
    // Patakbuhin yung query
    $result = mysqli_query($con, $sql);
    $characters = [];

    // I-loop yung result set at ilagay lahat ng nahanap na row sa $characters array
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $characters[] = $row;
        }
    }
    // I-return yung listahan ng characters
    return $characters;
}

// Utility function to fetch all anime //
function getAllAnime($con, $limit = null)
{
    $sql = "SELECT * FROM anime ORDER BY id DESC";
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    $result = mysqli_query($con, $sql);
    $anime_list = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $anime_list[] = $row;
        }
    }
    return $anime_list;
}

// Utility function para kuhanin ang anime base sa section (e.g. TRENDING, POPULAR) //
function getAnimeBySection($con, $section, $limit = null)
{
    // Linisin yung section string para iwas-SQL injection
    $section = mysqli_real_escape_string($con, $section);
    // Hanapin yung anime na pasok sa section na 'to, latest muna (ORDER BY id DESC)
    $sql = "SELECT * FROM anime WHERE section = '$section' ORDER BY id DESC";
    // Kung may limit (halimbawa top 5 lang), idagdag sa query
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    // I-execute yung query
    $result = mysqli_query($con, $sql);
    $anime_list = [];

    // Kolektahin lahat ng nahanap sa isang array
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $anime_list[] = $row;
        }
    }
    // I-return na yung nakuhang anime list
    return $anime_list;
}


?>