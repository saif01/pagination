<?php

class Db {

    private $servername = "localhost";
    private $username = "root";
    private $password = "123456";
    private $db = "pagination";

    public function __construct() {
        session_start();
    }

    public function db() {

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

  

}
