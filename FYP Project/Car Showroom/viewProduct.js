$(document).ready(function() {
    $('#addToFavourites').on('click', function(e) {
        e.preventDefault();

        var carId = $(this).data('id');

        $.ajax({
            url: 'add_to_favourites.php',
            type: 'POST',
            data: { id: carId },
            success: function(response) {
                alert(response);
                $('#viewFavorites').addClass('animate__animated animate__wobble');
                setTimeout(function() {
                    $('#viewFavorites').removeClass('animate__animated animate__wobble');
                }, 1000);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#viewFavorites').on('click', function(e) {
        e.preventDefault();

        $('html, body').animate({ scrollTop: 0 }, 'fast');
        loadFavorites();
        $('#favorites').addClass('open');
    });

    $('#favorites .close').on('click', function() {
        $('#favorites').removeClass('open');
    });

    function loadFavorites() {
        $.ajax({
            url: 'get_favourites.php',
            type: 'GET',
            success: function(response) {
                $('#favoritesList').html(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
});

$(document).ready(function() {
    // Click handler for removeFavorite buttons
    $(document).on('click', '.removeFavorite', function() {
        var favoriteId = $(this).closest('.favoriteItem').data('id');

        // AJAX call to delete favorite
        $.ajax({
            url: 'remove_favorite.php',
            type: 'POST',
            data: { id: favoriteId },
            success: function(response) {
                console.log(response); // Log response for debugging
                loadFavorites(); // Reload favorites list after removal
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    // Function to load favorites
    function loadFavorites() {
        $.ajax({
            url: 'get_favorites.php',
            type: 'GET',
            success: function(response) {
                $('#favoritesList').html(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
});
