<?php
include 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $s_name = $_POST['supervisor_name'];
    $task = $_POST['task_details'];

    // Database table-er column name onujayi query:
    $sql = "INSERT INTO tasks (supervisor_name, task) VALUES ('$s_name', '$task')";
    
    if(mysqli_query($conn, $sql)) {
        echo "Task assigned successfully!";
    }
}
?>