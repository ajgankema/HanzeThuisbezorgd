<body>
    <?php include("header.php");?>

    <div id="big_screen">
        <div id="zoekpaneel">
            <form>
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input id="search_input" type="text" class="search-query form-control" placeholder="Adres of postcode..." />
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button">
                                <span class=" glyphicon glyphicon-search">
                                </span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div style="padding-bottom:20px;" class="arrow-down-header"></div>

    <?php include ("home_content.php");?>

    <?php include ("footer.php");?>
</body>