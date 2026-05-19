<?php

$conn = mysqli_connect("localhost", "root", "", "travel_guide");

if (!$conn) {
    die("Database connection failed");
}
