<?php

require_once '../models/User.php';

$user = new User(null);

$user->logoutUser();

header(
    "Location: ../views/auth/login.php"
);

exit();

?>