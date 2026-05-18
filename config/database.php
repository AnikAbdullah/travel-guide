<?php

class Database {

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "travel_guide";

    public $conn;

    public function connect(){

        $this->conn = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if(!$this->conn){

            die("Database Connection Failed");
        }

        return $this->conn;
    }
}

?>
