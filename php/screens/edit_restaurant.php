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
    <div id="account">
        <h1>Hallo, <?=$user->getFirstname();?> <?=$user->getLastname();?>!</h1>
        <div class="block-grid">
            <div class="block">
                <h3>Wijzig restaurant informatie</h3>
                <form method='post' action="">
                    <table>
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
                                <p><span class="text-label">Omschrijving:</span> <span><textarea style="resize:none;" rows="7" cols="50"  name="description"><?=$restaurant->getDescription();?></textarea></span></p>
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
        </div>
    </div>
</div>

</body>