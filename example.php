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
include("php/screens/login.php");

if($user->isLoggedIn()){
    echo '<a href="?logout=true">Uitloggen</a>';
    var_dump($_SESSION);
} else {
    echo '<a href="javascript:void(0)" onclick="openLogin()">Inloggen</a>';
}

?>
<header>
    <h1><?=$restaurant->getName()?></h1>
    <p><?=$restaurant->getDescription();?></p>
</header>