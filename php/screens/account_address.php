<?php

$popupOpened = 0;
$addressErrorMsg = null;

if(!empty($_GET['addAddress'])){

    switch($_GET['addAddress']){
        case "incorrectinput":
            $popupOpened=1;
            foreach($_SESSION['addAddress_errors'] as $key=>$error){
                if($key==2)$addressErrorMsg.="Straatnaam is te kort.";
                if($key==3)$addressErrorMsg.="Er moet een huisnummer zijn ingevoerd.";
                if($key==4)$addressErrorMsg.="Postcode klopt niet.";
                if($key==5)$addressErrorMsg.="Plaatsnaam is te kort";
                $addressErrorMsg.="<br/>";
            }
            break;
        default:
            break;
    }

}
if(!empty($_GET['editAddress'])){

    switch($_GET['editAddress']){
        case "unknownerror":
            $popupOpened=2;
            $addressErrorMsg = "Er is iets mis gegaan!";
            break;
        case "incorrectinput":
            $popupOpened=2;
            foreach($_SESSION['addAddress_errors'] as $key=>$error){
                if($key==2)$addressErrorMsg.="Straatnaam is te kort.";
                if($key==3)$addressErrorMsg.="Er moet een huisnummer zijn ingevoerd.";
                if($key==4)$addressErrorMsg.="Postcode klopt niet.";
                if($key==5)$addressErrorMsg.="Plaatsnaam is te kort";
                $addressErrorMsg.="<br/>";
            }
            break;
        default:
            break;
    }

}
if(!empty($_GET['removeAddress'])){

    switch($_GET['removeAddress']){
        case "unknownerror":
            $popupOpened=2;
            $addressErrorMsg="Er is iets mis gegaan!";
            break;
        default:
            break;
    }

}

if(!empty($addressErrorMsg))$addressErrorMsg= "<p class='errormsg'>".$addressErrorMsg."</p>";


?>
<script>
    $(function(){
        if(<?=$popupOpened;?>==1)openAddAddress();
        if(<?=$popupOpened;?>==2)openEditAddress();
    });
</script>
<div id="address_popup">
    <div class="overlay" id="popup_overlay">
        <div class="popup">
            <div class="title">
                <h2 class="addAddress">Nieuw adres toevoegen</h2>
                <h2 class="editAddress">Adres aanpassen</h2>
            </div>
            <?=$addressErrorMsg;?>
            <div class="content">
                <form action="<?= $config['Base_URL']; ?>/php/form_handler.php" method="post" id="address_form">
                    <table class="fancy_labels">
                        <tr>
                            <td>
                                <label for="street_IN">Straatnaam</label>
                                <input id="street_IN" type="text" name="streetname">
                            </td>
                            <td>
                                <label for="housenumber_IN">Huisnummer</label>
                                <input id="housenumber_IN" type="text" name="housenumber">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="postalcode_IN">Postcode</label>
                                <input id="postalcode_IN" type="text" name="postalcode" maxlength="6">
                            </td>
                            <td>
                                <label for="city_IN">Plaatsnaam</label>
                                <input id="city_IN" type="text" name="city">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="standard_IN" name="standard_address" type="checkbox">
                                <label for="standard_IN" class="for_checkbox">Maak standard adres</label>
                            </td>
                            <td>
                                <input type="hidden" value="" name="address_id" id="address_id_IN">
                                <input type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>" name="return_url">
                                <input type="hidden" name="type" value="addAddress" id="inputType">
                            </td>
                        </tr>
                    </table>
                    <table id="addAddressSubmit" class="fancy_labels">
                        <tr>
                            <td>
                                <br/>
                                <input type="submit" name="submit" value="Opslaan">
                            </td>
                        </tr>
                    </table>
                    <table id="editAddressSubmit" class="fancy_labels">
                        <tr>
                            <td>
                                <br/>
                                <input type="submit" name="submit" value="Opslaan">
                            </td>
                            <td>
                                <br/>
                                <input type="hidden" name="deletecheck" value="false" id="inputDeleteCheck">
                                <button type="button" class="delete" onclick="deleteAddress(true)">Verwijderen</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>