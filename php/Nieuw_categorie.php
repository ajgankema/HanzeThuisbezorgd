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
// formulier
?>
<form method="POST" action="Nieuw_categorie.php">
	<fieldset>
		<legend>categorie maken</legend>
		categorie naam <input type="text" name="categorienaam" required>
		beschrijving <input type="text" name="beschrijving">
		<input type="submit" value="submit">
	</fieldset>
</form>
<?php
//in database zetten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$name = mysqli_real_escape_string($conn, $_POST['categorienaam']);
$description = mysqli_real_escape_string($conn, $_POST['beschrijving']);

$sql = "INSERT INTO categories (name, description)
VALUES ('$name','$description')";

if (mysqli_query($conn, $sql)) {
    echo "de nieuwe categorie is succesvol aangemaakt.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
?>