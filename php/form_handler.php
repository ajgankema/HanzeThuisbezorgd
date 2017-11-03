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

    $user = new User();
    if($user->register($_POST)){
        echo "Geregistreerd en ingelogd";
    }
}