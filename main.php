<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reel Review</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-nav {
            margin: 0 auto;
        }
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .movie-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .movie-card {
            text-align: center;
            width: 200px;
            margin: 10px;
        }
        .movie-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .footer {
            background-color: #000;
            color: #fff;
            padding: 20px 0;
        }
        .footer .social-icons {
            text-align: center;
        }
        .footer .social-icons a {
            color: #fff;
            margin: 0 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Reel Review</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Films</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Favourites</a></li>
                <li class="nav-item"><input class="form-control" type="text" placeholder="What are you looking for?" aria-label="Search"></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="movieCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="movie1.jpg" alt="Movie 1">
                <div class="carousel-caption">
                    <h5>Movie 1 Name</h5>
                    <p>Movie 1 Description</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="movie2.jpg" alt="Movie 2">
                <div class="carousel-caption">
                    <h5>Movie 2 Name</h5>
                    <p>Movie 2 Description</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="movie3.jpg" alt="Movie 3">
                <div class="carousel-caption">
                    <h5>Movie 3 Name</h5>
                    <p>Movie 3 Description</p>
                </div>
            </div>
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

    <!-- Movie Section -->
    <div class="container">
        <div class="movie-grid">
            <div class="movie-card">
                <img src="movie4.jpg" alt="Movie 4">
                <h5>Film Name</h5>
                <p>Description</p>
                <p class="rating" data-rating="4.5">Rating: 4.5 ⭐</p>
            </div>
            <div class="movie-card">
                <img src="movie5.jpg" alt="Movie 5">
                <h5>Film Name</h5>
                <p>Description</p>
                <p class="rating" data-rating="4.0">Rating: 4.0 ⭐</p>
            </div>
            <div class="movie-card">
                <img src="movie6.jpg" alt="Movie 6">
                <h5>Film Name</h5>
                <p>Description</p>
                <p class="rating" data-rating="3.5">Rating: 3.5 ⭐</p>
            </div>
            <div class="movie-card">
                <img src="movie7.jpg" alt="Movie 7">
                <h5>Film Name</h5>
                <p>Description</p>
                <p class="rating" data-rating="5.0">Rating: 5.0 ⭐</p>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary">View All Movies</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>About Us</p>
            <p>Reel Review is your go-to place for the latest movie reviews and ratings.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <p>&copy; Reel Review 2022. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ratings = document.querySelectorAll('.rating');
            ratings.forEach(function(rating) {
                var ratingValue = rating.getAttribute('data-rating');
                rating.textContent = `Rating: ${ratingValue} ⭐`;
            });
        });
    </script>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "reelreview");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch movies
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);

// Initialize movies array
$movies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}

$conn->close();
?>
</body>
</html>
