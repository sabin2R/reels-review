<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$sql = "SELECT id, name, description, genre, rating, release_date, poster_url FROM movies";
$result = $conn->query($sql);
$movies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Movies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./asset/css/styles/css"> -->
    <link rel="stylesheet" href="./asset/css/films.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>All Movies</h2>
            <div>
                <select id="sort-options" class="form-control d-inline-block w-auto">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="rating">Rating</option>
                </select>
                <button class="btn btn-outline-secondary ml-2" id="grid-view"><i class="fas fa-th"></i></button>
                <button class="btn btn-outline-secondary" id="list-view"><i class="fas fa-list"></i></button>
            </div>
        </div>
        <div class="row" id="movie-grid">
            <!-- Movie  will be inserted here-->
            <?php foreach ($movies as $movie): ?>
                <div class="col-12 movie-list-item">
                    <a href="movie.php?id=<?php echo $movie['id']; ?>" class="text-decoration-none">
                        <div class="d-flex">
                            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>" class="list-view-img">
                            <div class="movie-info ml-3">
                                <h5><?php echo htmlspecialchars($movie['name']); ?></h5>
                                <div class="details">
                                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                                    <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                                    <p><strong>Rating:</strong> <?php echo htmlspecialchars($movie['rating']); ?> ⭐</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./asset/js/films.js"></script>
    <script>
        var moviesData =<?php echo json_encode($movies);?>;
    </script>
    
</body>
</html>
