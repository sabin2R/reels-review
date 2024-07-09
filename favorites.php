<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT movies.id, movies.name, movies.description, movies.genre, movies.rating, movies.poster_url
        FROM movies 
        JOIN favorites ON movies.id = favorites.movie_id 
        WHERE favorites.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $favorites[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2>My Favorite Movies</h2>
        <div class="row movie-grid" id="favorite-grid">
            <!-- Dynamically, Favorite movie will be inserted here -->
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        var favoriteMoviesData = <?php echo json_encode($favorites); ?>;
        document.addEventListener('DOMContentLoaded', function() {
            var favoriteGrid = document.getElementById('favorite-grid');
            function displayFavorites(movieList) {
                favoriteGrid.innerHTML = '';
                movieList.forEach(function(movie) {
                    var movieCard = `
                        <div class="col-md-3 movie-card">
                            <img src="${movie.poster_url}" alt="${movie.name}">
                            <h5>${movie.name}</h5>
                            <p>${movie.description}</p>
                            <p class="rating" data-rating="${movie.rating}">Rating: ${movie.rating} ⭐</p>
                        </div>
                    `;
                    favoriteGrid.insertAdjacentHTML('beforeend', movieCard);
                });
            }
            displayFavorites(favoriteMoviesData);
        });
    </script>
</body>
</html>
