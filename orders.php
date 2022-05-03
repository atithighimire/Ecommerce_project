<?php
session_start();
error_reporting(0);
include 'connection.php';


if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {

?>

    <?php include 'navbar.php'; ?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">



    </head>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 200 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>




    <body>


        <div class="container-xl" style="margin-bottom: 100px;">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>My <b>Orders</b></h2>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "select * from orders";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th> Id</th>
                                <th>Image</th>
                                <th> Product Name</th>
                                <th>Quantity</th>
                                <th>Price per unit</th>
                                <th>Total</th>
                                <th>Order Date</th>
                                <th>Track</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $id = $_SESSION['id'];
                            $query = mysqli_query($conn, "select product.image as pimg1,
                            product.productName as pname,
                            product.id as proid,
                            orders.productId as opid,
                            orders.quantity as qty,
                            product.price as pprice,
                            orders.orderDate as odate,
                            orders.orderId as orderid from orders join product on 
                            orders.productId=product.id
                            where orders.userId= $id  Order by orders.orderDate DESC");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td class="cart-image">
                                        <a class="entry-thumbnail" href="detail.html">
                                            <img src="admin/productimages/<?php echo $row['proid']; ?>/<?php echo $row['pimg1']; ?>" alt="" width="84" height="146">
                                        </a>
                                    </td>

                                    <td><?= $row['pname']; ?></td>
                                    <td><?php echo $qty = $row['qty']; ?>
                                    </td>
                                    <td>$<?php echo $price = $row['pprice']; ?> </td>
                                    <td>$<?php echo ($qty * $price) ?></td>
                                    <td><?= $row['odate']; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']); ?>');" title="Track order">
                                            Track
                                    </td>
                                </tr>

                            <?php $cnt = $cnt + 1;
                            } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>



    </body>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>



    </html>


<?php }









?>