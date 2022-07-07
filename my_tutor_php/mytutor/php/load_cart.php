<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$email = $_POST['email'];
$sqlloadcart = "SELECT tbl_carts.cart_id, tbl_carts.subject_id, tbl_carts.cart_qty, 
tbl_subjects.subject_name, tbl_subjects.subject_price, tbl_subjects.subject_sessions, tbl_subjects.subject_rating
FROM tbl_carts INNER JOIN tbl_subjects 
ON tbl_carts.subject_id = tbl_subjects.subject_id
WHERE tbl_carts.user_email = '$email' AND tbl_carts.cart_status IS NULL";
$result = $conn->query($sqlloadcart);
$number_of_result = $result->num_rows;
if ($result->num_rows > 0) {
    $total_payable = 0;
    $carts["cart"] = array();
    while ($rows = $result->fetch_assoc()) {
        $cartlist = array();
        $cartlist['cart_id'] = $rows['cart_id'];
        $cartlist['subject_name'] = $rows['subject_name'];
        $subjprice = $rows['subject_price'];
        $cartlist['price'] = number_format((float)$subjprice, 2, '.', '');
        $cartlist['cart_qty'] = $rows['cart_qty'];
        $cartlist['subject_id'] = $rows['subject_id'];
        $total_payable = $total_payable + $price;
        $cartlist['subject_sessions'] = $rows['subject_sessions'];
        $cartlist['subject_rating'] = $rows['subject_rating'];
        $cartlist['pricetotal'] = number_format((float)$subjprice, 2, '.', ''); 
        array_push($carts["cart"],$cartlist);
    }
    $response = array('status' => 'success', 'data' => $carts, 'total' => $total_payable);
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