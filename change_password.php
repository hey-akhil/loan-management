<?php
session_start();
require 'config.php'; // Database connection

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

$message = "";
$success = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  if ($new_password !== $confirm_password) {
    $message = "New passwords do not match.";
  } else {
    // Fetch stored password
    $stmt = $conn->prepare("SELECT encrypted_password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (password_verify($current_password, $stored_password)) {
      // Hash new password
      $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

      // Update password in DB
      $update_stmt = $conn->prepare("UPDATE users SET encrypted_password = ? WHERE id = ?");
      $update_stmt->bind_param("si", $new_hashed_password, $user_id);
      if ($update_stmt->execute()) {
        $success = true; // Trigger success popup
      } else {
        $message = "Error updating password.";
      }
      $update_stmt->close();
    } else {
      $message = "Current password is incorrect.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="css/slider.css">
</head>

<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div id="content" class="content closed">
    <div class="container">
      <h2>Change Password</h2>

      <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label>Current Password:</label>
          <input type="password" class="form-control" name="current_password" required>
        </div>
        <div class="mb-3">
          <label>New Password:</label>
          <input type="password" class="form-control" name="new_password" required>
        </div>
        <div class="mb-3">
          <label>Confirm New Password:</label>
          <input type="password" class="form-control" name="confirm_password" required>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Change Password</button>
          <a href="setting.php" class="btn btn-secondary">Back to Settings</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Popup Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-success">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Password changed successfully! Redirecting...
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS & JavaScript for Popup -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('closed');
      document.getElementById('content').classList.toggle('closed');
    }

    <?php if ($success): ?>
      var successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
      setTimeout(function () {
        window.location.href = "dashboard.php";
      }, 3000);
    <?php endif; ?>
  </script>

</body>

</html>