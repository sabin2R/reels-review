document.addEventListener('DOMContentLoaded', function() {
    var favoriteGrid = document.getElementById('favorite-grid');

    function displayFavorites(movieList) {
        favoriteGrid.innerHTML = '';
        movieList.forEach(function(movie) {
            var movieCard = `
                <div class="col-md-3 movie-card">
                    <a href="detailed_film.php?id=${movie.id}" class="text-decoration-none">
                        <img src="${movie.poster_url}" alt="${movie.name}" class="img-fluid">
                        <h5>${movie.name}</h5>
                        <p>${movie.description}</p>
                        <p class="rating" data-rating="${movie.rating}">Rating: ${movie.rating} ⭐</p>
                        <button class="btn btn-danger remove-favorite" data-id="${movie.id}">Remove from Favorites</button>
                    </a>
                </div>
            `;
            favoriteGrid.insertAdjacentHTML('beforeend', movieCard);
        });

        // Attach event listeners to the remove buttons
        attachRemoveFavoriteListeners();
    }

    function attachRemoveFavoriteListeners() {
        document.querySelectorAll('.remove-favorite').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent navigating to the movie detail page
                var movieId = this.getAttribute('data-id');
                removeFromFavorites(movieId, this);
            });
        });
    }

    function removeFromFavorites(movieId, button) {
        $.ajax({
            url: 'remove_favorite.php',
            method: 'POST',
            data: { movie_id: movieId },
            success: function(response) {
                if (response === 'removed') {
                    // Remove the movie card from the grid
                    button.closest('.movie-card').remove();
                } else {
                    alert('Failed to remove from favorites');
                }
            }
        });
    }

    // Display favorite movies on page load
    displayFavorites(favoriteMoviesData);
});
