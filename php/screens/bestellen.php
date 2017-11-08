<?php

include("header.php");

$address = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['type']=="chooseAddress"){
        $address_id = $db->real_escape_string($_POST['preset_address']);
        $user_id = $user->getUserId();
        $sql = "SELECT * FROM addresses WHERE address_id='$address_id' AND user_id = '$user_id'";
        $results = $db->query($sql);
        $address = $results->fetch_assoc();
    }
}

$user_id = $user->getUserId();
$sql = "SELECT *
        FROM addresses
        WHERE user_id = '$user_id'";
$results = $db->query($sql);

?>

<div id="container" class="inset_from_header">
    <div class="arena">

        <h1 class="arena_title">Bestellen</h1>

        <div class="block-grid">
            <div class="block">
                <h3>Vul uw adres in</h3>
                <form action="<?=$config['Base_URL'];?>/php/form_handler.php" method="post">
                    <table class="fancy_labels">
                        <tr>
                            <td>
                                <label>Straatnaam</label>
                                <input type="text" name="streetname" value="<?=$address['streetname'];?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Huisnummer</label>
                                <input type="text" name="housenumber" value="<?=$address['housenumber'];?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Postcode</label>
                                <input type="text" name="postalcode" value="<?=$address['postalcode'];?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Plaatsnaam</label>
                                <input type="text" name="city" value="<?=$address['city'];?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Betalings methode:</label><br/>
                                <input type="radio" name="payment" value="online">Online<br/>
                                <input type="radio" name="payment" value="cash">Contant<br/><br/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" value="<?=$config['Base_URL'];?>/bestellen/gelukt" name="return_url">
                                <input type="hidden" name="restaurant_id" value="<?=$restaurant->getRestaurantId();?>">
                                <input type="hidden" name="type" value="placeOrder">
                                <input type="submit" name="submit" value="Bestel">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>


            <div class="block">
                <h3>Of kies een adres</h3>
                <form action="" method="post">
                    <select name="preset_address">
                        <?php while($row = $results->fetch_assoc()){?>
                            <option value="<?=$row['address_id'];?>"><?=$row['streetname'].", ".$row['housenumber'];?></option>
                        <?php }?>
                    </select>
                    <input type="hidden" name="type" value="chooseAddress">
                    <input type="submit" name="submit" value="Kies">
                </form>
            </div>
        </div>


    </div>
</div>

