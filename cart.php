<?php
session_start();
include 'connection.php';


$total_price = 0;
$total_item = 0;


if (isset($_POST['remove_code'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['remove_code'] as $key) {
            unset($_SESSION['cart'][$key]);
        }
        header("Refresh:0");
        echo "<script>alert('Your Cart has been Updated');</script>";
    }
}


if (isset($_POST['ordersubmit'])) {

    if (strlen($_SESSION['login']) == 0) {
        header('location:index.php');
    } else {
        $quantity = $_POST['quantity'];
        $pdd = $_SESSION['pid'];
        $value = array_combine($pdd, $quantity);
        foreach ($value as $qty => $val34) {
            $availabilty = mysqli_query($conn, "select * from product where id=$qty ");
            $row1 = mysqli_fetch_array($availabilty);
            if ($row1['quantity'] < 1) {
                echo "<script>alert('Out of stock');</script>";
            } else {
                mysqli_query($conn, "insert into orders(userId,productId,quantity) values('" . $_SESSION['id'] . "','$qty','$val34')");
                mysqli_query($conn, "update product set quantity=quantity-$val34 where id=$qty ");
            }
            unset($_SESSION['cart']);
            header('location:orders.php');
        }
    }
}
?>

<?php include 'navbar.php'; ?>


<!doctype html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>




</head>

<script>
    window.onload = function() {
        if (!window.location.hash) {
            window.location = window.location + '#loaded';
            window.location.reload();
        }
    }
</script>

<body>


    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">Shopping Cart</h3>
                    <p class="mb-5 text-center">
                        <span id="cartLength" class="text-info font-weight-bold"></span> items in your cart
                    </p>
                    <form name="cart" method="post">
                        <?php
                        if (!empty($_SESSION['cart'])) {
                        ?>
                            <table id="shoppingCart" class="table table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Image</th>
                                        <th style="width:20%">Product Name</th>
                                        <th style="width:10%">Price</th>
                                        <th style="width:5%">Quantity</th>
                                        <th style="width:10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $pdtid = array();
                                    $sql = "SELECT * FROM product WHERE id IN(";
                                    foreach ($_SESSION['cart'] as $id => $value) {
                                        $sql .= $id . ",";
                                    }
                                    $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
                                    $query = mysqli_query($conn, $sql);
                                    $totalprice = 0;
                                    $totalqunty = 0;

                                    ?>
                                    <?php
                                    if (!empty($query)) {
                                        while ($row = mysqli_fetch_array($query)) {
                                            $quantity = $_SESSION['cart'][$row['id']]['quantity'];
                                            $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['price'];
                                            $totalprice += $subtotal;
                                            $_SESSION['qnty'] = $totalqunty += $quantity;


                                            array_push($pdtid, $row['id']);
                                    ?>
                                            <tr class="mt-3">
                                                <td data-th="Product">
                                                    <div class="row">
                                                        <div class="col-md-3 text-left">
                                                            <img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['image']; ?>" alt="" width="200" height="200">
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-9 text-left mt-sm-2">
                                                        <h5><?php echo $row['productName'] ?></h5>
                                                    </div>
                                                </td>
                                                <td data-th="Price">$<?php echo $row['price'] ?></td>

                                                <td class="cart-product-quantity">
                                                    <?php $key =  $row['id'] ?>
                                                    <?php $availabilty = mysqli_query($conn, "select * from product where id=$key ");
                                                    $row3 = mysqli_fetch_array($availabilty); ?>
                                                    <input type="number" min="1" max="<?php echo $row3['quantity']; ?>" value="<?php echo $quantity ?>" name="quantity[<?php echo $row['id']; ?>]" class="form-control form-control-lg text-center">
                                                </td>
                                                <td class="romove-item">
                                                    <div class="text-right">

                                                        <button class="btn btn-white border-secondary bg-white btn-md mb-2" name="remove_code[]" value="<?php echo htmlentities($row['id']); ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>


                                    <?php }
                                    }
                                    $_SESSION['pid'] = $pdtid;
                                    ?>



                                </tbody>
                            </table>


                            <div class="float-right text-right">
                                <h4>Subtotal:</h4>
                                <h4 id="total">$<?php echo $_SESSION['tp'] = "$totalprice" . ".00"; ?> </h4>

                            </div>




                            <div class="row mt-4 d-flex align-items-center ">

                                <div class="col-sm-6 order-md-2 text-right">
                                    <form name="payment" method="post">
                                        <button type="submit" name="ordersubmit" class="btn btn-primary" style="margin-top: 70px; margin-left:460px">Confirm order</button>
                                    </form>
                                </div>

                                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                                </div>
                            </div>


                        <?php } else {
                            echo "Your shopping Cart is empty";
                        } ?>
                    </form>
                </div>



            </div>

            <div class="row mt-4 d-flex align-items-center ">

                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                    <a href="home.php">
                        <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                </div>
            </div>



        </div>
    </section>




    <footer class="page-footer text-center font-small mt-4 wow fadeIn">
        <hr class="my-4">
        <div class="pb-4">
            <a href="" target="_blank">
                <i class="fab fa-facebook-f mr-3"></i>
            </a>

            <a href="" target="_blank">
                <i class="fab fa-twitter mr-3"></i>
            </a>

            <a href="" target="_blank">
                <i class="fab fa-youtube mr-3"></i>
            </a>

            <a href="" target="_blank">
                <i class="fab fa-google-plus-g mr-3"></i>
            </a>
        </div>
    </footer>





    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


</body>

</html>