<?php
include("setting.php");
session_start();

// Redirect if not logged in
if(!isset($_SESSION['aid'])) {
    header("location:admin.php");
    exit;
}

$info = "";
$aid = $_SESSION['aid'];
$a = mysqli_query($al, "SELECT * FROM admin WHERE aid='$aid'");
$b = mysqli_fetch_array($a);
$name = $b['name'];

// Handle form submission safely
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $n  = mysqli_real_escape_string($al, $_POST['name']);
    $am = mysqli_real_escape_string($al, $_POST['amount']);

    if ($n != "" && $am != "") {
        $sql = mysqli_query($al, "INSERT INTO package(name,amount) VALUES('$n','$am')");
        if ($sql) {
            $info = "✅ Package successfully added!";
        } else {
            $info = "⚠️ Package name might already exist!";
        }
    } else {
        $info = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Packages - VMS</title>
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
}

.card {
    background-color: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.card h2 {
    margin-top: 0;
    color: #333;
    text-align: center;
}

.fields {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button, input[type="submit"] {
    background-color: #3f9e2c;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover, input[type="submit"]:hover {
    background-color: #2f7a20;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: center;
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #3f9e2c;
    color: white;
}

.link {
    color: #e74c3c;
    text-decoration: none;
}

.link:hover {
    text-decoration: underline;
}

.info {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
    color: green;
}
</style>
</head>
<body>

<div id="header">
    <span class="headingMain">Vacation Management Site</span>
</div>

<div class="container">

    <div class="card">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?> - Manage Packages</h2>
        <?php if($info) echo '<div class="info">'.$info.'</div>'; ?>

        <form method="post" action="">
            <input type="text" name="name" class="fields" placeholder="Package Name" required autocomplete="off">
            <input type="number" name="amount" class="fields" placeholder="Amount per Member" required min="1">
            <input type="submit" value="Add Package">
        </form>
    </div>

    <div class="card">
        <h2>Current Packages</h2>
        <table>
            <tr>
                <th>Sr.No.</th>
                <th>Package Name</th>
                <th>Amount Per Member</th>
                <th>Delete</th>
            </tr>
            <?php
            $u = 1;
            $x = mysqli_query($al, "SELECT * FROM package");
            while($y = mysqli_fetch_array($x)) {
                echo '<tr>';
                echo '<td>'.$u++.'</td>';
                echo '<td>'.htmlspecialchars($y['name']).'</td>';
                echo '<td>Birr '.$y['amount'].'</td>';
                echo '<td><a class="link" href="deleteH.php?del='.$y['id'].'" onclick="return confirm(\'Are you sure you want to delete this package?\');">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>

    <div style="text-align:center;">
        <a href="ahome.php"><button>Back to Home</button></a>
    </div>

</div>

</body>
</html>
