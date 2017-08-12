<?php
/**
 * Created by PhpStorm.
 * User: Tushar Khan
 * Date: 4/25/2017
 * Time: 4:31 PM
 */
 /*
 * Database Class
 * Connect MySQL
 * Lonin System
 */
 //include 'User.php';
 //include 'database.php';
    class Database
    {
        private $hostdb = "localhost";
        private $userdb = "root";
        private $passdb = "";
        private $namedb = "login";
        public $pdo;

        /*
         * Constructor Function
         * for Database Connection
         */
        public function __construct()
        {
            if(!isset($this->pdo))
            {
                try
                {
                    $link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb, $this->userdb, $this->passdb);
                    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $link->exec("SET CHARACTER SET utf8");
                    $this->pdo = $link;
                }
                catch (PDOException $e)
                {
                    die("Fail to connect with Database".$e->getMessage()."<br/> File Name :".__FILE__."<br/> Class Name :".__CLASS__."<br/>"."Line Number :".__LINE__."<br/>");
                }
            }
        }
    }

    //include 'head.php';
?>