<?php
//database connectie
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "mydb";

// Verbinden
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check Connectie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
	echo("connection established");
}
// Data ophalen
$sql = "SELECT product_id, category_id, name, description, price, max_amount FROM products";
$uitdatabase = mysqli_query($conn, $sql);
// Data in tabel zetten
session_start();


if(!empty($_POST['type'])) {
    $type = $_POST['type'];
    if($type=="Delete"){
        $product_id = $_POST["product_id"];
        $sql = "DELETE FROM products WHERE product_id= '$product_id'";
        echo "$product_id </br>";
        if (mysqli_query($conn, $sql)) {
            echo "Deleted";
            header("Refresh:0");
            exit();
        } else {
            echo "Error deleting product: " . mysqli_error($conn);
        }
    }
    if($type=="Change"){
        $product_id = $_POST['product_id'];
        $_SESSION["product_id_aanpassen"] = $product_id;
        header("Location: aanpassen.php");
        exit();
    }
}



?>

<table>
<tr>
<th>Prodect ID</th>
<th>Categorie ID</th>
<th>Naam</th>
<th>Beschrijving</th>
<th>Prijs</th>
<th>Maximum aantel per order</th>
<th>Veranderen van product</th>
<th>Product verwijderen</th>
</tr>
<?php

if (mysqli_num_rows($uitdatabase) > 0) {
	while($row = mysqli_fetch_assoc($uitdatabase)) {
		echo "<tr><td>".$row["product_id"]."</td><td>".$row["category_id"]."</td><td>".$row["name"]."</td><td>".$row["description"]."</td><td>".$row["price"]."</td><td>".$row["max_amount"].'</td>
		<td>
		<form action="Product_aanpassen.php" method="post">
  <input type="submit" value="Change" name="type">
  <input type="hidden" name="product_id" value="'.$row["product_id"].'">
</form></td>
<td><form action="Product_aanpassen.php" method="post">
  <input type="submit" value="Delete" name="type">
  <input type="hidden" name="product_id" value="'.$row["product_id"].'">
</form></td>';
	
	}
}
echo '</table>';

?>