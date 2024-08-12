<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in to add a movie to favoriets.']);
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];

// Check if the movie is already a favorite
$sql_check = "SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $movie_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // If the movie is already a favorite, remove it
    $sql_delete = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $user_id, $movie_id);
    $stmt_delete->execute();
    $stmt_delete->close();
    echo json_encode(['success' => true, 'message' => 'Removed from favorites.']);
} else {
    // If the movie is not a favorite, add it
    $sql_insert = "INSERT INTO favorites (user_id, movie_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $movie_id);
    $stmt_insert->execute();
    $stmt_insert->close();
    echo json_encode(['success' => true, 'message' => 'Added to favorites.']);
}

$stmt_check->close();
$conn->close();
?>
