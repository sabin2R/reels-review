<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$movie_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

// Initialize reviews array
$reviews = [];

$sql_reviews = "SELECT users.name, reviews.rating, reviews.review_text, reviews.created_at 
                FROM reviews 
                JOIN users ON reviews.user_id = users.id 
                WHERE reviews.movie_id = ?";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $movie_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();

// Fetch reviews if they exist
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Check if the movie is in the user's favorites
$sql_favorite = "SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmt_favorite = $conn->prepare($sql_favorite);
$stmt_favorite->bind_param("ii", $user_id, $movie_id);
$stmt_favorite->execute();
$is_favorite = $stmt_favorite->get_result()->num_rows > 0;

$stmt->close();
$stmt_reviews->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['name']); ?> - Detailed View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/css/styles.css">
    <link rel="stylesheet" href="./asset/css/detailed_film.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <!-- Back Button (Cross Symbol) -->
    <a href="javascript:history.back()" class="close text-decoration-none" aria-label="Back" style="font-size: 34px; color: #000;">
        &times;
    </a>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>
                    <?php echo htmlspecialchars($movie['name']); ?>
                    <!-- Favorite Indicator -->
                    <span class="favorite-icon <?php echo $is_favorite ? 'active' : ''; ?>" data-id="<?php echo $movie_id; ?>" style="cursor: pointer;">
                        <i class="fas fa-heart"></i>
                    </span>
                </h2>
                <p class="text-muted">Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
            </div>
            <div class="col-md-4 text-right">
                <p><strong>Rating: </strong><?php echo htmlspecialchars($movie['rating']); ?> ⭐</p>
                <p><strong>Your Rating: </strong>
                    <select id="your-rating">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $i == $movie['rating'] ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>" class="img-fluid">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h5><strong>Description</strong></h5>
                <p><?php echo nl2br(htmlspecialchars($movie['description'])); ?></p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h6><strong>Director</strong></h6>
                <p><?php echo htmlspecialchars($movie['director']); ?></p>
                
                <h6><strong>Writers</strong></h6>
                <p><?php echo htmlspecialchars($movie['writer']); ?></p>
                
                <h6><strong>Stars</strong></h6>
                <p><?php echo htmlspecialchars($movie['stars']); ?></p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h4>Reviews</h4>
                <form id="review-form">
                    <div class="form-group">
                        <textarea id="review-text" class="form-control" rows="3" placeholder="Write your review here..."></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitReview()">Submit Review</button>
                </form>
                <div id="reviews-list" class="mt-4">
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <p><strong><?php echo htmlspecialchars($review['name']); ?></strong> <span class="text-muted">(<?php echo htmlspecialchars($review['created_at']); ?>)</span></p>
                                <p>Rating: <?php echo htmlspecialchars($review['rating']); ?> ⭐</p>
                                <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet. Be the first to write a review!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./asset/js/detailed_film.js"></script>
    <script>
        var movieId = <?php echo $movie_id; ?>;
    </script>
</body>
</html>
