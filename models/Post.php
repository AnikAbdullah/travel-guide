<?php

class Post {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }

    public function getAllPosts(){

        $query = "SELECT * FROM posts
                  WHERE status='approved'
                  ORDER BY id DESC";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $data = [];

        while($row = mysqli_fetch_assoc($result)){

            $data[] = $row;
        }

        return $data;
    }
}

?>
