$(document).ready(function (){
    $('ul.menu li').mouseenter(function(){
        $(this).children('ul').slideDown('fast');
    });

    $('ul.menu li').mouseleave(function(){
        $(this).children('ul').slideUp('fast');
    });

});