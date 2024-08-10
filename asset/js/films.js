document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");

    var movieGrid = document.getElementById('movie-grid');
    var searchInput = document.getElementById('search-movies');

    function displayMovies(movieList, view) {
        movieGrid.innerHTML = '';
        movieList.forEach(function(movie, index) {
            var favoriteClass = favoritedMoviesData.includes(movie.id) ? 'active' : '';
            var movieCard = `
                <div class="${view === 'list' ? 'col-12 movie-list-item' : 'col-md-4 movie-card mb-4'}">
                    <div class="d-flex ${view === 'list' ? '' : 'flex-column'}">
                        <a href="detailed_film.php?id=${movie.id}" class="text-decoration-none flex-grow-1">
                            <img src="${movie.poster_url}" alt="${movie.name}" class="${view === 'list' ? 'list-view-img' : 'img-fluid'}">
                            <div class="movie-info ml-3 ${view === 'list' ? '' : 'text-left'}">
                                ${view === 'list' ? `<h5>${index + 1}. ${movie.name}</h5>` : `<h5>${movie.name}</h5>`}
                                <div class="details">
                                    <p>${movie.release_date}</p>
                                    <p>${movie.genre}</p>
                                    <p>${movie.rating} ⭐</p>
                                </div>
                            </div>
                        </a>
                        <span class="favorite-icon ${favoriteClass} ${view === 'list' ? '' : 'favorite-icon-grid'}" data-id="${movie.id}"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            `;
            movieGrid.insertAdjacentHTML('beforeend', movieCard);
        });
        attachFavoriteEventListeners();
    }

    function attachFavoriteEventListeners() {
        document.querySelectorAll('.favorite-icon').forEach(function(el) {
            el.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the click from navigating to the movie detail page
                var movieId = this.getAttribute('data-id');
                toggleFavorite(movieId, this);
            });
        });
    }

    function toggleFavorite(movieId, element) {
        $.post('toggle_favorite.php', { movie_id: movieId }, function(response) {
            if (response.success) {
                element.classList.toggle('active'); // Toggle the active state of the favorite icon
            } else {
                alert('Failed to update favorites: ' + response.message);
            }
        }, 'json');
    }

    function filterMovies(searchTerm) {
        return moviesData.filter(function(movie) {
            return movie.name.toLowerCase().includes(searchTerm.toLowerCase());
        });
    }

    searchInput.addEventListener('input', function() {
        var searchTerm = this.value;
        console.log("Search Term:", searchTerm);
        var filteredMovies = filterMovies(searchTerm);
        console.log("Filtered Movies:", filteredMovies);
        var sortedBy = document.getElementById('sort-options').value;
        var sortedMovies = sortMovies(filteredMovies, sortedBy);
        displayMovies(sortedMovies, document.querySelector('.active-view').id);
    });

    document.getElementById('sort-options').addEventListener('change', function() {
        var sortedBy = this.value;
        var sortedMovies = sortMovies(moviesData, sortedBy);
        displayMovies(sortedMovies, document.querySelector('.active-view').id);
    });

    document.getElementById('grid-view').addEventListener('click', function() {
        this.classList.add('active-view');
        document.getElementById('list-view').classList.remove('active-view');
        displayMovies(moviesData, 'grid');
    });

    document.getElementById('list-view').addEventListener('click', function() {
        this.classList.add('active-view');
        document.getElementById('grid-view').classList.remove('active-view');
        displayMovies(moviesData, 'list');
    });

    // Default view
    document.getElementById('grid-view').classList.add('active-view');
    displayMovies(moviesData, 'grid');
});
