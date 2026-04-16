<?php
include 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $v_no = $_POST['vehicle_no'];
    $route = $_POST['route'];

    $sql = "INSERT INTO transport_schedule (vehicle_no, route) VALUES ('$v_no', '$route')";
    
    if(mysqli_query($conn, $sql)) {
        echo "Transport schedule updated!";
    }
}
?>