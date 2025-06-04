<?php

namespace Src\Config;

use PDO;

class Connection {
    private static $instance;

    public static function getConn(){

        if (!isset(self::$instance)){
            self::$instance = new \PDO('mysql:host=localhost;dbname=transaction_api', 'root', '');
        }
        return self::$instance;
    }
}