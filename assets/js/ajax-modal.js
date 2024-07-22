jQuery(document).ready(function($) {
    $('.promotion__more__link').on('click', function() {
        var postId = $(this).data('id');
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'get_news_content',
                post_id: postId
            },
            success: function(response) {
                $('#modal-body').html(response);
                $('#news-modal').show();
            },
            crossDomain: true 
        });
    });

    $(document).on('click', '.nsclose', function() {
        $('#news-modal').hide();
    });

    $(document).on('keydown', function(event) {
        if (event.key === "Escape") {
            $('#news-modal').hide();
        }
    });

    $(window).on('click', function(event) {
        if ($(event.target).is('#news-modal')) {
            $('#news-modal').hide();
        }
    });
});
