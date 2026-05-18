<?php

class Wishlist {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }

    public function addWishlist(
        $user_id,
        $post_id
    ){

        $query = "INSERT INTO wishlist(
                    user_id,
                    post_id
                  )
                  VALUES(?,?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $user_id,
            $post_id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function removeWishlist(
        $user_id,
        $post_id
    ){

        $query = "DELETE FROM wishlist
                  WHERE user_id=?
                  AND post_id=?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $user_id,
            $post_id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getWishlist(
        $user_id
    ){

        $query = "SELECT posts.*
                  FROM wishlist
                  JOIN posts
                  ON wishlist.post_id = posts.id
                  WHERE wishlist.user_id=?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $user_id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $data = [];

        while($row = mysqli_fetch_assoc($result)){

            $data[] = $row;
        }

        return $data;
    }
}

?>
