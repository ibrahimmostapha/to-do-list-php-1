<?php

$con = mysqli_connect("localhost","ibrahim","ibrahim","todo_list");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>