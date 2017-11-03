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

    $user = new User();
    if($user->tryLogin($email, $password)){
        echo "Ingelogd";
    }
}

function register(){
    include_once("User.class.php");

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    $user = new User();
    if($user->register($firstname, $lastname, $email, $password, $password_repeat)){
        echo "Geregistreerd en ingelogd";
    }
}