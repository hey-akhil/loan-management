<?php
session_start();
require 'config.php'; // Database connection

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

// Handle logout
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
  <title>Payments - Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/slider.css">
</head>

<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div id="content" class="content closed">
    <h1 class="h2">Payments</h1>
    <p>This is the Payments page.</p>
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