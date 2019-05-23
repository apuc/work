$(document).ready(function(){
    function search(){
        var experiences = $("input[name='experience']:checked");
        var experienceIds = [];
        experiences.each(function(){
            experienceIds.push($(this).data('id'));
        });
        var categories = $("input[name='category']:checked");
        var categoryIds = [];
        categories.each(function(){
            categoryIds.push($(this).data('id'));
        });
        var employment_types = $("input[name='employment_type']:checked");
        var employment_typeIds = [];
        employment_types.each(function(){
            employment_typeIds.push($(this).data('id'));
        });

        var min_salary = $("input[name='min_salary']");
        var max_salary = $("input[name='max_salary']");
        var search_text = $("input[name='vacancy_search_text']");
        var jsCitiesSelect = $(".jsCitiesSelect");
        window.location.href="/vacancy/search?" +
            "experience_ids=" + JSON.stringify(experienceIds) +
            "&category_ids=" + JSON.stringify(categoryIds) +
            "&employment_type_ids="+JSON.stringify(employment_typeIds) +
            "&min_salary="+min_salary.val() +
            "&max_salary="+max_salary.val() +
            "&search_text="+search_text.val()+
            "&city="+jsCitiesSelect.val();
    }
    $(document).on('click', '#accept', function () {
        search();
    });
    $(document).on('click', '#search', function () {
        search();
    });
});