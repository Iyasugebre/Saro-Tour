<?php
include("setting.php");
session_start();

/* Protect page */
if (!isset($_SESSION['aid'])) {
    header("Location: admin.php");
    exit;
}

/* Validate GET parameter */
if (!isset($_GET['a']) || !is_numeric($_GET['a'])) {
    header("Location: orders.php");
    exit;
}

$bookingId = (int) $_GET['a'];

/* Update booking status safely */
$sql = mysqli_query(
    $al,
    "UPDATE bookings SET status='1' WHERE id='$bookingId'"
);

/* Redirect back */
header("Location: orders.php");
exit;
?>
