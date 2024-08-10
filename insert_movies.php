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
        'poster_url' => 'https://m.media-amazon.com/images/I/815qtzaP9iL._AC_SX569_.jpg',
        'release_date' => '1994-09-23',
        'director' => 'Frank Darabont',
        'writer' => 'Stephen King (short story), Frank Darabont (screenplay)',
        'stars' => 'Tim Robbins, Morgan Freeman, Bob Gunton'
    ],
    [
        'name' => 'The Godfather',
        'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
        'genre' => 'Crime',
        'rating' => 9.2,
        'poster_url' => 'https://i.ebayimg.com/images/g/bUQAAOSwC19ixpi2/s-l1600.webp',
        'release_date' => '1972-03-24',
        'director' => 'Francis Ford Coppola',
        'writer' => 'Mario Puzo (novel), Francis Ford Coppola (screenplay)',
        'stars' => 'Marlon Brando, Al Pacino, James Caan'
    ],
    [
        'name' => 'The Dark Knight',
        'description' => 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.',
        'genre' => 'Action',
        'rating' => 9.0,
        'poster_url' => 'https://i.ebayimg.com/images/g/5ssAAOSwu4BVw43Y/s-l1600.webp',
        'release_date' => '2008-07-18',
        'director' => 'Christopher Nolan',
        'writer' => 'Jonathan Nolan, Christopher Nolan (screenplay)',
        'stars' => 'Christian Bale, Heath Ledger, Aaron Eckhart'
    ],
    [
        'name' => 'Pulp Fiction',
        'description' => 'The lives of two mob hitmen, a boxer, a gangster, and his wife intertwine in four tales of violence and redemption.',
        'genre' => 'Crime',
        'rating' => 8.9,
        'poster_url' => 'https://i.ebayimg.com/images/g/YlcAAMXQW7VRFKFG/s-l1600.jpg',
        'release_date' => '1994-10-14',
        'director' => 'Quentin Tarantino',
        'writer' => 'Quentin Tarantino (stories), Roger Avary (stories)',
        'stars' => 'John Travolta, Uma Thurman, Samuel L. Jackson'
    ],
    [
        'name' => 'The Lord of the Rings: The Return of the King',
        'description' => 'Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.',
        'genre' => 'Fantasy',
        'rating' => 8.9,
        'poster_url' => 'https://i.ebayimg.com/images/g/hHkAAOSwOGdfZVk7/s-l1600.jpg',
        'release_date' => '2003-12-17',
        'director' => 'Peter Jackson',
        'writer' => 'J.R.R. Tolkien (novel), Fran Walsh (screenplay)',
        'stars' => 'Elijah Wood, Viggo Mortensen, Ian McKellen'
    ],
    [
        'name' => 'Forrest Gump',
        'description' => 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75.',
        'genre' => 'Drama',
        'rating' => 8.8,
        'poster_url' => 'https://i.ebayimg.com/images/g/e2UAAMXQR-dRFNzP/s-l1600.jpg',
        'release_date' => '1994-07-06',
        'director' => 'Robert Zemeckis',
        'writer' => 'Winston Groom (novel), Eric Roth (screenplay)',
        'stars' => 'Tom Hanks, Robin Wright, Gary Sinise'
    ],
    [
        'name' => 'Inception',
        'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
        'genre' => 'Sci-Fi',
        'rating' => 8.8,
        'poster_url' => 'https://i.ebayimg.com/images/g/B8oAAOSw2fdg5A-h/s-l1600.jpg',
        'release_date' => '2010-07-16',
        'director' => 'Christopher Nolan',
        'writer' => 'Christopher Nolan',
        'stars' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page'
    ],
    [
        'name' => 'Fight Club',
        'description' => 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.',
        'genre' => 'Drama',
        'rating' => 8.8,
        'poster_url' => 'https://i.ebayimg.com/images/g/vc4AAOSwzvpa8PPd/s-l1600.jpg',
        'release_date' => '1999-10-15',
        'director' => 'David Fincher',
        'writer' => 'Chuck Palahniuk (novel), Jim Uhls (screenplay)',
        'stars' => 'Brad Pitt, Edward Norton, Meat Loaf'
    ],
    [
        'name' => 'The Matrix',
        'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
        'genre' => 'Sci-Fi',
        'rating' => 8,
        'poster_url' => 'https://i.ebayimg.com/images/g/114AAOSwA4dWLhe7/s-l1600.jpg',
        'release_date' => '1999-03-31',
        'director' => 'Lana Wachowski, Lilly Wachowski',
        'writer' => 'Lana Wachowski, Lilly Wachowski',
        'stars' => 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss'
    ],
    [
        'name' => 'Goodfellas',
        'description' => 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners Jimmy Conway and Tommy DeVito.',
        'genre' => 'Crime',
        'rating' => 8.7,
        'poster_url' => 'https://i.ebayimg.com/images/g/DScAAOSwEWlklf-T/s-l1600.jpg',
        'release_date' => '1990-09-19',
        'director' => 'Martin Scorsese',
        'writer' => 'Nicholas Pileggi (book), Martin Scorsese (screenplay)',
        'stars' => 'Robert De Niro, Ray Liotta, Joe Pesci'
    ],
    [
        'name' => 'The Silence of the Lambs',
        'description' => 'A young FBI cadet must confide in an incarcerated and manipulative killer to receive his help on catching another serial killer who skins his victims.',
        'genre' => 'Thriller',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/j0cAAOSw8d9Utk3s/s-l1200.jpg',
        'release_date' => '1991-02-14',
        'director' => 'Jonathan Demme',
        'writer' => 'Thomas Harris (novel), Ted Tally (screenplay)',
        'stars' => 'Jodie Foster, Anthony Hopkins, Lawrence A. Bonney'
    ],
    [
        'name' => 'Schindler\'s List',
        'description' => 'In German-occupied Poland during World War II, Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.',
        'genre' => 'History',
        'rating' => 8.9,
        'poster_url' => 'https://i.ebayimg.com/images/g/EmoAAOSwcTlbjnD0/s-l1600.jpg',
        'release_date' => '1993-12-15',
        'director' => 'Steven Spielberg',
        'writer' => 'Thomas Keneally (book), Steven Zaillian (screenplay)',
        'stars' => 'Liam Neeson, Ralph Fiennes, Ben Kingsley'
    ],
    [
        'name' => 'Interstellar',
        'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
        'genre' => 'Sci-Fi',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/zu4AAOSw2spbJQ0J/s-l1600.jpg',
        'release_date' => '2014-11-07',
        'director' => 'Christopher Nolan',
        'writer' => 'Jonathan Nolan, Christopher Nolan',
        'stars' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain'
    ],
    [
        'name' => 'Se7en',
        'description' => 'Two detectives, a rookie and a veteran, hunt a serial killer who uses the seven deadly sins as his motives.',
        'genre' => 'Crime',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/57cAAOSwT5tWGaHl/s-l1200.webp',
        'release_date' => '1995-09-22',
        'director' => 'David Fincher',
        'writer' => 'Andrew Kevin Walker',
        'stars' => 'Morgan Freeman, Brad Pitt, Kevin Spacey'
    ],
    [
        'name' => 'The Green Mile',
        'description' => 'The lives of guards on Death Row are affected by one of their charges: a black man accused of child murder and rape, yet who has a mysterious gift.',
        'genre' => 'Drama',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/F60AAOSwqXdi~gKq/s-l1200.jpg',
        'release_date' => '1999-12-10',
        'director' => 'Frank Darabont',
        'writer' => 'Stephen King (novel), Frank Darabont (screenplay)',
        'stars' => 'Tom Hanks, Michael Clarke Duncan, David Morse'
    ],
    [
        'name' => 'Gladiator',
        'description' => 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.',
        'genre' => 'Action',
        'rating' => 8.5,
        'poster_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU7VWv9Z4LVJA-Htb3PDo9VZDPcqmrlOLERQ&s',
        'release_date' => '2000-05-05',
        'director' => 'Ridley Scott',
        'writer' => 'David Franzoni (story), John Logan (screenplay)',
        'stars' => 'Russell Crowe, Joaquin Phoenix, Connie Nielsen'
    ],
    [
        'name' => 'The Lion King',
        'description' => 'Lion prince Simba and his father are targeted by his bitter uncle, who wants to ascend the throne himself.',
        'genre' => 'Animation',
        'rating' => 8.5,
        'poster_url' => 'https://i.ebayimg.com/images/g/XOsAAOSwX1pfiAia/s-l1200.jpg',
        'release_date' => '1994-06-24',
        'director' => 'Roger Allers, Rob Minkoff',
        'writer' => 'Irene Mecchi (screenplay), Jonathan Roberts (screenplay)',
        'stars' => 'Matthew Broderick, Jeremy Irons, James Earl Jones'
    ],
    [
        'name' => 'Back to the Future',
        'description' => 'Marty McFly, a 17-year-old high school student, is accidentally sent 30 years into the past in a time-traveling DeLorean invented by his close friend, eccentric scientist Doc Brown.',
        'genre' => 'Adventure',
        'rating' => 8.5,
        'poster_url' => 'https://m.media-amazon.com/images/I/71nSvUX6tQL._AC_UF894,1000_QL80_.jpg',
        'release_date' => '1985-07-03',
        'director' => 'Robert Zemeckis',
        'writer' => 'Robert Zemeckis, Bob Gale',
        'stars' => 'Michael J. Fox, Christopher Lloyd, Lea Thompson'
    ],
    [
        'name' => 'Saving Private Ryan',
        'description' => 'Following the Normandy Landings, a group of U.S. soldiers go behind enemy lines to retrieve a paratrooper whose brothers have been killed in action.',
        'genre' => 'War',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/zMcAAOSw6IVgwxTv/s-l1600.jpg',
        'release_date' => '1998-07-24',
        'director' => 'Steven Spielberg',
        'writer' => 'Robert Rodat',
        'stars' => 'Tom Hanks, Matt Damon, Tom Sizemore'
    ],
    [
        'name' => 'Parasite',
        'description' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
        'genre' => 'Thriller',
        'rating' => 8.6,
        'poster_url' => 'https://i.ebayimg.com/images/g/hBIAAOSwrpRd2XoM/s-l1600.jpg',
        'release_date' => '2019-05-30',
        'director' => 'Bong Joon Ho',
        'writer' => 'Bong Joon Ho, Han Jin Won',
        'stars' => 'Kang-ho Song, Sun-kyun Lee, Yeo-jeong Cho'
    ]
];

// Insert data into database
$stmt = $conn->prepare("INSERT INTO movies (name, description, genre, rating, poster_url, release_date, director, writer, stars) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($movies as $movie) {
    $stmt->bind_param("sssdsssss", $movie['name'], $movie['description'], $movie['genre'], $movie['rating'], $movie['poster_url'], $movie['release_date'], $movie['director'], $movie['writer'], $movie['stars']);
    $stmt->execute();
}

echo "Data inserted successfully.";

$stmt->close();
$conn->close();
?>
