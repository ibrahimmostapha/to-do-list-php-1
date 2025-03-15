<?php
// Start session at the beginning
session_start();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if email and password are not empty
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        // Get and sanitize input values
        include('config.php'); // Database connection

        $email = mysqli_real_escape_string($con, $_POST['email']); // Prevent SQL Injection
        // $email = $_POST['email'];
        $password = hash('sha256', $_POST['password']); // Hash the password with SHA-256

        // Query to check if email and password match
        $sql = "SELECT id, email FROM users WHERE email='$email' AND password='$password'";
        
        // Execute the query
        $result = mysqli_query($con, $sql);

        // Check if a result was returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the user data from the result
            $user = mysqli_fetch_assoc($result);

            // Store user data in session
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Redirect to index.php
            header('Location: index.php');
            exit();
        } else {
            echo "<p class='text-danger'>Email or Password is wrong.</p>";
        }

        // Close the database connection
        mysqli_close($con);
    } else {
        echo "<p class='text-danger'>Email and Password cannot be empty.</p>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- my css -->
    <link rel="stylesheet" href="login.css">

    <title>Log In</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Login to Your To-Do List</h2>
        <div class="card p-4 shadow-sm">
            <form action="login.php" method="post">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>

        <div class="text-center mt-4">
            <h5>Don't have an account?</h5>
            <a href="create-acc.php" class="btn btn-link">Create account</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!-- my script -->
    <script src="myscripts.js"></script>
</body>

</html>
