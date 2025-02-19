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
    <?php include 'sidebar.php';
    include('day-night-toggler.php');
    ?>

    <!-- Main Content -->
    <div id="content" class="content closed">
        <h1 class="h2">Dashboard</h1>
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h3> <!-- ✅ Fixed session variable -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('#')">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <h5 class="mt-3">Total Clients</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('#')">
                    <i class="fas fa-hand-holding-usd fa-3x text-success"></i>
                    <h5 class="mt-3">Total Loan</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('#')">
                    <i class="fas fa-hourglass-half fa-3x text-warning"></i>
                    <h5 class="mt-3">Pending Payments</h5>
                </div>
            </div>
            <div class="col-md-4">
                <a href="calculator.php" style="text-decoration: none; color: inherit;">
                    <div class="card text-center shadow-sm p-3 mb-4">
                        <i class="fas fa-calculator fa-3x text-danger"></i>
                        <h5 class="mt-3">EMI Calculator</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3 mb-4" onclick="redirectTo('#')">
                    <i class="fas fa-chart-pie fa-3x text-info"></i>
                    <h5 class="mt-3">Charts</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>