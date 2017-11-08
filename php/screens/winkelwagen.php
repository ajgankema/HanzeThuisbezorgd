<?php
// winkelwagen.php versie 1.1.1.1.1.1.1.1.1.1.1.1.1.1
// Laat het formulier zien en start een sessie en maak connectie met de database
//session_start();
//
//require("connect.php");
//$verbind_db = new DatabaseConnectie();


include("header.php");

// Koppel de stylesheet aan het formulier
?>
<!--<meta charset="utf-8">-->
<!--  <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<?php
// 3 actie knoppen staan op het winkelwagenformulier:
// toevoegen gerecht, verwijderen gerecht, wissen van alle geselecteerde gerechten



?>

<?php // Maak de Menukaart en toon alle gerechten uit de database tabel:products ?>
<div id="container" class="inset_from_header">
    <div class="arena">
<!--  <h3 align="center">MENU</h3>           -->
<!--  <table class="table table-hover">-->
<!--    <thead>-->
<!--      <tr>-->
<!--        <th>Gerecht</th>-->
<!--		<th>Afbeelding</th>-->
<!--        <th>Beschrijving</th>-->
<!--        <th>Prijs</th>-->
<!--		<th>Aantal</th>-->
<!--		<th>Toevoegen</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->

	<?php
//	$result = $db->query("SELECT * FROM products ORDER BY product_id ASC");
//	if (!empty($result)) {
	// Vul nu een array $resultaat met de waarden uit de velden
//		foreach($resultaat as $key=>$value){
//        while($row = $result->fetch_assoc()){
	?>
<!--			<tr>-->
<!--			<form method="post" action="?knop=toevoegen&product_id=--><?php //echo $row["product_id"]; ?><!--">-->
<!--				<td>--><?php //echo $row["name"] ?><!--</td>-->
<!--				<td><img src="--><?php //echo $row["img"] ?><!--"/></td>-->
<!--				<td>--><?php //echo $row["description"]; ?><!--</td>-->
<!--				<td>--><?php //echo $row["price"] ?><!--</td>-->
<!--				<td><input type="text" name="max_amount" value="1" size="2" /></td>-->
<!--				<td>-->
<!--					<input type="hidden" name="product_id" value="--><?//=$row['product_id'];?><!--">-->
<!--					<input type ="submit" name = "toevoegen" value ="Voeg toe"/> -->
<!--				</td>-->
<!--			</form>-->
<!--			</tr>-->
	<?php
//			}
//	}
	?>
<!--	    </tbody>-->
<!-- </table>-->
<!--</div>-->

<?php // Maak de winkelwagen ?>
<div class="container">
 <h3 align="left">WINKELWAGEN</h3> 
 <form method="post" action="?knop=wisalles">
 <input type ="submit" name = "toevoegen" value ="WIS ALLES"/>
 </form>
<?php
if(isset($_SESSION["Winkelwagen"])){
    $item_total = 0;
?>	
<table class="table table-hover">
<tbody>
<tr>
<th>Naam</th>
<th>Aantal</th>
<th>Prijs</th>
<th>Verwijderen</th>
</tr>	
<?php		
    foreach ($_SESSION["Winkelwagen"] as $item){
		?>
				<tr>
				<td><?php echo $item["name"]; ?></td>
				<td><?php echo $item["max_amount"]; ?></td>
				<td><?php echo "€".substr($item["price"],0,strlen($row['price'])-2); ?></td>
				<td><a href="?knop=verwijderen&product_id=<?php echo $item["product_id"]; ?>">Verwijderen</a></td>
				</tr>
				<?php
        $item_total += ($item["price"]*$item["max_amount"]);
		}
		?>
<tr>
<td colspan="5" align=right><strong>Totaalbedrag:</strong> <?php echo "€".$item_total; ?></td>
</tr>
</tbody>
</table>
</div>		
  <?php
}
?>

    <button onclick="location.href='<?=$config['Base_URL'];?>/bestellen';" class="fancy">Bestellen</button>
    <button onclick="location.href='<?=$_SESSION['previous_page'];?>'" class="fancy">Terug</button>
</div>
</div>