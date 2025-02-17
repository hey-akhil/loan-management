<?php
// Database Connection
include('config.php');
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
        body {
            font-family: Arial, sans-serif;
        }

        .table-responsive {
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        .selected {
            background-color: #f0f8ff;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        #qrPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div id="content" class="content closed">
        <h2>UPI Payment Methods</h2>

        <div class="text-end mb-3">
            <a href="../loan/setting.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>UPI ID</th>
                        <th>Payee Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $first = true;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr onclick="selectRow(<?php echo $row['id']; ?>)" id="row_<?php echo $row['id']; ?>"
                            class="<?php echo $first ? 'selected' : ''; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td class="upi"><?php echo htmlspecialchars($row['upi_id']); ?></td>
                            <td class="payee"><?php echo htmlspecialchars($row['payee_name']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <!-- Edit Button with Icon -->
                                <button class="btn btn-success" onclick="editEntry(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button id="deleteButton_<?php echo $row['id']; ?>" class="btn btn-danger"
                                    onclick="deleteEntry(<?php echo $row['id']; ?>)" disabled>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $first = false;
                    } ?>
                </tbody>
            </table>
        </div>

        <h2 class="mt-5">Generate Loan Payment QR Code</h2>
        <div class="col-md-4 col-sm-6 mb-3">
            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount">
            <button id="generateQR" class="btn btn-primary mt-2">Generate QR</button>
        </div>

        <div id="qrPopup">
            <h3>Scan to Pay</h3>
            <img id="qrCode" src="" alt="QR Code">
            <br><br>
            <button onclick="closePopup()" class="btn btn-secondary">Close</button>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit UPI Method</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label>UPI ID</label>
                        <input type="text" id="edit_upi_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Payee Name</label>
                        <input type="text" id="edit_payee_name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateEntry()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generateQR').addEventListener('click', function () {
            generateQRCode();
        });

        function generateQRCode() {
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
        }

        function closePopup() {
            document.getElementById('qrPopup').style.display = "none";
        }

        function deleteEntry(id) {
            if (confirm("Are you sure you want to delete this UPI method?")) {
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ delete_id: id })
                })
                    .then(response => response.text())
                    .then(response => {
                        if (response.trim() === "success") {
                            alert("Deleted successfully!");
                            location.reload();
                        } else {
                            alert("Error: " + response);
                        }
                    });
            }
        }

        function editEntry(id) {
            let row = document.getElementById('row_' + id);
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_upi_id').value = row.querySelector('.upi').innerText;
            document.getElementById('edit_payee_name').value = row.querySelector('.payee').innerText;

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function updateEntry() {
            let id = document.getElementById('edit_id').value;
            let upi_id = document.getElementById('edit_upi_id').value;
            let payee_name = document.getElementById('edit_payee_name').value;

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ edit_id: id, upi_id: upi_id, payee_name: payee_name })
            })
                .then(response => response.text())
                .then(response => {
                    if (response.trim() === "success") {
                        alert("Updated successfully!");
                        location.reload();
                    } else {
                        alert("Error updating: " + response);
                    }
                });
        }

        function selectRow(id) {
            document.querySelectorAll("tr").forEach(row => row.classList.remove("selected"));
            document.getElementById('row_' + id).classList.add("selected");
        }

        function disableDeleteButton(id) {
            let deleteButton = document.querySelector(`#row_${id} .btn-danger`);
            deleteButton.disabled = true; // Disable the button
        }
    </script>
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