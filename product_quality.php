<?php
include 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_id = $_POST['product_id'];
    $grade = $_POST['grade'];
    
    $sql = "INSERT INTO product_quality (product_id, grade) VALUES ('$p_id', '$grade')";
    mysqli_query($conn, $sql);
    echo "Quality Record Saved!";
}
?>