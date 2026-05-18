<?php

class User {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }

    public function registerUser(
        $name,
        $email,
        $password,
        $role
    ){

        $query = "INSERT INTO users(
                    name,
                    email,
                    password_hash,
                    role,
                    is_verified
                  )
                  VALUES(?,?,?,?,0)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $name,
            $email,
            $hashedPassword,
            $role
        );

        return mysqli_stmt_execute($stmt);
    }

    public function loginUser(
        $email,
        $password
    ){

        $query = "SELECT * FROM users
                  WHERE email=? LIMIT 1";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        if(
            $user &&
            password_verify(
                $password,
                $user['password_hash']
            )
        ){
            return $user;
        }

        return false;
    }

    public function emailExists($email){

        $query = "SELECT id FROM users
                  WHERE email=?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        return mysqli_stmt_num_rows($stmt) > 0;
    }

    public function logoutUser(){

        session_start();

        session_unset();

        session_destroy();
    }
}

?>
