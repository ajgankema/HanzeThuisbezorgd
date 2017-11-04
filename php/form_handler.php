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
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //What kind of form are we dealing with?
    switch($_POST['type']){
        case "register":
            register();
            break;
        case "login":
            login();
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
    $returns = $user->tryLogin($email, $password);

    if($returns==1){
        //Gebruiker is ingelogd
        header("Location: $return_URL");
        exit();
    } elseif($returns==2) {
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
    $returns = $user->register($firstname, $lastname, $email, $password, $password_repeat);

    //What has been returned from the function?
    if($returns==1){
        //User has been registered and logged in
    } elseif($returns==2) {
        //Wachtwoorden komen niet overeen
        $return_URL.="?register=passwordsdontmatch";
    } elseif($returns==3) {
        //Email bestaat al
        $return_URL.="?register=emailexists";
    } elseif($returns==4) {
        //Er ging iets fout
        $return_URL.="?register=unknownerror";
    }

    //Send back to the page
    header("Location: $return_URL");
    exit();
}