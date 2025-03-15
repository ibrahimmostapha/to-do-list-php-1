<?php

session_start();

// check if login
if (empty($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Check if task ID is provided in the URL
if (empty($_GET['id'])) {
    echo "<p class='text-danger'>Invalid task ID</p>";
    exit();
}

$todo_id = $_GET['id'];
$user_id = $_SESSION['id'];

// Database connection
include('config.php');

// Fetch task details
$sql = "SELECT * FROM todos WHERE todo_id='$todo_id' AND user_id='$user_id'";
$result = mysqli_query($con, $sql);
$task = mysqli_fetch_assoc($result);

mysqli_close($con);

// Check if task exists
if (!$task) {
    echo "<p class='text-danger'>Task not found or you do not have permission to view it.</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h2>Task Details</h2>
    
    <div class="card p-4 shadow-sm mt-3">
        <h4>task: <?php echo htmlspecialchars($task['task']); ?></h4>
        <p><strong>Task ID:</strong> <?php echo $task['todo_id']; ?></p>
        <p><strong>Created At:</strong> <?php echo $task['created_at']; ?></p>
        
        <a href="index.php" class="btn btn-primary mt-3">Back to List</a>
    </div>
</div>

</body>
</html>