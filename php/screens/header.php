<header>
    <div class="content">
        <a href="<?=$config['Base_URL'];?>" class="logo">
            <i class="fa fa-cutlery" aria-hidden="true"></i>
        </a>
        <div class="title">
            <a href="<?=$config['Base_URL'];?>"><?=$restaurant->getName();?>ISnack.nl</a>
        </div>
        <div class="nav">

            <?php if($user->isLoggedIn()):?>
                <ul>
                    <li>
                        <a href="javascript:void(0)" title="Winkelwagen" class="button">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            Winkelwagen
                        </a>
                    </li>
                    <li>
                        <a href="<?=$config['Base_URL'];?>/Account" title="Account pagina" class="button">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            Account
                        </a>
                    </li>
                    <li>
                        <a href="?logout=true" title="Uitloggen" class="button no_text">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            <?php else: ?>
                <ul>
                    <li>
                        <a href="javascript:void(0)" onclick="openLogin()" title="Inloggen" class="button">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Inloggen
                        </a>
                    </li>
                </ul>
            <?php endif; ?>


        </div>
    </div>
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
</header>