document.addEventListener('DOMContentLoaded', function() {
    var movieGrid = document.getElementById('movie-grid');

    function truncateDescription(description, maxLength) {
        if (description.length > maxLength) {
            return description.substring(0, maxLength) + '...';
        }
        return description;
    }

    function displayMovies(movieList, view) {
        movieGrid.innerHTML = '';
        movieList.forEach(function(movie, index) {
            var favoriteClass = movie.isFavorite ? 'active' : '';
            var movieCard = `
                <div class="${view === 'list' ? 'col-12 movie-list-item' : 'col-md-4 movie-card mb-4'}">
                    <a href="detailed_film.php?id=${movie.id}" class="text-decoration-none">
                        <div class="d-flex ${view === 'list' ? '' : 'flex-column'}">
                            <img src="${movie.poster_url}" alt="${movie.name}" class="${view === 'list' ? 'list-view-img' : 'img-fluid'}">
                            <div class="movie-info ml-3 ${view === 'list' ? '' : 'text-left'}">
                                ${view === 'list' ? `<h5>${index + 1}. ${movie.name}</h5>` : `<h5> ${movie.name}</h5>`}
                                <div class="details">
                                
                                    <p> ${movie.release_date}</p>
                                    <p> ${movie.genre}</p>
                                    <p> ${movie.rating} ⭐</p>
                                </div>
                            </div>
                        </div>
                        <span class="favorite-icon ${favoriteClass} ${view === 'list' ? '' : 'favorite-icon-grid'}" data-id="${movie.id}"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            `;
            movieGrid.insertAdjacentHTML('beforeend', movieCard);
        });
        attachFavoriteEventListeners();
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

    function attachFavoriteEventListeners() {
        var favoriteIcons = document.querySelectorAll('.favorite-icon');
        favoriteIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                var movieId = this.getAttribute('data-id');
                this.classList.toggle('active');
                toggleFavorite(movieId);
            });
        });
    }

    function toggleFavorite(movieId) {
        $.ajax({
            type: 'POST',
            url: 'add_to_favorites.php',
            data: { movie_id: movieId },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error('Error adding to favorites:', error);
            }
        });
    }

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
