<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$name = addslashes($_POST['name']);
$phoneNum = addslashes($_POST['phoneNum']);
$email = $_POST['email'];
$address = $_POST['address'];
$password = sha1($_POST['password']);
$base64image = $_POST['image'];

$sqlinsert = "INSERT INTO `tbl_users`(`user_name`, `user_phoneNum`, `user_email`, `user_address`, `user_password`) 
VALUES ('$name','$phoneNum','$email','$address','$password')";
if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $filename = mysqli_insert_id($conn);
    $decoded_string = base64_decode($base64image);
    $path = '../assets/users/' . $filename . '.jpg';
    $is_written = file_put_contents($path, $decoded_string);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>