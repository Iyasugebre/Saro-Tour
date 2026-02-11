<?php
include("setting.php");

/* Function to safely delete by table and id */
function safeDelete($conn, $table, $id, $redirect) {
    $id = intval($id); // sanitize as integer
    if($id > 0) {
        mysqli_query($conn, "DELETE FROM `$table` WHERE id='$id'");
    }
    header("Location: $redirect");
    exit;
}

/* Check which delete action is requested */
if(isset($_GET['del'])) {
    safeDelete($al, "package", $_GET['del'], "holiday.php");
} elseif(isset($_GET['d'])) {
    safeDelete($al, "bookings", $_GET['d'], "book.php");
} elseif(isset($_GET['dd'])) {
    safeDelete($al, "bookings", $_GET['dd'], "orders.php");
} else {
    // No valid parameter provided
    echo "<p>No valid delete parameter provided.</p>";
    echo "<a href='javascript:history.back()'>Go Back</a>";
    exit;
}
