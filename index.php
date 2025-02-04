<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prepare and execute the query to fetch the user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    // Check if user exists and verify the password
    if ($user && password_verify($password, $user['encrypted_password'])) {
        // Store user details in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];  //Store the user's name in the session
        $_SESSION['user_email'] = $user['email'];

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Handle invalid login attempt
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <form method="post" class="bg-white p-4 rounded shadow w-25">
        <h2 class="text-center">Login</h2>
        <?php if (isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="text-center mt-2"><a href="register.php">Don't have an account? Register</a></p>
    </form>
</body>
</html>
