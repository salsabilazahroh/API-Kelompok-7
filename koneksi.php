<?php

$conn = mysqli_connect("localhost", "root", "", "db_restapi");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
