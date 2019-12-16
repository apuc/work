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
        var jsDutiesSelect = $(".jsDutiesSelect");
        var href="/vacancy";
        var question_mark=false;
        var and=false;
        if(jsCitiesSelect.val()) {
            if(categories.length === 1) {
                href+="/"+jsCitiesSelect.val();
                href+="/"+categories[0].getAttribute('data-slug');
            }
            else if(categories.length === 0) {
                href+="/"+jsCitiesSelect.val();
            }
            else {
                href+="/"+jsCitiesSelect.val();
                if(!question_mark){
                    question_mark=true;
                    href+="?";
                }
                if(and)
                    href+="&";
                else
                    and=true;
                href+="category_ids=" + JSON.stringify(categoryIds);
            }
        } else if(categories.length === 1) {
            href+="/"+categories[0].getAttribute('data-slug');
        } else if(categories.length > 1) {
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="category_ids=" + JSON.stringify(categoryIds);
        }
        if(search_text.val()){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="search_text=" + search_text.val();
        }
        if(experienceIds.length>0){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="experience_ids=" + JSON.stringify(experienceIds);
        }
        if(employment_typeIds.length>0){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="employment_type_ids=" + JSON.stringify(employment_typeIds);
        }
        if(jsDutiesSelect.val().length>0){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="tags_id=" + JSON.stringify(jsDutiesSelect.val());
        }
        if(min_salary.val()){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="min_salary=" + min_salary.val();
        }
        if(max_salary.val()){
            if(!question_mark){
                question_mark=true;
                href+="?";
            }
            if(and)
                href+="&";
            else
                and=true;
            href+="max_salary=" + max_salary.val();
        }
        console.log(href);
        window.location.href=href;
    }
    $(document).on('click', '#accept', function () {
        search();
    });
    $(document).on('click', '#search', function () {
        search();
    });
    $('.jsCheckBlock').keydown(function(eventObject){
        if (eventObject.keyCode == 13){
            search();
        }
    });
    $('.search').keydown(function(eventObject){
        if (eventObject.keyCode == 13){
            search();
        }
    });
});