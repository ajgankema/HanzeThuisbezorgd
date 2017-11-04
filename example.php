<?php

//Start the session
session_start();

//Include PHP files
include("php/config.php");
include("php/db.php");
include("php/User.class.php");

$user = new User();

//Setup the database connection
$db = (new Db())->getConnection();

//Check for $_GET requests
include("php/form_handler.php");

//Include screen files
include("php/screens/head.php");
include("php/screens/login.php");

if(!$user->isLoggedIn()) {
    ?>
    <a href="javascript:void(0)" onclick="openLogin()" title="Inloggen">Inloggen</a>

<?php
} else {
    echo "Gebruiker gegevens: "; var_dump($_SESSION);
    ?>
    <a href="?logout=true">Uitloggen</a>
    <?php
}