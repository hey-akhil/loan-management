<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Initialize message variable
$message = "";

// Get User Data
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found!");
    }
} else {
    die("Invalid request!");
}

// Update User
if (isset($_POST['update_user'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    if (!empty($name) && !empty($email)) {
        $query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $name, $email, $id);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>User updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating user!</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>All fields are required!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit User</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/slider.css">
</head>
<body>

<div id="content" class="content">
    <h1 class="h2">Edit User</h1>
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
          <a class="nav-link" href="new-user.php">
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
          <a class="nav-link active" href="setting.php">
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

    <?= $message; ?> <!-- Display messages -->

    <form method="post">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" name="update_user" class="btn btn-success">Update</button>
        <a href="../loan/admins.php" class="btn btn-secondary">Back</a>
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
