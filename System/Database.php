<?php

namespace Ssp\System;

class Database 
{

    private static $dbName = DB_NAME;
    private static $dbHost = DB_HOST;
    private static $dbUsername = DB_USERNAME;
    private static $dbUserPassword = DB_PASSWORD;
    private static $conn = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
      
        if (null == self::$conn) {
            try {
                self::$conn = new \PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (\PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$conn;
        
    }

    public static function disconnect() {
        self::$conn = null;
    }

}
