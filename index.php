<?php
include("setting.php");
session_start();

/* Redirect if already logged in */
if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit;
}

/* Handle login */
$info = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['pass'] ?? '';

    if ($email && $pass) {
        $e  = mysqli_real_escape_string($al, $email);
        $pp = sha1($pass);

        $sql = mysqli_query(
            $al,
            "SELECT * FROM customers WHERE email='$e' AND password='$pp'"
        );

        if ($sql && mysqli_num_rows($sql) === 1) {
            $_SESSION['email'] = $e;
            header("Location: home.php");
            exit;
        } else {
            $info = "❌ Incorrect Email or Password";
        }
    } else {
        $info = "⚠️ Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Saro Tour | Explore Ethiopia</title>

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI",sans-serif
}

/* BODY WITH IMAGE BACKGROUND */
body{
    background:
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
        url("images/bg.jpg") no-repeat center center fixed;
    background-size:cover;
    color:white;
}

/* HEADER */
header{
    background:#020617;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,.4);
}
header h1{font-size:28px}

/* HERO */
.hero{
    min-height:75vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px;
}
.hero-box{
    display:flex;
    max-width:1200px;
    width:100%;
    gap:40px;
}

/* HERO TEXT */
.hero-text{
    flex:1;
}
.hero-text h2{
    font-size:48px;
    margin-bottom:15px;
}
.hero-text p{
    font-size:18px;
    line-height:1.7;
}

/* LOGIN CARD */
.login-card{
    width:380px;
    background:rgba(255,255,255,0.15);
    backdrop-filter: blur(14px);
    padding:30px;
    border-radius:20px;
    box-shadow:0 25px 50px rgba(0,0,0,.3);
}
.login-card h3{
    text-align:center;
    margin-bottom:15px;
}
.login-card .info{
    text-align:center;
    margin-bottom:12px;
    font-weight:600;
    color:#fecaca;
}
.login-card input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    margin-bottom:14px;
}
.login-card button{
    width:100%;
    padding:12px;
    border:none;
    background:#22c55e;
    color:white;
    font-size:16px;
    border-radius:10px;
    cursor:pointer;
}
.login-card button:hover{background:#16a34a}

/* PACKAGES SECTION */
.section{
    background:#f8fafc;
    padding:80px 40px;
    color:#0f172a;
}
.section h2{
    text-align:center;
    font-size:40px;
    margin-bottom:50px;
}

/* PACKAGES GRID */
.packages{
    max-width:1400px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(360px,1fr));
    gap:35px;
}

/* CARD */
.card{
    background:white;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 20px 40px rgba(0,0,0,.18);
    transition:all .4s ease;
}
.card:hover{
    transform:translateY(-12px);
    box-shadow:0 30px 60px rgba(0,0,0,.25);
}

.card img{
    width:100%;
    height:320px;
    object-fit:cover;
    transition:transform .5s ease;
}
.card:hover img{
    transform:scale(1.08);
}

.card .body{
    padding:22px;
    text-align:center;
}
.card h3{
    font-size:22px;
    margin-bottom:10px;
}
.card p{
    font-size:16px;
    margin-bottom:15px;
    color:#475569;
}
.card button{
    width:100%;
    padding:12px;
    background:#2563eb;
    border:none;
    color:white;
    font-size:16px;
    border-radius:10px;
    cursor:pointer;
}
.card button:hover{
    background:#1d4ed8;
}

/* FOOTER */
footer{
    background:#020617;
    color:white;
    text-align:center;
    padding:40px;
}

.social-icons{
    margin-top:20px;
}

.social-icons a{
    text-decoration:none;
    color:white;
    font-size:30px;
    margin:0 15px;
    transition:0.3s ease;
}

.social-icons a:hover{
    transform:scale(1.2);
}

/* Brand Colors on Hover */
.fa-telegram:hover{ color:#229ED9; }
.fa-linkedin:hover{ color:#0077B5; }
.fa-github:hover{ color:#ffffff; }

</style>
</head>

<body>

<header>
    <h1>Saro Tour</h1>
</header>

<section class="hero">
    <div class="hero-box">

        <div class="hero-text">
            <h2>Discover Ethiopia 🇪🇹</h2>
            <p>
                Explore luxury resorts, natural wonders, and unforgettable
                experiences. Book your vacation easily and securely.
            </p>
        </div>

        <div class="login-card">
            <h3>User Login</h3>
            <div class="info"><?php echo $info; ?></div>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <a href="newReg.php" style="color:white;">New user? Register</a>
        </div>

    </div>
</section>

<section class="section">
<h2>Popular Packages</h2>
<div class="packages">
<?php
$packages=[
["images/haile.jpg","Haile Resort","Birr 3000 - 5999"],
["images/kuriftu.jpg","Kuriftu Resort","Birr 4500 - 8000"],
["images/sodere.jpg","Sodere Springs","Birr 1500 - 8500"],
["images/grassland.jpg","Simien Mountains","Birr 8500 - 10000"],
["images/lalibela.jpg","Lalibela","Birr 8500 - 12000"],
["images/abay.jpg","Abay River","Birr 11500 - 15000"]
];
foreach($packages as $p){
?>
<div class="card">
    <img src="<?php echo $p[0]; ?>">
    <div class="body">
        <h3><?php echo $p[1]; ?></h3>
        <p><?php echo $p[2]; ?></p>
        <button>Book Now</button>
    </div>
</div>
<?php } ?>
</div>
</section>

<footer>
    <p><strong>Eyasu Gebre</strong></p>
    <p>Email: gebreeyasu52@gmail.com</p>

    <div class="social-icons">
        <a href="https://t.me/Joshhoper" target="_blank">
            <i class="fab fa-telegram"></i>
        </a>

        <a href="https://www.linkedin.com/in/eyasu-gebre" target="_blank">
            <i class="fab fa-linkedin"></i>
        </a>

        <a href="https://github.com/" target="_blank">
            <i class="fab fa-github"></i>
        </a>
    </div>

    <p style="margin-top:20px;">© <?php echo date("Y"); ?> Saro Tour. All Rights Reserved.</p>
</footer>

</body>
</html>
