<div id="account">
    <h1>Hallo, <?=$user->getFirstname()?>!</h1>
    <div class="block">
        <h3>Gebruiker informatie</h3>
        <p>
            Voornaam: <span><?=$user->getFirstname();?></span><br/>
            Achternaam: <span><?=$user->getLastname();?></span><br/>
            E-Mail adres: <span><?=$user->getEmail();?></span><br/>
            Wachtwoord: <a href="javascript:void(0)">wijzigen</a>
        </p>
    </div>
    <div class="block">
        <div class="adres_table">
            <div class="title">
                <h3>Adressen</h3>
            </div>
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
            <div class="adres">
                <button onclick="openAddAddress()" class="fancy">Adres toevoegen</button>
            </div>
        </div>
    </div>
</div>