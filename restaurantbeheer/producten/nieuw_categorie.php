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
include("../../php/config.php");
include("../../php/db.php");
include("../../php/User.class.php");
include("../../php/Restaurant.class.php");

//Setup the database connection
$db = (new Db())->getConnection();

$user = new User();
$restaurant = new Restaurant();

//Check for $_GET requests
include("../../php/form_handler.php");

//Include screen files
include("../../php/screens/head.php");

//Is the user logged in and is he a manager?
if(!$user->isLoggedIn() || !$user->isRestaurantManager()){
    header("Location: ".$config['Base_URL']);
    exit();
}

include("../../php/screens/header.php");?>

<div id="container" class="inset_from_header">

    <?php include("../../php/nieuw_categorie.php");?>

</div>