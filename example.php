<?php

//Include PHP files
include("php/config.php");
include("php/db.php");

//Setup the database connection
$db = (new Db())->getConn();