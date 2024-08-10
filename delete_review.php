<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$review_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ensure the review belongs to the logged-in user
$sql = "DELETE FROM reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $review_id, $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Review deleted successfully!'); window.location.href='account.php';</script>";
} else {
    echo "<script>alert('An error occurred while deleting your review.'); window.location.href='account.php';</script>";
}

$stmt->close();
$conn->close();
?>
