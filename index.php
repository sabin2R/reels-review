<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

// Fetching all the movies and checking if they are in favorites
$sql = "SELECT movies.id, movies.name, movies.description, movies.genre, movies.rating, movies.poster_url, 
        IF(favorites.user_id IS NULL, 0, 1) AS is_favorite 
        FROM movies 
        LEFT JOIN favorites ON movies.id = favorites.movie_id AND favorites.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$movies = [];
$genres = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
        if (!in_array($row['genre'], $genres)) {
            $genres[] = $row['genre'];
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reel Review</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/css/styles.css"
</head>
<body>
    <?php include 'includes/header.php';?>

    <!-- Carousel -->
    <div class="carousel-container mt-5">
        <div id="movieCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($movies as $index => $movie): ?>
                    <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>">
                        <div class="carousel-caption">
                            <h5><?php echo htmlspecialchars($movie['name']); ?></h5>
                            <p><?php echo htmlspecialchars($movie['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
           
            <a class="carousel-control-prev" href="#movieCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#movieCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Movie Section -->
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-4">
                <select id="genre-filter" class="form-control">
                    <option value="">All Genres</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select id="sort-options" class="form-control">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="rating">Rating</option>
                </select>
            </div>
        </div>
        <h2 class="mb-4">Popular Movies</h2>
        <div class="row" id="movie-grid">
            <!-- Movie will be inserted here from database dynamically -->
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4 movie-card mb-4">
                    <a href="movie.php?id=<?php echo $movie['id']; ?>" class="text-decoration-none">
                        <div class="d-flex flex-column">
                            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>" class="img-fluid">
                            <div class="movie-info text-center mt-2">
                                <h5><?php echo htmlspecialchars($movie['name']); ?></h5>
                                <div class="details">
                                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                                    <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                                    <p><strong>Rating:</strong> <?php echo htmlspecialchars($movie['rating']); ?> ⭐</p>
                                </div>
                                <!-- Heart icon -->
                                <span class="favorite <?php echo $movie['is_favorite'] ? 'active' : ''; ?>" data-id="<?php echo $movie['id']; ?>"><i class="fas fa-heart"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="films.php"><button class="btn btn-primary" id="view-all" href=>View All Movies</button></a>
        </div>
    </div>

    <?php include 'includes/footer.php';?>

    

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        var moviesData = <?php echo json_encode($movies); ?>;
        document.addEventListener('DOMContentLoaded', function() {
            var moviesDataElement = document.createElement('script');
            moviesDataElement.type = 'application/json';
            moviesDataElement.id = 'movies-data';
            moviesDataElement.textContent = JSON.stringify(moviesData);
            document.body.appendChild(moviesDataElement);
        });
    </script>
    <script src="./asset/js/scripts.js"></script>
</body>
</html>