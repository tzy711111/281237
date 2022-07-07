<?php
$servername = "localhost";
$username = "moneymon_281237_mytutor_user";
$password = "XUZE#D=sj9-N";
$dbname = "moneymon_281237_mytutor_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>
