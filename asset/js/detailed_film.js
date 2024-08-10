$(document).ready(function() {
    function submitReview() {
        var reviewText = $('#review-text').val();
        if (reviewText.trim() === '') {
            alert('Please write a review.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'submit_review.php',
            data: {
                movie_id: movieId,
                review_text: reviewText
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error submitting review:', error);
                alert('An error occurred while submitting your review.');
            }
        });
    }

    $('#your-rating').on('change', function() {
        var rating = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'submit_rating.php',
            data: {
                movie_id: movieId,
                rating: rating
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
            },
            error: function(error) {
                console.error('Error submitting rating:', error);
                alert('An error occurred while submitting your review.');
            }
        });
    });

    $('.favorite-icon').on('click', function() {
        var icon = $(this);
        var movieId = icon.data('id');
        
        $.ajax({
            type: 'POST',
            url: 'toggle_favorite.php',
            data: { movie_id: movieId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    icon.toggleClass('active');
                    alert(response.message);
                } else {
                    alert('Failed to toggle favorite: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error toggling favorite:', error);
                alert('An error occurred while toggling favorite.');
            }
        });
    });

    window.submitReview = submitReview; // Make function available globally
});
