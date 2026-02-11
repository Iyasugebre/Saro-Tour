<?php
include("setting.php");
session_start();

/* Protect page */
if (!isset($_SESSION['aid'])) {
    header("Location: admin.php");
    exit;
}

$aid = mysqli_real_escape_string($al, $_SESSION['aid']);
$result = mysqli_query($al, "SELECT name FROM admin WHERE aid='$aid'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | VMS</title>

<style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
}

/* BODY */
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #4ca1af, #c4e0e5);
}

/* HEADER */
#header {
    width: 100%;
    height: 70px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.headingMain {
    font-size: 26px;
    font-weight: 600;
    color: #222;
}

/* WELCOME */
.welcome {
    margin-top: 40px;
    text-align: center;
}

.welcome h2 {
    font-size: 28px;
    color: #222;
}

/* DASHBOARD GRID */
.dashboard {
    margin: 50px auto;
    max-width: 1100px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 25px;
    padding: 0 20px;
}

/* CARD */
.card {
    background: white;
    border-radius: 18px;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    transition: 0.3s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 50px rgba(0,0,0,0.3);
}

/* CARD LINK */
.card a {
    text-decoration: none;
    color: #333;
    font-size: 20px;
    font-weight: 600;
    display: block;
}

/* ICON */
.card span {
    display: block;
    font-size: 42px;
    margin-bottom: 15px;
    color: #4ca1af;
}

/* LOGOUT */
.logout span {
    color: #e74c3c;
}
</style>
</head>

<body>

<div id="header">
    <span class="headingMain">Vacation Management Site</span>
</div>

<div class="welcome">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
</div>

<div class="dashboard">

    <div class="card">
        <a href="holiday.php">
            <span>📦</span>
            Manage Packages
        </a>
    </div>

    <div class="card">
        <a href="orders.php">
            <span>🧾</span>
            Orders
        </a>
    </div>

    <div class="card">
        <a href="changePasswordAdmin.php">
            <span>🔐</span>
            Change Password
        </a>
    </div>

    <div class="card logout">
        <a href="logout.php">
            <span>🚪</span>
            Logout
        </a>
    </div>

</div>

</body>
</html>
