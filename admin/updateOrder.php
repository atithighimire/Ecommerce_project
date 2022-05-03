<?php

include 'connection.php';
$id = $_POST['id'];
$status = $_POST['status'];


// $sql = "update orders set orderStatus =$status , where orderId=$id ";

$sql = "UPDATE orders
SET orderStatus='$status'
WHERE orderId='$id'";


if (mysqli_query($conn, $sql)) {
    echo 'success';
} else {
    echo "Error: " . $sql . " " . mysqli_error($conn);
}
