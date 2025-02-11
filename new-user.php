<?php
session_start();
require 'config.php'; // Ensure you have a database connection file

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: index.php');
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
        // Encrypt the password
        $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, encrypted_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $encrypted_password);
        
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>User added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding user.</div>";
        }
        
        $stmt->close();
    }
    $checkEmail->close();
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
   <!-- Sidebar -->
  <nav id="sidebar" class="sidebar">
    <!-- Toggler inside the sidebar -->
    <div class="sidebar-toggler" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
    <!-- Navigation Links -->
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <i class="fas fa-user-plus"></i>
            <span>Add User</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="clients.php">
            <i class="fas fa-users"></i>
            <span>Clients</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="loan.php">
            <i class="fas fa-dollar-sign"></i>
            <span>Loans</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments.php">
            <i class="fas fa-calendar"></i>
            <span>Payments</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="change_password.php">
            <i class="fas fa-key"></i>
            <span>Change Password</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="setting.php">
            <i class="fas fa-cogs"></i>
            <span>Settings</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?logout=true">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

    <div id="content" class="content">
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
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      sidebar.classList.toggle('closed');
      content.classList.toggle('closed');
    }
  </script>
</html>
