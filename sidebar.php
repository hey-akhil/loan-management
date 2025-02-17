<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']); // Get current page file name
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_start();
    session_destroy();
    header('Location: index.php'); // Redirect to the login page after logout
    exit();
}
?>

<nav id="sidebar" class="sidebar closed">
    <div class="sidebar-toggler" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'new-user.php') ? 'active' : '' ?>" href="new-user.php">
                    <i class="fas fa-user-plus"></i>
                    <span>Add User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'clients.php') ? 'active' : '' ?>" href="clients.php">
                    <i class="fas fa-users"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'loan.php') ? 'active' : '' ?>" href="loan.php">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Loans</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'payments.php') ? 'active' : '' ?>" href="payments.php">
                    <i class="fas fa-calendar"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'change_password.php') ? 'active' : '' ?>"
                    href="change_password.php">
                    <i class="fas fa-key"></i>
                    <span>Change Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'setting.php') ? 'active' : '' ?>" href="setting.php">
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