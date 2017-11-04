/**
 * Created by Arnold on 4-11-2017.
 */

var popupIsOpen = false;

//Opens the login popup
function openLogin(){

    $("#login_popup").show();
    popupIsOpen = true;

}

//Closes the login popup
function closeLogin(){

    $("#login_popup").hide();
    popupIsOpen = false;

}

function openRegister(){

    $("#register_popup").show();
    popupIsOpen = true;

}

function closeRegister(){

    $("#register_popup").hide();
    popupIsOpen = false;

}

function fromLoginToRegister(){

    closeLogin();
    openRegister();

}

//These functions need to be loaded once the document has been finished loading
$(function(){

    var $overlay = $(".overlay");
    $overlay.click(function(e){
        if(popupIsOpen){
            if(e.target==e.currentTarget){  //Word er wel naast het popup geklikt?
                closeLogin();
                closeRegister();
            }
        }
    });

});