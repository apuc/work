$(document).ready(function () {
    $('.kv-row-checkbox').change(function () {
        let deleteButton = $('#grid-delete-button');
        if ($(".kv-row-checkbox:checked").length === 0) {
            deleteButton.prop('disabled', true);
        } else {
            deleteButton.prop('disabled', false);
        }
    });
    $('#grid-delete-button').click(function () {
        let ids = [];
        $(".kv-row-checkbox:checked").each(function (index, element) {
            ids.push($(element).val());
        });
        if (ids.length > 0) {
            $.ajax({
                type: 'POST',
                url: $(this).data('url'),
                data: {'ids': ids},
                success: function (html) {
                    window.location.reload();
                }
            });
        }
    });
});