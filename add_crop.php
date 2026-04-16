<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // HTML name attribute onujayi data dhora
    $crop_name = $_POST['crop_name'];
    $planting_date = $_POST['planting_date'];
    $harvest_date = $_POST['harvest_date'];
    $shelf_life = $_POST['shelf_life'];
    $packaging = $_POST['packaging'];

    // Database table-er column name: product_name, start_date, end_date, quantity, unit
    // Eikhane quantity-r jaygay amra shelf_life ebong unit-er jaygay packaging pathachhi
    $sql = "INSERT INTO products (product_name, start_date, end_date, quantity, unit) 
            VALUES ('$crop_name', '$planting_date', '$harvest_date', '$shelf_life', '$packaging')";

    if (mysqli_query($conn, $sql)) {
        // Shofol hole Dashboard-e niye jabe
        header("Location: agriculture_dashboard.php");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>