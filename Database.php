<?php

class Database {

    private $SERVER = 'localhost';
    private $USER = 'root';
    private $PASS = '$Wub2021$';
    private $DB = 'api_recharge';
    protected $conn = null;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->SERVER;dbname=".$this->DB, $this->USER, $this->PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print_r($e->getMessage());
            die();
        }
    }


}