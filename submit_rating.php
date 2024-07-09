<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];
$rating = $_POST['rating'];

// Validate inputs
if (empty($rating) || $rating < 1 || $rating > 10) {
    echo json_encode(['success' => false, 'message' => 'Invalid rating']);
    exit();
}

// Check if the user has already rated this movie
$sql = "SELECT * FROM ratings WHERE user_id = ? AND movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update the existing rating
    $sql = "UPDATE ratings SET rating = ? WHERE user_id = ? AND movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $rating, $user_id, $movie_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Rating updated successfully']);
} else {
    // Insert a new rating
    $sql = "INSERT INTO ratings (user_id, movie_id, rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $movie_id, $rating);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Rating submitted successfully']);
}

$stmt->close();
$conn->close();
?>
