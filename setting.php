<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/slider.css">
</head>
<body>
  <!-- Sidebar -->
  <nav id="sidebar" class="sidebar">
    <div class="sidebar-toggler" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="new-user.php">
            <i class="fas fa-user-plus"></i> <span>Add User</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="clients.php">
            <i class="fas fa-users"></i> <span>Clients</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="loan.php">
            <i class="fas fa-dollar-sign"></i> <span>Loans</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments.php">
            <i class="fas fa-calendar"></i> <span>Payments</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="change_password.php">
            <i class="fas fa-key"></i> <span>Change Password</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <i class="fas fa-cogs"></i> <span>Settings</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?logout=true">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div id="content" class="content">
    <h1 class="h2">Settings</h1>

    <!-- Settings Cards -->
    <div class="row">
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('admins.php')">
          <i class="fas fa-user-shield fa-3x text-primary"></i>
          <h5 class="mt-3">See All Admins</h5>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('upi_methods.php')">
          <i class="fas fa-university fa-3x text-success"></i>
          <h5 class="mt-3">UPI Payment Methods</h5>
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

    function redirectTo(page) {
      window.location.href = page;
    }
  </script>
</body>
</html>
