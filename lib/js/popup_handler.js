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

function openAddAddress(){

    $popup = $("#address_popup");

    $("h2.addAddress",$popup).show();
    $("h2.editAddress",$popup).hide();
    $("h2.editreview",$popup).hide();
    $("table#editAddressSubmit",$popup).hide();
    $("table#addAddressSubmit",$popup).show();

    $("input#street_IN").val("");
    $("input#housenumber_IN").val("");
    $("input#postalcode_IN").val("");
    $("input#city_IN").val("");
    $("input#address_id_IN").val("");
    $("input#inputType").val("addAddress");

    $popup.show();
    popupIsOpen = true;

}

function closeAddAddress(){

    $("#address_popup").hide();
    popupIsOpen = false;

}

function openEditAddress(streetname, housenumber, postalcode, city, address_id){

    $popup = $("#address_popup");

    $("h2.addAddress",$popup).hide();
    $("h2.editAddress",$popup).show();
    $("table#editAddressSubmit",$popup).show();
    $("table#addAddressSubmit",$popup).hide();

    $("input#street_IN").val(streetname);
    $("input#housenumber_IN").val(housenumber);
    $("input#postalcode_IN").val(postalcode);
    $("input#city_IN").val(city);
    $("input#address_id_IN").val(address_id);
    $("input#inputType").val("editAddress");

    $popup.show();
    popupIsOpen = true;

}

function deleteAddress(boolean){
    $("input#inputDeleteCheck").val(boolean);
    if(confirm("Weet je zeker dat je dit adres wil verwijderen?")==true){
        $("#address_form input[type='submit']").click()
    }

}
//Reviews
function deleteReview(boolean){
    $("input#inputDeleteCheck").val(boolean);
    if(confirm("Weet je zeker dat je dit adres wil verwijderen?")==true){
        $("#review_form input[type='submit']").click()
    }

}
function openEditReview(title, description, rating, review_id){

    $popup = $("#review_popup");

    $("h2.editReview",$popup).show();
    $("h2.addAddress",$popup).hide();
    $("h2.editAddress",$popup).hide();
    $("table#editReviewSubmit",$popup).show();
    $("table#addReviewSubmit",$popup).hide();

    $("input#title_IN").val(title);
    $("input#description_IN").val(description);
    $("input#rating_IN").val(rating);
    $("input#review_id_IN").val(review_id);
    $("input#inputType").val("editReview");

    $popup.show();
    popupIsOpen = true;

}
function closeEditReview(){

    $("#review_popup").hide();
    popupIsOpen = false;

}

//These functions need to be loaded once the document has been finished loading
$(function(){

    var $overlay = $(".overlay");
    $overlay.click(function(e){
        if(popupIsOpen){
            if(e.target==e.currentTarget){  //Word er wel naast het popup geklikt?
                closeAddAddress();
                closeLogin();
                closeRegister();
                closeEditReview();
            }
        }
    });

});