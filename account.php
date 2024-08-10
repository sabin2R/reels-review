<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();

// Fetch user reviews
$sql_reviews = "SELECT reviews.id, reviews.movie_id, reviews.rating, reviews.review_text, reviews.created_at, movies.name as movie_name
                FROM reviews
                JOIN movies ON reviews.movie_id = movies.id
                WHERE reviews.user_id = ?";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $user_id);
$stmt_reviews->execute();
$reviews = $stmt_reviews->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt_user->close();
$stmt_reviews->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/account.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4>Account Details</h4>
                    </div>
                    <div class="card-body">
                        <form id="account-form" action="update_account.php" method="POST">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password (Leave blank to keep current password):</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Account</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4>My Reviews</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($reviews as $review): ?>
                                <li class="list-group-item">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($review['movie_name']); ?></h5>
                                    <p>Rating: <span class="badge badge-warning"><?php echo htmlspecialchars($review['rating']); ?> ⭐</span></p>
                                    <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                    <small class="text-muted">Reviewed on: <?php echo htmlspecialchars($review['created_at']); ?></small>
                                    <div class="mt-2">
                                        <a href="edit_review.php?id=<?php echo $review['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                        <a href="delete_review.php?id=<?php echo $review['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
