<body>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['type']=="postalcode"){
            header("Location: ".$config['Base_URL']."/menu");
        }
    }

    ?>

    <?php include ("header.php");?>

    <?php include ("home_header.php");?>

    <?php include ("home_content.php");?>

    <?php include ("footer.php");?>
</body>