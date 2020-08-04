
$(function(){
    $(".problem-item").click(function(){
        $(".problem-list").toggleClass("active");
    });
    $(".problem-list li").click(function(){
        $(".problem-item").html($(this).html());
        $(".problem-list").removeClass("active");
    });
});