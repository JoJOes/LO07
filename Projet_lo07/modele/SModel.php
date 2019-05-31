<?php

class SModel extends PDO {

    private static $_instance;

    // Constructeur : héritage public obligatoire par héritage de PDO
    public function __construct() {
        
    }

    //Singleton
    public static function getInstance() {
        // les variables sont définies dans le fichier config.php
        global $dsn, $username, $password;
        
        require 'config.php';
        /*$dsn = 'mysql:dbname=tp11;host=localhost;charset=utf8';
        $username = 'root';
        $password = 'root';*/
        
        
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        if (!isset(self::$_instance)) {
            try {
                self::$_instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            }
        }
        return self::$_instance;
    }

}
