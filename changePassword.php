<?php
include("setting.php");
session_start();

$info = "";

/* Check if user is logged in */
if(!isset($_SESSION['email'])) {
    header("location:index.php");
    exit;
}

$email = $_SESSION['email'];
$result = mysqli_query($al, "SELECT * FROM customers WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

$name = $user['name'];
$pass = $user['password']; // stored hashed password (SHA1)

/* Handle form submission */
if($_SERVER["REQUEST_METHOD"] === "POST") {

    $old = sha1($_POST['old'] ?? '');
    $p1  = sha1($_POST['p1'] ?? '');
    $p2  = sha1($_POST['p2'] ?? '');

    if(!$old || !$p1 || !$p2){
        $info = "⚠️ Please fill all fields";
    } elseif($old !== $pass) {
        $info = "❌ Incorrect Old Password";
    } elseif($p1 !== $p2) {
        $info = "❌ New Passwords Did Not Match";
    } else {
        mysqli_query($al, "UPDATE customers SET password='$p2' WHERE email='$email'");
        $info = "✅ Successfully Changed Your Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>VMS | Change Password</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI", sans-serif; }

body {
    background: linear-gradient(135deg,#6fb1b7,#d6f1f4);
    min-height:100vh;
}

#header {
    background:#1e293b;
    color:white;
    padding:20px;
    text-align:center;
    font-size:28px;
    font-weight:bold;
}

.container {
    max-width:500px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.container h2 {
    text-align:center;
    margin-bottom:20px;
}

.fields {
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    background:#16a34a;
    color:white;
    font-size:16px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

button:hover {
    background:#15803d;
}

.info {
    text-align:center;
    font-weight:600;
    margin-bottom:15px;
    color:#dc2626;
}

#message {
    display:none;
    background:#f1f1f1;
    padding:15px;
    border-radius:8px;
    margin-top:10px;
    font-size:13px;
}

#message p {
    padding:5px 0;
}

.valid { color: green; }
.valid:before { content:"✔ "; }

.invalid { color: red; }
.invalid:before { content:"✖ "; }

.link-home {
    display:block;
    text-align:center;
    margin-top:20px;
    text-decoration:none;
    font-weight:bold;
    color:#2563eb;
}

.link-home:hover {
    text-decoration:underline;
}
</style>
</head>
<body>

<div id="header">Vacation Management Site</div>

<div class="container">
    <h2>Change Password</h2>
    <div class="info"><?php echo $info;?></div>
    <form method="post">
        <input type="password" name="old" class="fields" placeholder="Enter Old Password" required>
        <input type="password" name="p1" id="password" class="fields" placeholder="Enter New Password" 
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
            title="Must contain at least 1 number, 1 uppercase, 1 lowercase, min 8 chars" required>
        <input type="password" name="p2" class="fields" placeholder="Re-Type New Password" required>
        <input type="checkbox" onclick="togglePassword()"> Show Password
        <button type="submit">Change Password</button>
    </form>

    <div id="message">
        <p id="letter" class="invalid">At least <b>1 lowercase</b> letter</p>
        <p id="capital" class="invalid">At least <b>1 uppercase</b> letter</p>
        <p id="number" class="invalid">At least <b>1 number</b></p>
        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
    </div>

    <a href="home.php" class="link-home">🏠 Back to Home</a>
</div>

<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

myInput.onfocus = function() { document.getElementById("message").style.display = "block"; }
myInput.onblur  = function() { document.getElementById("message").style.display = "none"; }

myInput.onkeyup = function() {
  var lowerCaseLetters = /[a-z]/g;
  letter.className = myInput.value.match(lowerCaseLetters) ? "valid" : "invalid";

  var upperCaseLetters = /[A-Z]/g;
  capital.className = myInput.value.match(upperCaseLetters) ? "valid" : "invalid";

  var numbers = /[0-9]/g;
  number.className = myInput.value.match(numbers) ? "valid" : "invalid";

  length.className = myInput.value.length >= 8 ? "valid" : "invalid";
}

function togglePassword() {
    var x = document.getElementById("password");
    x.type = x.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
