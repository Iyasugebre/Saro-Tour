<?php
include("setting.php");
session_start();

$info = "";

/* If already logged in */
if (isset($_SESSION['aid'])) {
    header("Location: ahome.php");
    exit;
}

/* Handle form submission */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST['aid']) && !empty($_POST['pass'])) {

        $aid = mysqli_real_escape_string($al, $_POST['aid']);
        $pass = mysqli_real_escape_string($al, $_POST['pass']);
        $hash = sha1($pass);

        $query = mysqli_query(
            $al,
            "SELECT * FROM admin WHERE aid='$aid' AND password='$hash'"
        );

        if ($query && mysqli_num_rows($query) === 1) {
            $_SESSION['aid'] = $aid;
            header("Location: ahome.php");
            exit;
        } else {
            $info = "Incorrect Admin ID or Password";
        }

    } else {
        $info = "Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | VMS</title>

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
    display: flex;
    flex-direction: column;
    align-items: center;
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

/* LOGIN CARD */
.login-box {
    margin-top: 90px;
    width: 380px;
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

/* TITLE */
.login-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #222;
}

/* MESSAGE */
.info {
    text-align: center;
    margin-bottom: 15px;
    font-size: 14px;
    color: #d63031;
}

/* FORM */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
}

.form-group input:focus {
    border-color: #4ca1af;
}

/* BUTTON */
.login-btn {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: #4ca1af;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.login-btn:hover {
    background: #3b8d99;
}

/* BACK LINK */
.back-link {
    display: block;
    text-align: center;
    margin-top: 18px;
    color: #4ca1af;
    text-decoration: none;
    font-weight: 500;
}

.back-link:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div id="header">
    <span class="headingMain">Vacation Management Site</span>
</div>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if (!empty($info)) { ?>
        <div class="info"><?php echo $info; ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label>Admin ID</label>
            <input type="text" name="aid" placeholder="Enter Admin ID" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" placeholder="Enter Password" required>
        </div>

        <button type="submit" class="login-btn">Login</button>
    </form>

    <a href="index.php" class="back-link">← Back to Home</a>
</div>

</body>
</html>
