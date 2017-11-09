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
//	echo"connection established";
}
session_start();
$product_id = $_SESSION["product_id_aanpassen"];
//echo "$product_id";
$sql = "SELECT * FROM categories";
$categorien = mysqli_query($conn, $sql);
$sql = "SELECT category_id FROM products WHERE product_id= '$product_id'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$categorie_old = $array2[0];
//echo "$categorie_old";
$sql = "SELECT name FROM categories WHERE category_id= '$categorie_old'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$categorie_old = $array2[0];
//echo "$categorie_old";
$sql = "SELECT name FROM products WHERE product_id= '$product_id'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$name_old = $array2[0];
$sql = "SELECT description FROM products WHERE product_id= '$product_id'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$description_old = $array2[0];
$sql = "SELECT price FROM products WHERE product_id= '$product_id'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$price_old = $array2[0];
$sql = "SELECT max_amount FROM products WHERE product_id= '$product_id'";
$array1 = mysqli_query($conn, $sql);
$array2 = mysqli_fetch_row($array1);
$max_amount_old = $array2[0];



// formulier
?>
<form method="POST" action="aanpassen.php">
	<fieldset>
		<legend>Product bewerken</legend>
		categorie<select name="categorie"> 
		<?php  
			while($row = $categorien->fetch_assoc()){
				echo "<option value='".$row['category_id']."'";
				if($row['name'] == $categorie_old){
				echo ' selected="selected"';
			}
			echo"'>".$row['name']."</option>";
			}
		?>
		</select>
		product naam <input type="text" name="productnaam" value="<?php echo "$name_old"?>" required>
		beschrijving <input type="textarea" name="beschrijving" value="<?php echo "$description_old"?>">
		prijs <input type="number" name="prijs" required min="0" max="999999999" value="<?php echo "$price_old"?>">
		maximum aantal producten <input type="number" name="maximumproducten" required min="0" max="999999999" value="<?php echo "$max_amount_old"?>">		
		<input type="submit" value="submit">
	</fieldset>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//if(!empty($_POST['type'])) {
$category_id = mysqli_real_escape_string($conn, $_POST['categorie']);
$name = mysqli_real_escape_string($conn, $_POST['productnaam']);
$description = mysqli_real_escape_string($conn, $_POST['beschrijving']);
$price = mysqli_real_escape_string($conn, $_POST['prijs']);
$max_amount = mysqli_real_escape_string($conn, $_POST['maximumproducten']); 

    //$sql = "UPDATE products
    //SET category_id='$category_id' name='$name',
    //description='$description',
    //price='$price',
    //max_amount='$max_amount'
   // WHERE product_id= '$product_id' ";
    $sql = "UPDATE products
    SET name='$name',
    category_id = '$category_id',
    description='$description',
    price='$price',
    max_amount='$max_amount'
    WHERE product_id= '$product_id' ";
	print($sql);

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
		header("Location: Product_aanpassen.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
//}
}