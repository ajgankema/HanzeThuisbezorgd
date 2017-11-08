<?php if(!empty($_SESSION['Winkelwagen']))$green = "green";?>

<header>
    <div class="content">
        <a href="<?=$config['Base_URL'];?>" class="logo">
            <i class="fa fa-cutlery" aria-hidden="true"></i>
        </a>
        <div class="title">
            <a href="<?=$config['Base_URL'];?>"><?=$restaurant->getName();?></a>
        </div>
        <div class="nav">

            <?php if($user->isLoggedIn()):?>
                <ul>
                    <li>
                        <a href="<?=$config['Base_URL'];?>/winkelwagen" title="Winkelwagen" class="button <?=$green;?>">
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
                    <?php
                        if($user->isRestaurantManager())
                        {
                            ?>
                                <li>
                                    <a href="<?=$config['Base_URL'];?>/Restaurantbeheer" title="Wijzig restaurant" class="button">
                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                        Restaurant wijzigen
                                    </a>
                                </li>
                    <?php
                        }
                    ?>
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
</header>