<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];

// Check if the movie is already in favorites
$sql = "SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Movie is already in favorites, remove it
    $sql = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Removed from favorites']);
} else {
    // Movie is not in favorites, add it
    $sql = "INSERT INTO favorites (user_id, movie_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Added to favorites']);
}

$stmt->close();
$conn->close();
?>
