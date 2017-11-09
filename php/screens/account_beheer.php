<body>
    <?php include("header.php"); ?>

    <div id="container" class="inset_from_header">
        <div id="account" class="arena">
            <h1 class="arena_title">Hallo, <?=$user->getFirstname();?> <?=$user->getLastname();?>!</h1>
            <div class="block-grid">
                <div class="block">
                    <h3>Gebruiker informatie</h3>
                    <table>
                        <tr>
                            <td>
                                <p>Voornaam: <span><?=$user->getFirstname();?></span></p>
                            </td>
                            <td>
                                <p>E-Mail adres: <span><?=$user->getEmail();?></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Achternaam: <span><?=$user->getLastname();?></span></p>
                            </td>
                            <td>
                                <p>Wachtwoord: <a href="#wachtwoord">wijzigen</a></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="block">
                    <h3>Adressen</h3>
                    <div class="adres_table">
                        <?php
                        foreach($user->getAddresses() as $ad){
                            ?>
                            <div class="adres">
                                <p class="street"><span class="bold"><?=$ad['streetname'];?> <?=$ad['housenumber'];?></span> - <?=$ad['city'];?></p>
                                <p class="postalcode"><?=$ad['postalcode'];?></p>
                                <a href="javascript:void(0)" onclick="openEditAddress('<?=$ad['streetname'];?>','<?=$ad['housenumber'];?>','<?=$ad['postalcode'];?>','<?=$ad['city'];?>','<?=$ad['address_id'];?>')" title="Adres wijzigen">wijzig</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <button onclick="openAddAddress()" class="fancy">Adres toevoegen</button>
                </div>
                <div class="block">
                    <h3>Reviews van <?=$user->getFirstname();?></h3>
                    <div class="review_table">
                        <?php
                        foreach($user->getAllUserReviews() as $ad){
                            ?>
                            <div class="Reviews">
                                <p class="title"><span class="bold">Titel: <?=$ad['title'];?><br>Review: <?=$ad['description'];?></span><br>Rating: <?=$ad['rating'];?><br> Bij <?=$ad['name'];?></p>
                                <button onclick="openEditReview('<?=$ad['title'];?>','<?=$ad['description'];?>','<?=$ad['rating'];?>','<?=$ad['review_id'];?>')" title="Review wijzigen" class="fancy"/>Wijzigen</a>
                                <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post" id="review_form">
                                    <input type="hidden" name="deletecheck" value="false" id="inputDeleteCheck">
                                    <button type="button" class="fancy" onclick="deleteReview(true)">Review Verwijderen</button>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="block" id="wachtwoord">
                    <h3>Wachtwoord wijzigen</h3>
                    <form method="post" action="<?= $config['Base_URL']; ?>/php/form_handler.php">
                        <table class="fancy_labels small">
                            <tr>
                                <td>
                                    <label>Oud wachtwoord:</label>
                                    <input type="password" name="password">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Nieuw wachtwoord:</label>
                                    <input type="password" name="new_password">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Nieuw wachtwoord opnieuw:</label>
                                    <input type="password" name="new_password_again">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="type" value="newPass">
                                    <input type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>" name="return_url">
                                    <input type="submit" name="submit" value="Opslaan">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>