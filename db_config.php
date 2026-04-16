<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "agriculture_db";


$conn = new mysqli($servername, $username , $password, $bdname);

if ($conn-> connect_error){
     die("Connection failed:". $conn->connect_error);
}
?>