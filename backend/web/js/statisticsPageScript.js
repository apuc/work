$(document).ready(function(){
    $('#chart_type').change(function () {
        if($(this).val() == 1 || $(this).val() == 2) {
            $('#view_type').addClass('hidden');
        }
        if($(this).val() == 3 || $(this).val() == 4) {
            $('#view_type').removeClass('hidden');
        }
    })
});