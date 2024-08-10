<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'unauthorized';
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];

// Remove the movie from the favorites table
$sql = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $movie_id);

if ($stmt->execute()) {
    echo 'removed';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
