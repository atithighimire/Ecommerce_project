<?php
include 'connection.php';
$id = $_POST['id'];
$query = "SELECT * FROM product WHERE id='$id'";
$result = mysqli_query($conn,  $query);
$category = mysqli_fetch_array($result);


if (isset($_SESSION["shopping_cart"])) {
    $is_available = 0;
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        if ($_SESSION["shopping_cart"][$keys]['product_id'] == $_POST["product_id"]) {
            $is_available++;
            $_SESSION["shopping_cart"][$keys]['product_quantity'] = $_SESSION["shopping_cart"][$keys]['product_quantity'] + $_POST["product_quantity"];
        }
    }
    if ($is_available == 0) {
        $item_array = array(
            'product_id'               =>     $_POST["product_id"],
            'product_name'             =>     $_POST["product_name"],
            'product_price'            =>     $_POST["product_price"],
            'product_quantity'         =>     $_POST["product_quantity"]
        );
        echo json_encode($item_array);
        $_SESSION["shopping_cart"][] = $item_array;
    }
} else {
    $image = $category['image'];
    $item_array = array(
        'product_id'               =>     $category["id"],
        'product_name'             =>     $category["productName"],
        'product_price'            =>     $category["price"],
        'product_quantity'         =>     1,
        'image'            =>     base64_encode($image)
    );
    echo json_encode($item_array);
}
