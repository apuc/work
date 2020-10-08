$(document).ready(function () {
    $('.kv-row-checkbox').change(function () {
        $('#grid-delete-button').prop('disabled', $(".kv-row-checkbox:checked").length === 0);
        $('#grid-restore-button').prop('disabled', $(".kv-row-checkbox:checked").length === 0);
    });
    function send(url) {
        let ids = [];
        $(".kv-row-checkbox:checked").each(function (index, element) {
            ids.push($(element).val());
        });
        if (ids.length > 0) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {'ids': ids},
                success: function (html) {
                    window.location.reload();
                }
            });
        }
    }
    $('#grid-delete-button').click(function () {
        send($(this).data('url'));
    });
    $('#grid-restore-button').click(function () {
        send($(this).data('url'));
    });
});