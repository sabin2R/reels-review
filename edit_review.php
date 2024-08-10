<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$review_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch the review
$sql = "SELECT * FROM reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $review_id, $user_id);
$stmt->execute();
$review = $stmt->get_result()->fetch_assoc();

if (!$review) {
    echo "<script>alert('Review not found or you do not have permission to edit this review.'); window.location.href='account.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    $sql_update = "UPDATE reviews SET review_text = ?, rating = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sii", $review_text, $rating, $review_id);

    if ($stmt_update->execute()) {
        echo "<script>alert('Review updated successfully!'); window.location.href='account.php';</script>";
    } else {
        echo "<script>alert('An error occurred while updating your review.'); window.location.href='account.php';</script>";
    }

    $stmt_update->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2>Edit Review</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="review_text">Review Text:</label>
                <textarea id="review_text" name="review_text" class="form-control" rows="3" required><?php echo htmlspecialchars($review['review_text']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <select id="rating" name="rating" class="form-control">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if ($review['rating'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Review</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
