<?php
include("setting.php");

$info = "";

/* Handle form submission */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $n = mysqli_real_escape_string($al, $_POST['name']);
    $e = mysqli_real_escape_string($al, $_POST['email']);
    $c = mysqli_real_escape_string($al, $_POST['contact']);
    $p = sha1($_POST['pass']); // keep sha1 for compatibility

    if ($n != "" && $e != "" && $c != "" && $_POST['pass'] != "") {

        $sql = mysqli_query(
            $al,
            "INSERT INTO customers(name,email,contact,password)
             VALUES('$n','$e','$c','$p')"
        );

        if ($sql) {
            // ✅ Redirect immediately after successful registration
            header("Location: index.php");
            exit;
        } else {
            $info = "❌ Email ID Already Exists";
        }

    } else {
        $info = "⚠️ Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>VMS | Register</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="header">
    <div align="center">
        <span class="headingMain">Vacation Management Site</span>
    </div>
</div>

<br><br>

<div align="center">
    <span class="subHead"><h2>Register Here!</h2></span>
    <br>

    <form method="post">
        <div style="width:400px; background:white; padding:20px;
                    border-radius:8px; box-shadow:0 10px 25px rgba(0,0,0,.2);">

            <table cellpadding="6" cellspacing="6" align="center" class="design">
                <tr>
                    <td colspan="2" align="center" class="info">
                        <?php echo $info; ?>
                    </td>
                </tr>

                <tr>
                    <td class="labels">Name</td>
                    <td>
                        <input type="text" name="name" class="fields" required>
                    </td>
                </tr>

                <tr>
                    <td class="labels">Email</td>
                    <td>
                        <input type="email" name="email" class="fields" required>
                    </td>
                </tr>

                <tr>
                    <td class="labels">Contact</td>
                    <td>
                        <input type="text" name="contact" class="fields" required>
                    </td>
                </tr>

                <tr>
                    <td class="labels">Password</td>
                    <td>
                        <input type="password" name="pass" class="fields" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="REGISTER" class="fields">
                    </td>
                </tr>
            </table>
        </div>
    </form>

    <br>
    <a href="index.php" class="link">HOME</a>
</div>

</body>
</html>
