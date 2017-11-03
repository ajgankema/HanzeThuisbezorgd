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

if(!$user->isLoggedIn()) {
    ?>
    <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post">
        <table>
            <tr>
                <td>
                    <label for="firstname_IN">Voornaam:</label>
                </td>
                <td>
                    <input id="firstname_IN" name="firstname" placeholder="John" type="text">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="lastname_IN">Achternaam:</label>
                </td>
                <td>
                    <input id="lastname_IN" name="lastname" placeholder="Doe" type="text">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="email_IN">E-Mail adres:</label>
                </td>
                <td>
                    <input id="email_IN" name="email" placeholder="example@example.com" type="email">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="pass_first_IN">Wachtwoord:</label>
                </td>
                <td>
                    <input id="pass_first_IN" name="password" type="password">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="pass_second_IN">Wachtwoord herhalen:</label>
                </td>
                <td>
                    <input id="pass_second_IN" name="password_repeat" type="password">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" value="register" name="type">
                </td>
                <td>
                    <input type="submit" value="Registreren" name="submit">
                </td>
            </tr>
        </table>
    </form>

    <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post">
        <table>
            <tr>
                <td>
                    <label for="email_IN">E-Mail adres:</label>
                </td>
                <td>
                    <input type="email" id="email_IN" name="email" placeholder="example@example.com">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="pass_IN">Wachtwoord:</label>
                </td>
                <td>
                    <input type="password" name="password" id="pass_IN">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" value="login" name="type">
                </td>
                <td>
                    <input type="submit" value="Inloggen" name="submit">
                </td>
            </tr>
        </table>
    </form>
<?php
} else {
    echo "Gebruiker gegevens: "; var_dump($_SESSION);
    ?>
    <a href="?logout=true">Uitloggen</a>
    <?php
}