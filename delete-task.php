<?php

session_start();

// check if login
if (empty($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// check if the task id is submited
if (empty($_POST['todo_id'])) {
    echo "<p class='text-danger'>error deleting task</p>";
    header('Location: index.php');
    exit();
}

$todo_id = $_POST['todo_id'];
$user_id = $_SESSION['id'];

// Database connection
include('config.php');

// Query to delete the task
$sql = "DELETE FROM todos where todo_id='$todo_id' AND user_id ='$user_id'";

// Execute the query
$result = mysqli_query($con, $sql);

mysqli_close($con);

if (!$result) {
    echo "<p class='text-danger'>error deleting task</p>";
    header('Location: index.php');
    exit();
} else {
    echo "<p class='text-danger'>task has been deleted successfully</p>";
    header('Location: index.php');
}



?>