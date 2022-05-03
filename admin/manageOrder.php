<?php
session_start();
error_reporting(0);
include 'connection.php';


if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {


?>

    <?php include('include/../navbar.php'); ?>
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

        function getValue(selectObject, id) {

            $.ajax({
                type: "POST",
                url: "updateOrder.php",
                data: {

                    id: id,
                    status: selectObject.value
                },
                dataType: 'text',
                success: function(data) {
                    if (data == 'success') {
                        alert('Order Status Changed')
                        window.location.reload();
                    } else {
                        alert('Error: Order Status Couldnot be Changed')
                        window.location.reload();
                    }
                    console.log(data)
                }
            });



        }
    </script>




    <body>


        <div class="container-xl" style="margin-bottom: 100px;">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Manage <b>Orders</b></h2>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "select * from product";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th> Name</th>
                                <th>Contact Number</th>
                                <th>Product </th>
                                <th>Quantity</th>
                                <th>Amount</th>

                                <th>Availability</th>

                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $status = 'null';
                            $sql = "select users.name as username,users.email as useremail,users.contactno as usercontact,product.productName as productname,orders.quantity as quantity,orders.orderDate as orderdate, orders.orderStatus as orderStatus,product.price as productprice,orders.orderId as id  from orders join users on  orders.userId=users.id join product on product.id=orders.productId";
                            $result =  mysqli_query($conn, $sql) or die(mysqli_error($conn));
                            $cnt = 1;

                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($row['username']); ?></td>
                                    <td><?php echo htmlentities($row['usercontact']); ?></td>
                                    <td><?php echo htmlentities($row['productname']); ?></td>
                                    <td><?php echo htmlentities($row['quantity']); ?></td>
                                    <td>$<?php echo htmlentities($row['quantity'] * $row['productprice']); ?></td>
                                    <td><?php
                                        if ($row['quantity'] == 0) {
                                            echo '<span class="label label-danger" style="background-color: red ; color:white; ">Out of stock !</span>';
                                        } else {
                                            echo '<span class="label label-success" style="background-color: green; color:white; ">In stock !</span>';
                                        }
                                        ?></td>
                                    <td><?php echo htmlentities($row['orderdate']); ?></td>

                                    <td><?php if ($row['orderStatus'] == null) {
                                            echo htmlentities('Not Processed');
                                        } else {
                                            echo htmlentities($row['orderStatus']);
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <div class="form-group" style="width: 155px;">

                                            <select class="form-control" onchange="getValue(this,<?php echo $row['id'] ?>)  ">

                                                <option value="">Change Status </option>
                                                <option value="null">Not Processed</option>
                                                <option value="inProcess">In Process</option>
                                                <option value="delivered">delivered</option>
                                            </select>
                                        </div>
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

    <!-- <?php include 'footer.php'; ?> -->

    </html>


<?php }









?>