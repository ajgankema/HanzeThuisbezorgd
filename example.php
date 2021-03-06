<?php

//Start the session
session_start();

//Breadcrumbs
if(empty($_SESSION['previous_page'])){
    $_SESSION['previous_page']=$_SERVER['REQUEST_URI'];
} else {
    $_SESSION['previous_page']=$_SESSION['current_page'];
}
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

//Include PHP files
include("php/config.php");
include("php/db.php");
include("php/User.class.php");
include("php/Restaurant.class.php");

//Setup the database connection
$db = (new Db())->getConnection();

$user = new User();
$restaurant = new Restaurant();

//Check for $_GET requests
include("php/form_handler.php");

//Include screen files
include("php/screens/head.php");
if(!$user->isLoggedIn())include("php/screens/login.php");
if($user->isRestaurantManager())include("php/screens/restaurant_beheer.php");

if($user->isLoggedIn()){
    echo '<a href="?logout=true">Uitloggen</a>';
    echo '<a href="/Thuisbezorgd/Account">Account beheer</a>';
} else {
    echo '<a href="javascript:void(0)" onclick="openLogin()">Inloggen</a>';
}