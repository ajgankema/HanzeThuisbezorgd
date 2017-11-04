<div id="login_popup">
    <div class="overlay" id="popup_overlay">
        <div class="popup">
            <div class="title">
                <h2>Login</h2>
            </div>
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
                <p>Nog geen account? <a href="javascript:void(0)">Registreer</a> vandaag nog om bestellen makkelijker te maken en bestellingen te bijhouden!</p>
            </div>
        </div>
    </div>
</div>
