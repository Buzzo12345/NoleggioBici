<?php
require_once "DbConfig.php";
class Database {
  private static $conn = null;


   public static function getConnection(): PDO {
       if (Database::$conn === null) {

           $dsn = "mysql:host=" . DbConfig::HOST .
                  ";dbname=" . DbConfig::DBNAME .
                  ";charset=" . DbConfig::CHARSET;

          Database::$conn = new PDO($dsn,DbConfig::USER,DbConfig::PASSWORD);
       }

       return Database::$conn;
   }
}
