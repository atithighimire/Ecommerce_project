<?php
session_start();
error_reporting(0);
include 'connection.php';


if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {

    $success = '';

    if (isset($_POST['submit'])) {
        $categoryName = $_POST['categoryName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $productName        = $_POST['productName'];
        $productimage1 = $_FILES["productimage1"]["name"];
        $query = mysqli_query($conn, "select max(id) as id from product");
        $result = mysqli_fetch_array($query);
        $productid = $result['id'] ;
        $dir = "productimages/$productid";
        if (!is_dir($dir)) {
            mkdir("productimages/" . $productid);
        }
        move_uploaded_file($_FILES["productimage1"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage1"]["name"]);
        $sql = "insert into product(categoryName,description,productName,price,image,quantity) values('$categoryName','$description','$productName','$price','$productimage1','$availability')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product Added');</script>";
            header("Refresh:0");
            exit();
        } else {
            echo "Error: " . $sql . " " . mysqli_error($conn);
        }
    }

    // 
    if (isset($_POST['edit'])) {
        $categoryName = $_POST['categoryName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $productName = $_POST['productName'];
        $id = $_POST['id'];

        $sql = "update product set categoryName ='$categoryName' , description='$description', price='$price' , quantity ='$availability', productName='$productName'  where id='$id' ";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product Edited');</script>";
            header("Refresh:0");
            exit();
        } else {
            echo "Error: " . $sql . " " . mysqli_error($conn);
        }
    }


    if (isset($_POST['deleteItem'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM product WHERE id = '$id' ";
        mysqli_query($conn, $sql);
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product Deleted');</script>";
            header("Refresh:0");
            exit();
        } else {
            echo "Error: " . $sql . " " . mysqli_error($conn);
        }
    }



?>

    <?php include('include/../navbar.php'); ?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    </head>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();

        });

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "fetchProduct.php",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    $('#categoryName').val(data.categoryName);
                    $('#description').val(data.description);
                    $('#price').val(data.price);
                    $('#productName').val(data.productName);
                    $('#availability').val(data.quantity);
                    $('#id').val(data.id);
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            $('#deleteId').val(id);
        });
    </script>




    <body>


        <div class="container-xl" style="margin-bottom: 100px;">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Manage <b>Product</b></h2>
                            </div>
                            <div class="col-sm-6">
                                <a href="#addProductModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Product</span></a>
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
                                <th> Id</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th> Product Availability </th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = "select * from product";
                            $result = mysqli_query($conn, $query);



                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['categoryName']; ?></td>
                                    <td><?= $row['productName']; ?></td>
                                    <td><?= $row['price']; ?></td>
                                    <td><?= $row['description']; ?></td>
                                    <td><?= $row['quantity']; ?></td>
                                    <td>

                                        <a class="edit" name="edit" data-target="#editProductModal" id="edit" data-id="<?php echo $row["id"]; ?>" data-toggle="modal">
                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="#deleteProduct" class="delete" data-toggle="modal" id="delete" data-id="<?php echo $row["id"]; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div id="addProductModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Category Name</label>
                                <select name="categoryName" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php $query = mysqli_query($conn, "select * from category");
                                    while ($row = mysqli_fetch_array($query)) { ?>

                                        <option name="<?php echo $row['categoryName']; ?>" value="<?php echo $row['id']; ?>"><?php echo $row['categoryName']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="productName" required>
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>

                            <div class="form-group">
                                <label>Availability</label>
                                <input type="number" class="form-control" name="availability" required>
                            </div>

                            <div class="form-group">
                                <label>Description </label>
                                <textarea class="form-control" required name="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Upload Image </label>

                                <input type="file" name="productimage1" id="productimage1" value="" class="span8 tip" required>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Add" name="submit" id="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div id="editProductModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" id="id" name="id" value="">


                            <div class="form-group">
                                <label>Category Name</label>
                                <select name="categoryName" id="categoryName" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php $query = mysqli_query($conn, "select * from category");
                                    while ($row = mysqli_fetch_array($query)) { ?>

                                        <option name="<?php echo $row['categoryName']; ?>" value="<?php echo $row['id']; ?>"><?php echo $row['categoryName']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input class="form-control" name="productName" id="productName" required>
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" id="price" required>
                            </div>

                            <div class="form-group">
                                <label>Availability</label>
                                <input type="text" class="form-control" name="availability" id="availability" required>
                            </div>

                            <div class="form-group">
                                <label>Description </label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-info" value="Save" name="edit">
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div id="deleteProduct" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete these Records?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="deleteId" name="id" value="">

                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-danger" value="Delete" name="deleteItem">
                        </div>
                    </form>
                </div>
            </div>
        </div>







    </body>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    </html>

    <?php include 'footer.php'; ?>

<?php }









?>