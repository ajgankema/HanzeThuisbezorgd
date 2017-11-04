<?php

$loginErrorMsg = null;
$registerErrorMsg = null;
$popupOpened = 0;
if(!empty($_GET['login'])){

    //Check the login variable
    switch($_GET['login']){
        case "wrongcredentials":
            $loginErrorMsg="Je login is incorrect. Controleer je gebruikersnaam (email) en/of wachtwoord en probeer het opnieuw.";
            $loginErrorMsg = "<p class='errormsg'>".$loginErrorMsg."</p>";
            $popupOpened = 1;
            break;
        case "open":
            $popupOpened = 1;
            break;
        default:
            break;
    }

}

if(!empty($_GET['register'])){

    //Check the register variable
    switch($_GET['register']){
        case "incorrectinput":
            $popupOpened = 2;
            foreach($_SESSION['register_errors'] as $key=>$error){
                if($key==5)$registerErrorMsg.="Voornaam te kort.";
                if($key==6)$registerErrorMsg.="Achternaam te kort.";
                if($key==7)$registerErrorMsg.="Email is incorrect.";
                if($key==8)$registerErrorMsg.="Wachtwoord te kort";
                $registerErrorMsg.="<br/>";
            }
            unset($_SESSION['register_errors']);
            break;
        case "emailexists":
            $registerErrorMsg = "Er is al een account geregistreerd met dit e-mail adres.";
            $popupOpened = 2;
            break;
        case "passwordsdontmatch":
            $registerErrorMsg = "Wachtwoorden komen niet overeen.";
            $popupOpened = 2;
            break;
        case "open":
            $popupOpened = 2;
            break;
    }

    if(!empty($registerErrorMsg))$registerErrorMsg = "<p class='errormsg'>".$registerErrorMsg."</p>";

}

?>
<script>
    $(function(){
        if(<?=$popupOpened;?>==1)openLogin();
        if(<?=$popupOpened;?>==2)openRegister();
    });
</script>
<div id="login_popup">
    <div class="overlay" id="popup_overlay">
        <div class="popup">
            <div class="title">
                <h2>Login</h2>
            </div>
            <?=$loginErrorMsg;?>
            <div class="content">
                <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post">
                    <table class="fancy_labels">
                        <tr>
                            <td>
                                <label for="email_IN">E-Mail adres:</label>
                                <input type="email" id="email_IN" name="email" placeholder="example@example.com">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="pass_IN">Wachtwoord:</label>
                                <input type="password" name="password" id="pass_IN" placeholder="***">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" value="login" name="type">
                                <input type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>" name="return_url">
                                <input type="submit" value="Inloggen" name="submit">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a id="wachtwoord_vergeten" title="Wachtwoord vergeten?" href="javascript:void(0)">Wachtwoord vergeten</a>
                            </td>
                        </tr>
                    </table>
                </form>
                <hr>
                <p>Nog geen account? <a onclick="fromLoginToRegister()" href="javascript:void(0)">Registreer</a> vandaag nog om bestellen makkelijker te maken en bestellingen te bijhouden!</p>
            </div>
        </div>
    </div>
</div>



<div id="register_popup">
    <div class="overlay" id="popup_overlay">
        <div class="popup">
            <div class="title">
                <h2>Registreer</h2>
            </div>
            <?=$registerErrorMsg;?>
            <div class="content">
                <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post">
                    <table class="fancy_labels">
                        <tr>
                            <td>
                                <label for="firstname_IN">Voornaam:</label>
                                <input id="firstname_IN" name="firstname" placeholder="John" type="text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="lastname_IN">Achternaam:</label>
                                <input id="lastname_IN" name="lastname" placeholder="Doe" type="text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="email_IN">E-Mail adres:</label>
                                <input id="email_IN" name="email" placeholder="example@example.com" type="email">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="pass_first_IN">Wachtwoord:</label>
                                <input id="pass_first_IN" name="password" type="password">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="pass_second_IN">Wachtwoord herhalen:</label>
                                <input id="pass_second_IN" name="password_repeat" type="password">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" value="register" name="type">
                                <input type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>" name="return_url">
                                <input type="submit" value="Registreren" name="submit">
                            </td>
                        </tr>
                    </table>
                </form>
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
            </div>
        </div>
    </div>
</div>