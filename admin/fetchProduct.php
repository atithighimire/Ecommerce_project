<?php

include 'connection.php';
$id = $_POST['id'];
$query = "SELECT * FROM product WHERE id='$id'";
$result = mysqli_query($conn,  $query);
$category = mysqli_fetch_array($result);

if ($category) {
    echo json_encode($category);
} else {
    echo "Error:" . $sql ."". mysqli_error(($conn));
}
