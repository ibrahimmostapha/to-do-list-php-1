<?php 

session_start();


if (empty($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('config.php');

// Query to fetch todos for the logged-in user
$sql = "SELECT * FROM todos WHERE user_id = " . $_SESSION['id'];
$result = mysqli_query($con, $sql);

// Fetch all todos for the logged-in user
$todos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $todos[] = $row;
}

// Handle Add To-Do
if (isset($_POST['submit'])) {
  $task = $_POST['task'];
  $user_id = $_SESSION['id'];

  // Insert new to-do into the database
  $sql = "INSERT INTO todos (user_id, task) VALUES ('$user_id', '$task')";
  mysqli_query($con, $sql);

  // Reload the page to show the new to-do
  header('Location: index.php');
  exit();
}

mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">


  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <title>To-Do List</title>
</head>

<body>

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h1>Hello, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
      <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>


    <div class="card p-4 shadow-sm mt-4">
      <h2>Your To-Do List:</h2>

      <!-- Form to add new task -->
      <form action="index.php" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="task" placeholder="Add your to-do..." required>
          <button class="btn btn-primary" type="submit" name="submit">Add</button>
        </div>
      </form>
      
      <ul class="list-group">
    <?php if (!empty($todos)): ?>
        <?php foreach ($todos as $todo): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo htmlspecialchars($todo['task']); ?>
                
                <div>
                    <!-- More Details Button -->
                    <a href="task-details.php?id=<?php echo $todo['todo_id']; ?>" class="btn btn-info btn-sm">More Details</a>
                    <!-- Delete Button -->
                    <form action="delete-task.php" method="POST" style="display:inline;">
                        <input type="hidden" name="todo_id" value="<?php echo $todo['todo_id']; ?>">
                        <button class="btn btn-danger btn-sm" type="submit" name="submit">Delete</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</ul>


    </div>

  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous">
  </script>


</body>

</html>
