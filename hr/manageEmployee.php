<?php
session_start();
// error_reporting(0);
include 'connection.php';


if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {

    $success = '';

    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $contactno = $_POST['contactno'];
        $salary = $_POST['salary'];
        $address = $_POST['address'];
        $sql = "INSERT INTO employee (employeeName,email,number,salary,address) VALUES (?, ?, ?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fullname,$email, $contactno, $salary, $address);
        if ($stmt->execute()) {
              echo "<script type='text/javascript'>
           alert('Employee has been added !!!');
            window.location='manageEmployee.php';
        </script>";
            exit();
        } else {
             echo "<script>alert('Not register something went worng');</script>";
            echo "Error: " . $sql . mysqli_error($conn);
             exit();
        }
    }


    if (isset($_POST['edit'])) {

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $contactno = $_POST['contactno'];
        $salary = $_POST['salary'];
        $address = $_POST['address'];
        $id = $_POST['employeeid'];

        $sql = "UPDATE  employee set employeeName = ? ,email= ? ,number =? ,salary=? ,address =?  WHERE employeeid = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $fullname,$email, $contactno, $salary, $address,$id);

   if ($stmt->execute()) {
              echo "<script type='text/javascript'>
           alert('Employee has been edited !!!');
            window.location='manageEmployee.php';
        </script>";
            exit();
        } else {
             echo "<script>alert('Not register something went worng');</script>";
            echo "Error: " . $sql . mysqli_error($conn);
             exit();
        }
    }


    if (isset($_POST['deleteItem'])) {
        $id = $_POST['employeeid'];
        $sql = "DELETE FROM employee WHERE employeeid = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$id);
       if ($stmt->execute()) {
              echo "<script type='text/javascript'>
           alert('Employee has been deleted !!!');
            window.location='manageEmployee.php';
        </script>";
            exit();
        } else {
             echo "<script>alert('Something went worng');</script>";
            echo "Error: " . $sql . mysqli_error($conn);
             exit();
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
                url: "fetchEmployee.php",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#fullname').val(data.employeeName);
                    $('#email').val(data.email);
                    $('#contactno').val(data.number);
                    $('#address').val(data.address);
                    $('#salary').val(data.salary);
                    $('#id').val(data.employeeid)

                }
            });
        });

        $(document).on('click', '.delete', function() {
            console.log('hihi');
            var id = $(this).data('id');
            console.log(id)
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
                                <h2>Manage <b> Employees</b></h2>
                            </div>
                            <div class="col-sm-6">
                                <a href="#addUser" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employees</span></a>
                            </div>
                        </div>
                    </div>

                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee Id</th>
                                <th>Employee Name</th>
                                <th> Email</th>
                                <th>Contact Number</th>
                                <th> Salary</th>
                                <th> Address</th>
                                <th> Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = "select * from employee";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td><?= $row['employeeid']; ?></td>
                                    <td><?= $row['employeeName']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['number']; ?></td>
                                    <td><?= $row['salary']; ?></td>
                                    <td><?= $row['address']; ?></td>
                                    <td><?= $row['regDate']; ?></td>
                                    <td>
                                        <a class="edit" name="edit" data-target="#editUser" id="edit" data-id="<?php echo $row["employeeid"]; ?>" data-toggle="modal">
                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="#deleteUser" class="delete" data-toggle="modal" id="delete" data-id="<?php echo $row["employeeid"]; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>

                            <?php $cnt = $cnt + 1;
                            } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>




        <div id="addUser" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fullname" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-group">
                                <label>Email Address </label>
                                <input type="email" class="form-control form-control-lg" name="email" required />
                            </div>

                            <div class="form-group">
                                <label>Contact Number </label>
                                <input type="number" class="form-control form-control-lg" name="contactno" maxlength="10" required />
                            </div>


                            <div class="form-group">
                                <label>Salary </label>
                                <input type="number" class="form-control form-control-lg" name="salary" />
                            </div>

                            <div class="form-group">
                                <label> Address </label>
                                <input type="text" name="address" class="form-control form-control-lg" required />
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


        <div id="editUser" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Employees</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>


                        <div class="modal-body">
                            <input type="hidden" id="id" name="employeeid" value="">

                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fullname" id=fullname class="form-control form-control-lg" required />
                            </div>

                            <div class="form-group">
                                <label>Email Address </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required />
                            </div>

                            <div class="form-group">
                                <label>Contact Number </label>
                                <input type="number" class="form-control form-control-lg" name="contactno" id="contactno" maxlength="10" required />
                            </div>


                            <div class="form-group">
                                <label>Salary </label>
                                <input type="number" class="form-control form-control-lg" name="salary" id="salary" />
                            </div>

                            <div class="form-group">
                                <label> Address </label>
                                <input type="text" name="address" class="form-control form-control-lg" id="address" required />
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


        <div id="deleteUser" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Users</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete Users?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="deleteId" name="employeeid" value="">

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
