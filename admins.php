<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

// Initialize message variable
$message = "";

// Delete User
if (isset($_GET['delete_id'])) {
  $delete_id = intval($_GET['delete_id']); // Ensure it's an integer
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $delete_id);

  if ($stmt->execute()) {
    $message = "<div class='alert alert-success'>User deleted successfully!</div>";
  } else {
    $message = "<div class='alert alert-danger'>Error deleting user: " . $stmt->error . "</div>";
  }
  $stmt->close();

  // Redirect to prevent multiple deletion on refresh
  header("Location: ../loan/admins.php");
  exit();
}

// Add New User
if (isset($_POST['add_user'])) {
  $name = $conn->real_escape_string(trim($_POST['name']));
  $email = $conn->real_escape_string(trim($_POST['email']));
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  if (!empty($name) && !empty($email) && !empty($_POST['password'])) {
    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
      $message = "<div class='alert alert-warning'>Email already exists! Try a different one.</div>";
    } else {
      // Insert new user
      $query = "INSERT INTO users (name, email, encrypted_password) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sss", $name, $email, $password);
      if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>User added successfully!</div>";
      } else {
        $message = "<div class='alert alert-danger'>Error adding user: " . $stmt->error . "</div>";
      }
    }
  } else {
    $message = "<div class='alert alert-warning'>All fields are required!</div>";
  }
}

// Fetch Users
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admins</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/slider.css">
</head>

<body>
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div id="content" class="content closed">
    <h1 class="h2">Admins !!</h1>

    <?= $message; ?> <!-- Display messages -->

    <!-- Add User Form -->
    <form method="post" class="mb-4">
      <h4>Add New Admins</h4>
      <div class="row g-3">
        <div class="col-md-4 col-sm-2">
          <input type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="col-md-4 col-sm-2">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-4 col-sm-2">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-6">
          <button type="submit" name="add_user" class="btn btn-success w-100">Add User</button>
        </div>
      </div>
    </form>

    <!-- Users Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['created_at']); ?></td>
                <td>
                  <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                  <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No users found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Back to Dashboard Button -->
    <div class="mt-3">
      <a href="../loan/setting.php" class="btn btn-secondary w-100">Back to Dashboard</a>
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