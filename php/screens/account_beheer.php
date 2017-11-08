<body>
    <?php include("header.php"); ?>

    <div id="container" class="inset_from_header">
        <div id="account">
            <h1>Hallo, <?=$user->getFirstname();?> <?=$user->getLastname();?>!</h1>
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
                                <p>Wachtwoord: <a href="javascript:void(0)">wijzigen</a></p>
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
                                <p class="title"><span class="bold"><?=$ad['title'];?> <?=$ad['description'];?></span> Rating <?=$ad['rating'];?> Bij <?=$ad['name'];?></p>
                                <button onclick="openEditReview('<?=$ad['title'];?>','<?=$ad['description'];?>','<?=$ad['rating'];?>','<?=$ad['review_id'];?>')" title="Review wijzigen" class="fancy">wijzig</a>
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
            </div>
        </div>
    </div>

</body>