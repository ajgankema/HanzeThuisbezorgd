<body>
<?php
include ("header.php");

$restaurant_id = $restaurant->getRestaurantId();

$sql = "SELECT * FROM categories";
$results = $db->query($sql);

?>

<div id="container" class="inset_from_header">
    <div class="arena" id="menukaart">
        <h1 class="arena_title">Menukaart</h1>

        <div class="kaart">
            <div class="categorie">
                <?php
                while($row = $results->fetch_assoc()){
                    $sql = "SELECT * FROM products WHERE restaurant_id = '$restaurant_id' AND category_id = '".$row['category_id']."'";
                    $results2 = $db->query($sql);
                    ?>

                    <h3 class="title"><?=$row['name'];?></h3>
                    <div class="etenlijst">
                        <?php while($row2 = $results2->fetch_assoc()){ ?>
                            <div class="etenswaar">
                                <h4><?=$row2['name'];?></h4>
                                <p class="description"><?=$row2['description'];?></p>
                                <p class="price">&euro;<?=substr($row2['price'],0,strlen($row2['price'])-2);?></p>
                                <div class="functions">
                                    <a href="?knop=toevoegen&product_id=<?=$row2['product_id'];?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
                                    <a href="?knop=verwijderen&product_id=<?=$row2['product_id'];?>"><i class="fa fa-minus-square-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        <?php }?>
                    </div>

                    <?php
                } ?>
            </div>
        </div>

        <?php if(!empty($_SESSION['Winkelwagen'])){?>
        <button onclick="location.href='<?=$config['Base_URL'];?>/winkelwagen';" class="fancy">Winkelwagen</button>
        <?php }?>
            <div id="container">
                    <?php include ("reviews.php");?>
            </div>
    </div>
</div>

<?php include ("footer.php");?>
</body>