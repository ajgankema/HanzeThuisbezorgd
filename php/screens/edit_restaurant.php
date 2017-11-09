<body xmlns="http://www.w3.org/1999/html">
<?php
    include("header.php");

    if($_POST['edit_restaurant'])
    {
        $restaurant->setName($_POST['name']);
        $restaurant->setPostalcode($_POST['postalcode']);
        $restaurant->setDescription($_POST['description']);
        $restaurant->setStreetaddress($_POST['address']);
        $restaurant->setRestaurantType($_POST['type']);
        $restaurant->setCity($_POST['city']);

        if($restaurant->saveRestaurant())
        {
            //gelukt
            echo"<script>alert('Gelukt');</script>";
        }
        else
        {
            //niet gelukt
            echo"<script>alert('Er is iets misgegaan. Neem contact op met de service provider.');</script>";
        }
    }
?>



<div id="container" class="inset_from_header">
    <div class="arena">
        <h1 class="arena_title">Hallo, <?=$user->getFirstname();?> <?=$user->getLastname();?>!</h1>
        <div class="block-grid">
            <div class="block">
                <h3>Wijzig restaurant informatie</h3>
                <form method='post' action="">
                    <table id="edit_restaurant_table">
                        <tr>
                            <td>
                                <p><span class="text-label">Naam:</span> <span><input type="text" name="name" value="<?=$restaurant->getName();?>"></span></p>
                            </td>
                            <td>
                                <p><span class="text-label">Postcode:</span> <span><input type="text" name="postalcode" value="<?=$restaurant->getPostalcode();?>"></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><span class="text-label">Omschrijving:</span> <span><textarea style="resize:none;" rows="7"  name="description"><?=$restaurant->getDescription();?></textarea></span></p>
                            </td>
                            <td>
                                <p><span class="text-label">Adres:</span> <span><input type="text" name="address" value="<?=$restaurant->getStreetaddress();?>"></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><span class="text-label">Type:</span> <span><input type="text" name="type" value="<?=$restaurant->getRestaurantType();?>"></span></p>
                            </td>
                            <td>
                                <p><span class="text-label">Stad:</span> <span><input type="text" name="city" value="<?=$restaurant->getCity();?>"></span></p>  <!--Pochinki is my city -->
                            </td>
                        </tr>
                    </table>
                    <table style="margin:auto;" class="fancy_labels">
                        <tr>
                            <td>
                                <br/>
                                <input type="submit" name="edit_restaurant" value="Wijzigen">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="block">
                <h3>Bestellingen</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Naam</td>
                            <td>Email</td>
                            <td>Straat en huisnummer</td>
                            <td>Postcode</td>
                            <td>Plaatsnaam</td>
                            <td>Bestelling</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($restaurant->getOrders() as $o):?>

                        <tr>
                            <td><?=$o['firstname'];?> <?=$o['lastname'];?></td>
                            <td><?=$o['email'];?></td>
                            <td><?=$o['streetname'];?>, <?=$o['housenumber'];?></td>
                            <td><?=$o['postalcode'];?></td>
                            <td><?=$o['city'];?></td>
                            <td>
                                <ol>
                                    <?php
                                    $price=0;
                                    foreach($restaurant->getOrderDetails($o['order_id']) as $oc):
                                    $price+=$oc['price'];
                                        ?>
                                        <li><?=$oc['name'];?> - x<?=$oc['aantal'];?></li>
                                    <?php endforeach; ?>
                                </ol>
                                <span class="price">Totaal: &euro;<?=$price;?></span>
                            </td>
                        </tr>

                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="block">
                <h3>Producten beheren</h3>
                <button class="fancy" onclick="location.href='producten/nieuw_product.php';">Nieuw product</button>
                <button class="fancy" onclick="location.href='producten/product_aanpassen.php';">Producten weergeven</button>
                <button class="fancy" onclick="location.href='producten/nieuw_categorie.php';">Nieuwe categorie</button>
            </div>
        </div>
    </div>
</div>

</body>