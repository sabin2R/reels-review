document.addEventListener('DOMContentLoaded', function() {
    var movies = JSON.parse(document.getElementById('movies-data').textContent);
    var movieGrid = document.getElementById('movie-grid');
    var carouselInner = document.querySelector('.carousel-inner');

    function getRandomMovies(num) {
        var shuffled = movies.sort(() => 0.5 - Math.random());
        return shuffled.slice(0, num);
    }

    function truncateDescription(description, maxLength) {
        if (description.length > maxLength) {
            return description.substring(0, maxLength) + '...';
        }
        return description;
    }

    function displayMovies(movieList) {
        movieGrid.innerHTML = '';
        movieList.forEach(function(movie) {
            var movieCard = `
                <div class="col-md-3 movie-card">
                    <a href="detailed_film.php?id=${movie.id}" class="text-decoration-none">
                        <img src="${movie.poster_url}" alt="${movie.name}">
                        <span class="favorite" data-id="${movie.id}"><i class ="fas fa-heart"></i></span>
                        <h5>${movie.name}</h5>
                        <p class="rating" data-rating="${movie.rating}"> ${movie.rating} ⭐</p>
                    </a>
                </div>
            `;
            movieGrid.insertAdjacentHTML('beforeend', movieCard);
        });
        attachEventListeners();
    }

    

    function displayCarousel(movieList) {
        carouselInner.innerHTML = '';
        movieList.forEach(function(movie, index) {
            var activeClass = index === 0 ? 'active' : '';
            var carouselItem = `
                <div class="carousel-item ${activeClass}">
                    <img src="${movie.poster_url}" alt="${movie.name}">
                    <div class="carousel-caption">
                        <h5>${movie.name}</h5>
                        
                    </div>
                </div>
            `;
            carouselInner.insertAdjacentHTML('beforeend', carouselItem);
        });
    }

    function addToFavorites(movieId) {
        $.post('add_to_favorites.php', { movie_id: movieId }, function(response) {
            if (response.success) {
                alert('Added to favorites');
            } else {
                alert('Failed to add to favorites: ' + response.message);
            }
        }, 'json');
    }

    function attachEventListeners() {
        document.querySelectorAll('.favorite').forEach(function(el) {
            el.addEventListener('click', function(event) {
                event.preventDefault();
                var movieId = this.getAttribute('data-id');
                addToFavorites(movieId);
            });
        });
    }

    function filterMoviesByGenre(genre) {
        return movies.filter(function(movie) {
            return genre === '' || movie.genre === genre;
        });
    }

    function sortMovies(movieList, sortBy) {
        return movieList.sort(function(a, b) {
            if (sortBy === 'name') {
                return a.name.localeCompare(b.name);
            } else if (sortBy === 'rating') {
                return b.rating - a.rating;
            }
            return 0;
        });
    }

    document.getElementById('genre-filter').addEventListener('change', function() {
        var genre = this.value;
        var sortedBy = document.getElementById('sort-options').value;
        var filteredMovies = filterMoviesByGenre(genre);
        var sortedMovies = sortMovies(filteredMovies, sortedBy);
        displayMovies(sortedMovies);
    });

    document.getElementById('sort-options').addEventListener('change', function() {
        var sortedBy = this.value;
        var genre = document.getElementById('genre-filter').value;
        var filteredMovies = filterMoviesByGenre(genre);
        var sortedMovies = sortMovies(filteredMovies, sortedBy);
        displayMovies(sortedMovies);
    });


    

var randomMovies = getRandomMovies(3);
    displayCarousel(randomMovies);
    displayMovies(movies);

    document.getElementById('view-all').addEventListener('click', function() {
        displayMovies(movies);
    });

    document.getElementById('search-input').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var filteredMovies = movies.filter(function(movie) {
            return movie.name.toLowerCase().includes(searchQuery) || movie.description.toLowerCase().includes(searchQuery);
        });
        displayMovies(filteredMovies);
    });
});