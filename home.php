<?php 
include("setting.php");
session_start();

// Redirect if not logged in
if(!isset($_SESSION['email'])) {
    header("location:index.php");
    exit;
}

$email = $_SESSION['email'];
$a = mysqli_query($al, "SELECT * FROM customers WHERE email='$email'");
$b = mysqli_fetch_array($a);
$name = $b['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard - VMS</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
}

#header {
    background: linear-gradient(to right, #3f9e2c, #dfdcdc);
    padding: 20px;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
}

.headingMain {
    font-size: 36px;
    color: #181717;
    text-shadow: 1px 1px 1px #161616;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 30px auto;
    text-align: center;
}

.subHead {
    font-size: 25px;
    color: #181717;
    margin-bottom: 30px;
}

.cont {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    flex: 1 1 200px;
    min-width: 180px;
    background-color: #fff;
    border: 2px solid darkcyan;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card a {
    text-decoration: none;
    color: #fff;
    font-size: 22px;
    display: block;
    padding: 15px 0;
    border-radius: 8px;
    background-color: darkcyan;
    transition: background-color 0.2s;
}

.card a:hover {
    background-color: #2b7a7a;
    transform: scale(1.05);
}

@media (max-width: 600px) {
    .cont {
        flex-direction: column;
        align-items: center;
    }
}
</style>
</head>

<body>

<div id="header">
    <div class="headingMain">Vacation Management Site</div>
</div>

<div class="container">
    <div class="subHead">Welcome, <?php echo htmlspecialchars($name); ?></div>

    <div class="cont">
        <div class="card">
            <a href="book.php">♦ Book Package</a>
        </div>
        <div class="card">
            <a href="changePassword.php">♦ Change Password</a>
        </div>
        <div class="card">
            <a href="logout.php">♦ Logout</a>
        </div>
    </div>
</div>

</body>
</html>
