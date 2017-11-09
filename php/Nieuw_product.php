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
$sql = "SELECT * FROM categories";
$results = mysqli_query($conn, $sql);
// formulier
?>
<form method="POST" action="Nieuw_product.php">
	<fieldset>
		<legend>Product maken</legend>
		categorie<select name="categorie"> 
		<?php  
			while($row = $results->fetch_assoc()){
				echo "<option value='".$row['category_id']."'>".$row['name']."</option>";
			}
		?>
		</select>
		product naam <input type="text" name="productnaam" required>
		beschrijving <input type="textarea" name="beschrijving">
		prijs <input type="number" name="prijs" required min="0" max="999999999">
		maximum aantal producten <input type="number" name="maximumproducten" required min="0" max="999999999">		
		<input type="submit" value="submit">
	</fieldset>
</form>
<?php
//in database zetten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$product_id = 'null';
$restaurant_id = '1';
$category_id = mysqli_real_escape_string($conn, $_POST['categorie']);
$name = mysqli_real_escape_string($conn, $_POST['productnaam']);
$description = mysqli_real_escape_string($conn, $_POST['beschrijving']);
$price = mysqli_real_escape_string($conn, $_POST['prijs']);
$max_amount = mysqli_real_escape_string($conn, $_POST['maximumproducten']);

$sql = "INSERT INTO products (restaurant_id, category_id, name, description, price, max_amount)
VALUES ('$restaurant_id', '$category_id', '$name','$description', '$price', '$max_amount')";

if (mysqli_query($conn, $sql)) {
    echo "Het nieuwe product is succesvol aangemaakt.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
?>
