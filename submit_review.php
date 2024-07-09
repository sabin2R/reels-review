<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];
$review_text = $_POST['review_text'];

// Validate inputs
if (empty($review_text)) {
    echo json_encode(['success' => false, 'message' => 'Review cannot be empty']);
    exit();
}

$sql = "INSERT INTO reviews (user_id, movie_id, review_text) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $movie_id, $review_text);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Review submitted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
}

$stmt->close();
$conn->close();
?>
