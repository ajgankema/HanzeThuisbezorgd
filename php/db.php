<?php
/**
 * Created by PhpStorm.
 * User: Arnold
 * Date: 3-11-2017
 * Time: 14:24
 */

class Db {

    public function __construct(){
        global $config;

        //Connect with the MySQL Database
        $this->connection = new mysqli(
            $config['DB_HOST'],
            $config['DB_USER'],
            $config['DB_PASS'],
            $config['DB_TABLE']
        );

    }

    public function getConnection(){
        return $this->connection;
    }

    public function close(){
        $this->connection->close();
    }

}