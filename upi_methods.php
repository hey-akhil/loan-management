<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "loan_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include QR Code Library
include('phpqrcode/qrlib.php');

// Handle Add Request (Prepared Statement)
if (isset($_POST['add_upi'])) {
    $upi = $_POST['upi_id'];
    $payee = $_POST['payee_name'];

    $stmt = $conn->prepare("INSERT INTO users_upi (upi_id, payee_name, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $upi, $payee);
    echo ($stmt->execute()) ? "success" : "Error: " . $stmt->error;
    $stmt->close();
    exit();
}

// Handle Edit Request (Prepared Statement)
if (isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $upi = $_POST['upi_id'];
    $payee = $_POST['payee_name'];

    $stmt = $conn->prepare("UPDATE users_upi SET upi_id=?, payee_name=? WHERE id=?");
    $stmt->bind_param("ssi", $upi, $payee, $id);
    echo ($stmt->execute()) ? "success" : "Error updating: " . $stmt->error;
    $stmt->close();
    exit();
}

// Handle Delete Request (Prepared Statement)
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM users_upi WHERE id=?");
    $stmt->bind_param("i", $id);
    echo ($stmt->execute()) ? "success" : "Error deleting: " . $stmt->error;
    $stmt->close();
    exit();
}

// Fetch UPI Methods
$sql = "SELECT * FROM users_upi ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment Methods</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/slider.css"> <!-- Ensure slider.css exists -->

    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        table { width: 100%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: #007bff; color: white; }
        .selected { background-color: #f0f8ff; }
        .modal { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                 background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.5); }
        #qrPopup { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.5); text-align: center; }
    </style>
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

<div id="content" class="content">
    <h2>UPI Payment Methods</h2>
    <div class="btndiv text-end">
    <a href="../loan/setting.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>UPI ID</th>
            <th>Payee Name</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php $first = true; while ($row = $result->fetch_assoc()) { ?>
            <tr onclick="selectRow(<?php echo $row['id']; ?>)" id="row_<?php echo $row['id']; ?>" class="<?php echo $first ? 'selected' : ''; ?>">
                <td><?php echo $row['id']; ?></td>
                <td class="upi"><?php echo htmlspecialchars($row['upi_id']); ?></td>
                <td class="payee"><?php echo htmlspecialchars($row['payee_name']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <button class="btn btn-success" onclick="editEntry(<?php echo $row['id']; ?>)">Edit</button>
                    <button class="btn btn-danger" onclick="deleteEntry(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php $first = false; } ?>
    </table>

    <h2>Generate Loan Payment QR Code</h2>
    <div>
        <input type="number" id="amount" name="amount" placeholder="Enter amount">
        <button id="generateQR">Generate QR</button>
    </div>

    <div id="qrPopup">
        <h3>Scan to Pay</h3>
        <img id="qrCode" src="" alt="QR Code">
        <br><br>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>
    function selectRow(id) {
        document.querySelectorAll("tr").forEach(row => row.classList.remove("selected"));
        document.getElementById('row_' + id).classList.add("selected");
    }

    document.getElementById('generateQR').addEventListener('click', function() {
        let selectedRow = document.querySelector('tr.selected');
        if (!selectedRow) {
            alert("Please select a UPI method first.");
            return;
        }

        let upi_id = selectedRow.querySelector('.upi').innerText;
        let payee = selectedRow.querySelector('.payee').innerText;
        let amount = document.getElementById('amount').value;

        if (!amount || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        let qrImage = document.getElementById('qrCode');
        qrImage.src = "qr-generate.php?upi_id=" + encodeURIComponent(upi_id) + 
          "&payee=" + encodeURIComponent(payee) + 
          "&amount=" + encodeURIComponent(amount);

        document.getElementById('qrPopup').style.display = "block";
    });

    function closePopup() {
        document.getElementById('qrPopup').style.display = "none";
    }

    function deleteEntry(id) {
        if (confirm("Are you sure you want to delete this UPI method?")) {
            fetch('', { method: 'POST', body: new URLSearchParams({ delete_id: id }) })
                .then(response => response.text())
                .then(response => { if (response === "success") location.reload(); });
        }
    }

    function editEntry(id) {
        alert("Edit function is under development.");
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
