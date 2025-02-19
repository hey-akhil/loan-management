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
  <?php include 'sidebar.php'; 
  include ('day-night-toggler.php');
  ?>

  <!-- Main Content -->
  <div id="content" class="content closed">
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
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('change_password.php')">
          <i class="fas fa-key fa-3x text-muted"></i>
          <h5 class="mt-3">Change Password</h5>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('#')">
          <i class="fas fa-file-alt fa-3x text-info"></i>
          <h5 class="mt-3">Documentation</h5>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function redirectTo(page) {
      window.location.href = page;
    }
  </script>
</body>

</html>