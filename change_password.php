<?php
session_start();
require 'config.php'; // Ensure database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
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
  <!-- Sidebar -->
  <nav id="sidebar" class="sidebar">
    <div class="sidebar-toggler" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
        <li class="nav-item"><a class="nav-link" href="loan.php"><i class="fas fa-dollar-sign"></i> Loans</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-calendar"></i> Payments</a></li>
        <li class="nav-item"><a class="nav-link active" href="change_password.php"><i class="fas fa-key"></i> Change Password</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cogs"></i> Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div id="content" class="content">
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
        <button type="submit" class="btn btn-primary">Change Password</button>
      </form>
      <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
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
          Password changed successfully!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
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

    // Show success modal if password changed successfully
    <?php if ($success): ?>
      var successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
    <?php endif; ?>
  </script>

</body>
</html>
