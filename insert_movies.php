<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "reelreview");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Delete all data from the table
$delete_sql = "DELETE FROM movies";
$conn->query($delete_sql);

// Reset auto-increment value
$reset_sql = "ALTER TABLE movies AUTO_INCREMENT = 1";
$conn->query($reset_sql);

// Movie data
$movies = [
    [
        'name' => 'The Shawshank Redemption',
        'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
        'genre' => 'Drama',
        'rating' => 9.3,
        'release_date' => '1994-09-23'
    ],
    [
        'name' => 'The Godfather',
        'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
        'genre' => 'Crime',
        'rating' => 9.2,
        'release_date' => '1972-03-24'
    ],
    [
        'name' => 'The Dark Knight',
        'description' => 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.',
        'genre' => 'Action',
        'rating' => 9.0,
    
        'release_date' => '2008-07-18'
    ],
    [
        'name' => 'Pulp Fiction',
        'description' => 'The lives of two mob hitmen, a boxer, a gangster, and his wife intertwine in four tales of violence and redemption.',
        'genre' => 'Crime',
        'rating' => 8.9,
        
        'release_date' => '1994-10-14'
    ],
    [
        'name' => 'The Lord of the Rings: The Return of the King',
        'description' => 'Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.',
        'genre' => 'Fantasy',
        'rating' => 8.9,
        'release_date' => '2003-12-17'
    ],
    [
        'name' => 'Forrest Gump',
        'description' => 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75.',
        'genre' => 'Drama',
        'rating' => 8.8,
        
        'release_date' => '1994-07-06'
    ],
    [
        'name' => 'Inception',
        'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
        'genre' => 'Sci-Fi',
        'rating' => 8.8,
        'release_date' => '2010-07-16'
    ],
    [
        'name' => 'Fight Club',
        'description' => 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.',
        'genre' => 'Drama',
        'rating' => 8.8,

        'release_date' => '1999-10-15'
    ],
    [
        'name' => 'The Matrix',
        'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
        'genre' => 'Sci-Fi',
        'rating' => 8,
        'release_date' => '1999-03-31'
    ],
    [
        'name' => 'Goodfellas',
        'description' => 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners Jimmy Conway and Tommy DeVito.',
        'genre' => 'Crime',
        'rating' => 8.7,
        'release_date' => '1990-09-19'
    ]
];

// Insert data into database
foreach ($movies as $movie) {
    $stmt = $conn->prepare("INSERT INTO movies (name, description, genre, rating, director, release_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $movie['name'], $movie['description'], $movie['genre'], $movie['rating'], $movie['director'], $movie['release_date']);
    $stmt->execute();
}

echo "Data inserted successfully.";

$conn->close();
?>
