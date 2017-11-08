<?php

if(!empty($_GET["knop"])) {
    switch($_GET["knop"]) {
        // voeg het gerecht toe aan het winkelwagentje en als het gerecht al bestaat tel ze dan bijelkaar op
        case "toevoegen":
            $max_amount = 1;
            if(!empty($_POST["max_amount"]))$max_amount = $_POST['max_amount'];
                $product_id = $db->real_escape_string($_GET['product_id']);
                // haal nu het geselecteerde gerecht uit de database (product_id) en voeg het toe aan het winkelwagentje
                $result = $db->query("SELECT * FROM products WHERE product_id='" . $product_id . "'");
                $Gerecht_ID=array();
                while($row = $result->fetch_assoc()){
                    array_push($Gerecht_ID,$row);
                }
                // Vul een Array met de inhoud van de SELECT

                $Gerecht_Array[$Gerecht_ID[0]["product_id"]] = array (
                    'name'=>$Gerecht_ID[0]["name"],
                    'product_id'=>$Gerecht_ID[0]["product_id"],
                    'max_amount'=>$max_amount,
                    'price'=>$Gerecht_ID[0]["price"]
                );


                if(!empty($_SESSION["Winkelwagen"])) {
                    if(in_array($Gerecht_ID[0]["product_id"],array_keys($_SESSION["Winkelwagen"]))) {
                        foreach($_SESSION["Winkelwagen"] as $k => $v) {
                            if($Gerecht_ID[0]["product_id"] == $k) {
                                // Controleer of er misschien een 0 ingevuld is bij aantal
                                // Als er een 0 is ingevuld voeg dan niks toe
                                if(empty($_SESSION["Winkelwagen"][$k]["max_amount"])) {
                                    $_SESSION["Winkelwagen"][$k]["max_amount"] = 0;
                                }
                                // als het gerecht al in de winkelwagen staat tel ze dan bijelkaar op
                                $_SESSION["Winkelwagen"][$k]["max_amount"] += $max_amount;
                            }
                        }
                    }
                    else {
                        $_SESSION["Winkelwagen"] = array_merge($_SESSION["Winkelwagen"],$Gerecht_Array);
                    }
                }
                else {
                    $_SESSION["Winkelwagen"] = $Gerecht_Array;
                }
//            }
            break;

        // verwijder van een gerecht uit het winkelwagentje
        case "verwijderen":
            if(!empty($_SESSION["Winkelwagen"])) {
                foreach($_SESSION["Winkelwagen"] as $k => $v) {
                    //Verwijdert het geselecteerde gerecht (product_id)
                    if($_GET["product_id"] == $k)
                        unset($_SESSION["Winkelwagen"][$k]);
                    if(empty($_SESSION["Winkelwagen"]))
                        unset($_SESSION["Winkelwagen"]);
                }
            }
            break;

        // wis alle gerechten uit het winkelwagentje

        case "wisalles":
            unset($_SESSION["Winkelwagen"]);
            break;

    }
}