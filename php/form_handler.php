<?php
/**
 * Created by PhpStorm.
 * User: Arnold
 * Date: 3-11-2017
 * Time: 14:59
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(isset($_GET['logout'])){
        if($_GET['logout']=="true"){
            include_once("User.class.php");
            $user = new User();
            $user->logout();

            header("Location: ".$_SESSION['previous_page']);
            exit();
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //print_r($_POST); //Post debugger
    //What kind of form are we dealing with?
    switch($_POST['type']){
        case "register":
            register();
            break;
        case "login":
            login();
            break;
        case "addAddress":
            addAddress();
            break;
        case "editAddress":
            editAddress();
            break;
        case "editReview":
            editReview();
            break;
        case "newPass":
            newPass();
            break;
        default:
            return false;
    }

}

function login(){
    include_once("User.class.php");

    $email = $_POST['email'];
    $password = $_POST['password'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    $user = new User();
    $response = $user->tryLogin($email, $password);

    if($response==1){
        //Gebruiker is ingelogd
        header("Location: $return_URL");
        exit();
    } elseif($response==2) {
        //Verkeerd e-mail adres of wachtwoord
        $return_URL.="?login=wrongcredentials";
        header("Location: $return_URL");
        exit();
    }
}

function register(){
    include_once("User.class.php");

    //Set variables
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    //Get the user object and use the register function
    $user = new User();
    $response = $user->register($firstname, $lastname, $email, $password, $password_repeat);

    //What has been returned from the function?
    if($response==1){
        //User has been registered and logged in
        unset($_SESSION['register_errors']);
    } elseif($response==2) {
        //Wachtwoorden komen niet overeen
        $return_URL.="?register=passwordsdontmatch";
    } elseif($response==3) {
        //Email bestaat al
        $return_URL.="?register=emailexists";
    } elseif($response==4) {
        //Er ging iets fout
        $return_URL.="?register=unknownerror";
    } elseif(is_array($response)) {
        if(empty($_SESSION))session_start();
        $return_URL.="?register=incorrectinput";
        $_SESSION['register_errors']=$response;
    }

    //Send back to the page
    header("Location: $return_URL");
    exit();
}

function newPass(){

    include_once("User.class.php");

    $pass = $_POST['password'];
    $new_pass = $_POST['new_password'];
    $new_pass_again = $_POST['new_password_again'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    $user = new User();
    $response = $user->newPassword($pass,$new_pass,$new_pass_again);

    if($response==1){
        //Gebruiker is ingelogd
    } elseif($response==2) {
        //Verkeerd e-mail adres of wachtwoord
        $return_URL.="?login=wrongcredentials";

    }

    header("Location: $return_URL");
    exit();

}

function addAddress(){
    include_once("User.class.php");

    //Standard can be empty if its not checked
    if(empty($_POST['standard_address'])){
        $standard = null;
    } else {
        $standard = $_POST['standard_address'];
    }

    //Setup all the variables
    $streetname = $_POST['streetname'];
    $housenumber = $_POST['housenumber'];
    $postalcode = $_POST['postalcode'];
    $city = $_POST['city'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    $user = new User();
    $response = $user->addAddress($streetname,$housenumber,$postalcode,$city,$standard);

    if($response==1){
        //Data is opgeslagen
        unset($_SESSION['addAddress_errors']);
    } elseif(is_array($response)){
        if(empty($_SESSION))session_start();
        $return_URL.="?addAddress=incorrectinput";
        $_SESSION['addAddress_errors']=$response;
    }

    //Send back to the page
    header("Location: $return_URL");
    exit();

}

function editAddress(){
    include_once("User.class.php");

    //Standard can be empty if its not checked
    if(empty($_POST['standard_address'])){
        $standard = null;
    } else {
        $standard = $_POST['standard_address'];
    }

    //Setup all the variables
    $streetname = $_POST['streetname'];
    $housenumber = $_POST['housenumber'];
    $postalcode = $_POST['postalcode'];
    $city = $_POST['city'];
    $address_id = $_POST['address_id'];
    $deletecheck = $_POST['deletecheck'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    $user = new User();
    if($deletecheck=="true"){

        $response = $user->removeAddress($address_id);

        if($response==1){
            //Data is verwijderd
        } else {
            $return_URL.="?removeAddress=unknownerror";
        }

    } else {

        $response = $user->editAddress($streetname,$housenumber,$postalcode,$city,$standard,$address_id);

        if($response==1){
            //Data is opgeslagen
        } elseif(is_array($response)){
            if(empty($_SESSION))session_start();
            $return_URL.="?editAddress=incorrectinput";
            $_SESSION['addAddress_errors']=$response;
        } else {
            $return_URL.="?editAddress=unknownerror";
        }

    }

    //Send back to the page
    header("Location: $return_URL");
    exit();

}

function editReview(){
    include_once("User.class.php");
    include("../php/config.php");
    //Setup all the variables
    $title = $_POST['title'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $inputDeleteCheck = $_POST['deletecheck'];
    $review_ID = $_POST['review_id'];
    $return_URL = explode("?",$_POST['return_url'])[0];

    $user = new User();

    if($inputDeleteCheck=="true"){
        $user->removeReview($review_ID);
    } elseif($inputDeleteCheck=="false") {
        $user->updateReview($title,$description,$rating,$review_ID);
    }
}