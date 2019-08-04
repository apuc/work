/**
 * Created by waryataw on 21.10.2016.
 */

$(document).ready(function(){

    $('#faq-type').change(function () {
        var faqtype = $("#faq-type").val();
        $('#faq-cat_id select').val = '';
        if (faqtype){
            $.ajax({
                type: "POST",
                 url: "/secure/category_faq/category_faq/get_catfaq_by_type",
                data: "slug=" + faqtype,
                success: function (data) {
                    $('#faq-cat_id').html(data).slideDown();
                    $('.field-faq-cat_id').slideDown();
                    $('.field-faq-cat_id label').slideDown();
                }
            });
        } else $('.field-faq-cat_id').slideUp();
    });

    $('#postsconsulting-type').change(function () {
        var faqtype = $("#postsconsulting-type").val();
        $('#postsconsulting-cat_id select').val = '';
        if (faqtype){
            $.ajax({
                type: "POST",
                url: "/secure/category_posts_consulting/category_posts_consulting/get_cat_post_by_type",
                data: "slug=" + faqtype,
                success: function (data) {
                    $('#postsconsulting-cat_id').html(data).slideDown();
                    $('.field-postsconsulting-cat_id').slideDown();
                    $('.field-postsconsulting-cat_id label').slideDown();
                }
            });
        } else $('.field-postsconsulting-cat_id').slideUp();
    }); 
    
    $('#postsdigest-type').change(function () {
        
        var faqtype = $("#postsdigest-type").val();
        $('#postsdigest-cat_id select').val = '';
        if (faqtype){
            $.ajax({
                type: "POST",
                url: "/secure/category_posts_digest/category_posts_digest/get_cat_post_by_type",
                data: "slug=" + faqtype,
                success: function (data) {
                    $('#postsdigest-cat_id').html(data).slideDown();
                    $('.field-postsdigest-cat_id').slideDown();
                    $('.field-postsdigest-cat_id label').slideDown();
                }
            });
        } else $('.field-postsdigest-cat_id').slideUp();
    });

});