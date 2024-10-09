$(function(){
    var tagP =$('.text, .text2').hide(5000);
    $('.text, .text2').show(3000); 
});


$(document).ready(function(){
    var cont_left = $(".group1, .group2, .group3, .group4").position().left;
    $(".group1, .group2, .group3, .group4").hover(function(){
        $(this).parent().parent().css("z-index", 1);
        $(this).animate({
            height:"370px",
            width:"472px",
            left:"-=15",
            top:"-=15"
        },"fast");},
        function(){
            //отдаление
        $(this).parent().parent().css("z-index", 0);
        $(this).animate({
            height:"320",
            width:"452",
            left:"+=37",
            top:"+=37"         
        },"fast");});
    $(".group1, .group2, .group3, .group4").each(function(index){
        var left = (index *160) + cont_left;
        $(this).css("left", left+"px");
    });
});


$(document).ready(function(){
    $(".text3").on({
        mouseover:function(){
            $(this).css("color", "green")
        },
        mouseleave:function(){
            $(this).css("color", "black");
        }
    });
});