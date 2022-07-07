<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

include_once("dbconnect.php");
$subject_id = $_POST['subject_id'];
$email = $_POST['email'];
$cartqty = "1";
$carttotal = 0;

$sqlchecksubj = "SELECT * FROM tbl_subjects where subject_id = '$subject_id'";
$resultsubj = $conn->query($sqlchecksubj);
$num_of_subj = $resultsubj->num_rows;
if ($num_of_subj>1){
    $response = array('status' => 'failed', 'data' => null);
	sendJsonResponse($response);
	return;
}

$sqlinsert = "SELECT * FROM tbl_carts WHERE user_email = '$email' AND subject_id = '$subject_id' AND cart_status IS NULL";
$checkSubjInCart = $sqlinsert;
$result = $conn->query($sqlinsert);
$number_of_result = $result->num_rows;

if ($number_of_result == 0) {
    $addcart = "INSERT INTO `tbl_carts`(`user_email`, `subject_id`, `cart_qty`) VALUES ('$email','$subject_id','$cartqty')";
    if ($conn->query($addcart) === TRUE) {

	}else{
	    $response = array('status' => 'failed', 'data' => null);
		sendJsonResponse($response);
		return;
    }
} 
else 
{
    if($checkSubjInCart == $sqlinsert){
    $response = array('status' => 'duplicated', 'data' => null);
    sendJsonResponse($response);
    return;
    }
}

$sqlgetqty = "SELECT * FROM tbl_carts WHERE user_email = '$email' AND cart_status IS NULL";
$result = $conn->query($sqlgetqty);
$number_of_result = $result->num_rows;
$carttotal = 0;
while($row = $result->fetch_assoc()) {
    $carttotal = $row['cart_qty'] + $carttotal;
}
$mycart = array();
$mycart['carttotal'] =$carttotal;
$response = array('status' => 'success', 'data' => $mycart);
sendJsonResponse($response);

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>





