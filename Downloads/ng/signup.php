<?php
session_start();
include 'dbconfig.php';

$showError = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['signupEmail'];
    $password = md5($_POST['signupPass']); // Using MD5 (not recommended for production)

    // Insert the new user into the database
    $insertUserQuery = "INSERT INTO users (email, password, status, blocked) VALUES (?, ?, 1, 0)";
    $stmt = mysqli_prepare($conn, $insertUserQuery);

    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect to the login page after successful signup
        header("Location: index.php");
        exit;
    } else {
        $showError = true;
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Signup</h2>
            </div>
            <div class="card-body">
                <?php if ($showError) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo "Error during signup. Please try again."; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="signupEmail">Email address</label>
                        <input type="email" class="form-control" id="signupEmail" name="signupEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="signupPass">Password</label>
                        <input type="password" class="form-control" id="signupPass" name="signupPass" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Signup</button>
                </form>

                <!-- Link to the login page -->
                <p class="mt-3 text-center">Already have an account? <a href="index.php">Login here</a>.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>

</html>
