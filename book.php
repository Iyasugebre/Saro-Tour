<?php
include("setting.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$email = $_SESSION['email'];
$info = "";

/* Get user info */
$userQ = mysqli_query($al, "SELECT * FROM customers WHERE email='$email'");
$user = mysqli_fetch_assoc($userQ);
$name = $user['name'] ?? "";

/* Handle booking form */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['pack'] ?? '';
    $j  = $_POST['j'] ?? '';
    $m  = $_POST['mem'] ?? '';
    $d  = $_POST['d'] ?? '';

    if ($id && $j && $m && $d) {

        $p = mysqli_query($al, "SELECT * FROM package WHERE id='$id'");
        if ($p && mysqli_num_rows($p) === 1) {

            $q = mysqli_fetch_assoc($p);
            $rate = $q['amount'];
            $pack = $q['name'];

            $amount = $m * $rate;

            $sql = mysqli_query(
                $al,
                "INSERT INTO bookings(email,package,members,journey,amount,date,status)
                 VALUES('$email','$pack','$m','$j','$amount','$d','0')"
            );

            if ($sql) {
                $info = "✅ Booking successful! Total amount: <strong>Birr $amount</strong>";
            } else {
                $info = "❌ Booking failed. Please try again.";
            }
        }
    } else {
        $info = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>VMS | Book Package</title>

<style>
body{
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg,#6fb1b7,#b9e3e8);
    margin:0;
}

#header{
    background:#1e293b;
    padding:20px;
    color:white;
    text-align:center;
}

.container{
    max-width:900px;
    margin:40px auto;
}

.card{
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    margin-bottom:40px;
}

h2{
    text-align:center;
    margin-bottom:20px;
}

.info{
    text-align:center;
    margin-bottom:15px;
    font-weight:600;
}

form select, form input{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    margin-bottom:15px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#2563eb;
    color:white;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

th{
    background:#1e293b;
    color:white;
}

.status-ok{
    color:green;
    font-weight:bold;
}

.status-pending{
    color:orange;
    font-weight:bold;
}

a.link{
    color:#2563eb;
    text-decoration:none;
    font-weight:600;
}

a.link:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div id="header">
    <h1>Vacation Management Site</h1>
</div>

<div class="container">

    <div class="card">
        <h2>Book Package</h2>
        <div class="info"><?php echo $info; ?></div>

        <form method="post">
            <select name="pack" required>
                <option value="" disabled selected>-- Select Package --</option>
                <?php
                $x = mysqli_query($al, "SELECT * FROM package");
                while ($y = mysqli_fetch_assoc($x)) {
                    echo "<option value='{$y['id']}'>Birr {$y['amount']} - {$y['name']}</option>";
                }
                ?>
            </select>

            <select name="j" required>
                <option value="" disabled selected>-- Journey By --</option>
                <option>Air</option>
                <option>Train</option>
                <option>Travels (Bus)</option>
            </select>

            <input type="number" name="mem" min="1" placeholder="Number of Members" required>
            <input type="date" name="d" required>

            <button type="submit">BOOK NOW</button>
        </form>
    </div>

    <div class="card">
        <h2>Your Bookings</h2>

        <table>
            <tr>
                <th>#</th>
                <th>Package</th>
                <th>Journey</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>

            <?php
            $u = 1;
            $x = mysqli_query($al, "SELECT * FROM bookings WHERE email='$email'");
            while ($y = mysqli_fetch_assoc($x)) {
            ?>
            <tr>
                <td><?php echo $u++; ?></td>
                <td><?php echo $y['package']; ?></td>
                <td><?php echo $y['journey']; ?></td>
                <td>Birr <?php echo $y['amount']; ?></td>
                <td><?php echo $y['date']; ?></td>
                <td class="<?php echo $y['status'] ? 'status-ok' : 'status-pending'; ?>">
                    <?php echo $y['status'] ? 'Approved' : 'Pending'; ?>
                </td>
                <td><a class="link" href="deleteH.php?d=<?php echo $y['id']; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </table>

        <br>
        <a href="home.php" class="link">← Back to Home</a>
    </div>

</div>

</body>
</html>
