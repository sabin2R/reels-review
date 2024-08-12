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
    ],
    [
        'name' => 'The Departed',
        'description' => 'An undercover cop and a mole in the police attempt to identify each other while infiltrating an Irish gang in Boston.',
        'genre' => 'Crime',
        'rating' => 8.5,
        'poster_url' => 'https://i.ebayimg.com/images/g/b8YAAOxy1RZSViYb/s-l1200.webp',
        'release_date' => '2006-10-06',
        'director' => 'Martin Scorsese',
        'writer' => 'William Monahan (screenplay), Alan Mak (story)',
        'stars' => 'Leonardo DiCaprio, Matt Damon, Jack Nicholson'
    ],
    [
        'name' => 'Whiplash',
        'description' => 'A promising young drummer enrolls at a cut-throat music conservatory where his dreams of greatness are mentored by an instructor who will stop at nothing to realize a student\'s potential.',
        'genre' => 'Drama',
        'rating' => 8.5,
        'poster_url' => 'https://i.ebayimg.com/images/g/h2QAAOSwdPBjXy~X/s-l1200.webp',
        'release_date' => '2014-10-10',
        'director' => 'Damien Chazelle',
        'writer' => 'Damien Chazelle',
        'stars' => 'Miles Teller, J.K. Simmons, Melissa Benoist'
    ],
    [
        'name' => 'The Prestige',
        'description' => 'After a tragic accident, two stage magicians engage in a battle to create the ultimate illusion while sacrificing everything they have to outwit each other.',
        'genre' => 'Drama',
        'rating' => 8.5,
        'poster_url' => 'https://i.ebayimg.com/images/g/UaYAAOSw-3FZFjti/s-l1600.jpg',
        'release_date' => '2006-10-20',
        'director' => 'Christopher Nolan',
        'writer' => 'Jonathan Nolan, Christopher Nolan (screenplay)',
        'stars' => 'Christian Bale, Hugh Jackman, Scarlett Johansson'
    ],
    [
        'name' => 'The Usual Suspects',
        'description' => 'A sole survivor tells of the twisty events leading up to a horrific gun battle on a boat, which begin when five criminals meet at a seemingly random police lineup.',
        'genre' => 'Crime',
        'rating' => 8.5,
        'poster_url' => 'https://i.ebayimg.com/images/g/1CMAAOSwMOli-GGp/s-l1600.jpg',
        'release_date' => '1995-08-16',
        'director' => 'Bryan Singer',
        'writer' => 'Christopher McQuarrie',
        'stars' => 'Kevin Spacey, Gabriel Byrne, Chazz Palminteri'
    ],
    [
        'name' => 'The Shining',
        'description' => 'A family heads to an isolated hotel for the winter where a sinister presence influences the father into violence, while his psychic son sees horrific forebodings from both past and future.',
        'genre' => 'Horror',
        'rating' => 8.4,
        'poster_url' => 'https://i.ebayimg.com/images/g/ti8AAOSwoWFfWyhA/s-l1600.jpg',
        'release_date' => '1980-05-23',
        'director' => 'Stanley Kubrick',
        'writer' => 'Stephen King (novel), Stanley Kubrick (screenplay)',
        'stars' => 'Jack Nicholson, Shelley Duvall, Danny Lloyd'
    ],
    [
        'name' => 'Mad Max: Fury Road',
        'description' => 'In a post-apocalyptic wasteland, Max teams up with a mysterious woman, Furiosa, to try and survive.',
        'genre' => 'Action',
        'rating' => 8.1,
        'poster_url' => 'https://i.ebayimg.com/images/g/38sAAOSwdRdgSdGL/s-l1600.jpg',
        'release_date' => '2015-05-15',
        'director' => 'George Miller',
        'writer' => 'George Miller, Brendan McCarthy',
        'stars' => 'Tom Hardy, Charlize Theron, Nicholas Hoult'
    ],
    [
        'name' => 'The Social Network',
        'description' => 'As Harvard student Mark Zuckerberg creates the social networking site that would become known as Facebook, he is sued by the twins who claimed he stole their idea, and by the co-founder who was later squeezed out of the business.',
        'genre' => 'Biography',
        'rating' => 7.7,
        'poster_url' => 'https://i.ebayimg.com/images/g/uXgAAOSw0eZiglWs/s-l1600.jpg',
        'release_date' => '2010-10-01',
        'director' => 'David Fincher',
        'writer' => 'Aaron Sorkin (screenplay), Ben Mezrich (book)',
        'stars' => 'Jesse Eisenberg, Andrew Garfield, Justin Timberlake'
    ],
    [
        'name' => 'The Wolf of Wall Street',
        'description' => 'Based on the true story of Jordan Belfort, from his rise to a wealthy stock-broker living the high life to his fall involving crime, corruption, and the federal government.',
        'genre' => 'Biography',
        'rating' => 8.2,
        'poster_url' => 'https://i.ebayimg.com/images/g/TyUAAOSwjxZgz6Rj/s-l1600.jpg',
        'release_date' => '2013-12-25',
        'director' => 'Martin Scorsese',
        'writer' => 'Terence Winter (screenplay), Jordan Belfort (book)',
        'stars' => 'Leonardo DiCaprio, Jonah Hill, Margot Robbie'
    ],
    [
        'name' => 'Joker',
        'description' => 'In Gotham City, mentally troubled comedian Arthur Fleck embarks on a downward spiral of social revolution and bloody crime. This path brings him face-to-face with his infamous alter-ego: the Joker.',
        'genre' => 'Crime',
        'rating' => 8.4,
        'poster_url' => 'https://i.ebayimg.com/images/g/aN0AAOSw50BduC3-/s-l1200.webp',
        'release_date' => '2019-10-04',
        'director' => 'Todd Phillips',
        'writer' => 'Todd Phillips, Scott Silver',
        'stars' => 'Joaquin Phoenix, Robert De Niro, Zazie Beetz'
    ],
    [
        'name' => 'Inglourious Basterds',
        'description' => 'In Nazi-occupied France during World War II, a plan to assassinate Nazi leaders by a group of Jewish U.S. soldiers coincides with a theatre owner\'s vengeful plans for the same.',
        'genre' => 'Adventure',
        'rating' => 8.3,
        'poster_url' => 'https://i.ebayimg.com/00/s/MTYwMFgxMTgw/z/F9UAAOSw171gr4Oa/$_57.JPG?set_id=8800005007',
        'release_date' => '2009-08-21',
        'director' => 'Quentin Tarantino',
        'writer' => 'Quentin Tarantino',
        'stars' => 'Brad Pitt, Diane Kruger, Eli Roth'
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
