<?php

//Start the session
session_start();
//print_r($_POST); //Post debugger
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
if(!$user->isLoggedIn()){
    header("Location: ".$config['Base_URL']."/winkelwagen?login=open");
    exit();
}

/**
 * HERE STARTS THE ACTUAL PAGE
 */

include("../../php/screens/header.php");

?>
<div id="container" class="inset_from_header">
    <div class="arena">
        <h1 class="arena_title">Bestelling geplaatst!</h1>
        <br/>
        <p>Bedankt voor uw bestelling! Deze zal zo spoedig mogelijk worden bezorgd naar uw bestemming.</p>
        <p>..Als het systeem daadwerkelijk een bestelling naar een daarwerkelijk restaurant stuurde.</p>
        <p>Wij waarderen het als u een review achterlaat op onze website</p>
        <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post" id="review_form">
                    <table class="fancy_labels">
                        <tr>
                            <td>
                                <label for="title_IN">Titel</label>
                                <input id="title_IN" type="text" name="title">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="description_IN">Review</label>
                                <textarea id="description_IN" class="description_IN" name="description_IN"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="rating_IN">rating</label>
                                <input id="rating_IN" type="text" name="rating" maxlength="10">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>" name="return_url">
                                <input type="hidden" name="type" value="verstuurReview" id="inputType">
                            </td>
                        </tr>
                    </table>
                    <table id="ReviewSubmit" class="fancy_labels">
                        <tr>
                            <td>
                                <br/>
                                <input type="submit" name="submit" value="Verstuur review">
                            </td>
                        </tr>
                    </table>
                </form>
    </div>
</div>