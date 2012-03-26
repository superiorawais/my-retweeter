$(document).ready(function(){
    $(".close").click(
        function () {
            $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                $(this).slideUp(400);
            });
            return false;
        }
    );
        
    /* HASH TAG */
    $("#add-hashtag-button").click(function(){
        $("#add-trigger").fadeOut(function(){
           $("#add-hashtag").fadeIn(); 
        });
    });
    $("#add-hashtag-cancel").click(function(){
        $("#add-hashtag").fadeOut(function(){
           $("#add-trigger").fadeIn(); 
        });
    });
    $(".placeholding-input span").click(function(){
        $(this).prev('input').focus();
    });
    
    /* SOURCE TIME */
    $("#add-time-button").click(function(){
        $("#add-time-trigger").fadeOut(function(){
           $("#add-time").fadeIn(); 
        });
    });
    $("#add-time-cancel").click(function(){
        $("#add-time").fadeOut(function(){
           $("#add-time-trigger").fadeIn(); 
        });
    });
});

function input_change(obj){
    if($(obj).val()!=''){
        $(obj).next().animate({
            opacity:0
        },200);
    }else{
        $(obj).next().animate({
            opacity:1
        },200);
    }
}