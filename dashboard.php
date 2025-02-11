<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
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
          <a class="nav-link active" href="#">
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

  <!-- Main Content -->
  <div id="content" class="content">
    <h1 class="h2">Dashboard</h1>
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h3>  <!-- ✅ Fixed session variable -->
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Clients</h5>
            <p class="card-text">X number of clients in the system.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Loans</h5>
            <p class="card-text">X number of loans in the system.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Pending Payments</h5>
            <p class="card-text">X number of payments pending.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

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
</body>
</html>
