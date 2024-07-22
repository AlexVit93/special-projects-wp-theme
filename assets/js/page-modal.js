jQuery(document).ready(function($) {
    $('.article__link').on('click', function(event) {
        event.preventDefault();
        var postId = $(this).data('id');
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'get_page_content',
                post_id: postId
            },
            success: function(response) {
                $('#page-modal-body').html(response);
                $('#page-modal').show();
            }
        });
    });

    $('.page-close').on('click', function() {
        $('#page-modal').hide();
    });

    $(document).on('keydown', function(event) {
        if (event.key === "Escape") {
            $('#page-modal').hide();
        }
    });
});
