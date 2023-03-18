$(function() {
    /**
     * @purpose : show confirm model
     */
    $(".publish").click(function(e) {
        $('#post_id').val($(this).data("id"));
        $('#publishModal').modal('show');
    });
    /**
     * @purpose : show confirm model
     */
    $(".delete").click(function(e) {
        $('#delete_post_id').val($(this).data("id"));
        $('#deleteModal').modal('show');
    });
});