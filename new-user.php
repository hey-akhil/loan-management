<?php
session_start();
require 'config.php'; // Ensure you have a database connection file

// Redirect to login if not logged in
if (!isset($_SESSION['user_name'])) {
  header('Location: index.php');
  exit();
}

$message = "";

// Handle logout
if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "<div class='alert alert-danger'>Invalid email format!</div>";
  } elseif (strlen($password) < 6) {
    $message = "<div class='alert alert-danger'>Password must be at least 6 characters!</div>";
  } else {
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
      $message = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
      // Encrypt the password
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Insert into database
      $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hashed_password);

      if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>User added successfully!</div>";
      } else {
        $message = "<div class='alert alert-danger'>Error adding user.</div>";
      }

      $stmt->close();
    }
    $checkEmail->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/slider.css">
</head>

<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; 
  include ('day-night-toggler.php');
  ?>

  <div id="content" class="content closed">
    <h2>Add New User</h2>
    <?php echo $message; ?>
    <form method="POST" action="add_user.php">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Add User</button>
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>