<?php
include 'db_config.php';

if(isset($_POST['update'])) {
    $id = $_POST['ship_id'];
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE shipment_tracking SET status='$status' WHERE id=$id");
    echo "Status Updated!";
}
?>