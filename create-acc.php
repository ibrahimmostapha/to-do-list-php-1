<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if email and password are not empty
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize email (addslashes to escape special characters)
        $email = addslashes($email);
        
        // Hash the password using SHA-256
        $password = hash('sha256', $password);

        // database connection
        include('config.php');

        // Check if the email already exists in the database
        $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $email_check_result = mysqli_query($con, $email_check_query);
        
        if (mysqli_num_rows($email_check_result) > 0) {
            // If email already exists, display error message
            echo "<p class='text-danger'>This email is already used. Please use a different one.</p>";
        } else {
            // If email doesn't exist, insert the new user into the database
            $sql = "INSERT INTO users (email, password) VALUES ('".$email."', '".$password."')";
            
            // Execute the query
            $result = mysqli_query($con, $sql);

            // Check if the query was successful
            if (!$result) {
                echo "<p class='text-danger'>Something went wrong. Please try again later.</p>";
                // Redirect to create-acc.php to try again
                header('Location: create-acc.php');
                exit();
            } else {
                // Redirect to login.php to login
                header('Location: login.php');
                exit();
            }
        }
        // Close the database connection
        mysqli_close($con);
    } else {
        // Error if email or password is empty
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
    <link rel="stylesheet" href="create-acc.css">

    <title>Create Account</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Create an Account for Your To-Do List</h2>
        <div class="card p-4 shadow-sm">
            <form action="create-acc.php" method="post">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Create a password" name="password" required>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
        <div class="text-center mt-4">
            <h5>You have an account?</h5>
            <a href="login.php" class="btn btn-link">Login</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!-- my script -->
    <script src="myscripts.js"></script>

</body>

</html>
