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
    $sql = "insert into category(categoryName,categoryDescription) values('$categoryName','$description')";
    if (mysqli_query($conn, $sql)) {
      $success = 'New record Created';
      header("Location: categories.php");
      exit();
    } else {
      echo "Error: " . $sql . " " . mysqli_error($conn);
    }
  }


  if (isset($_POST['edit'])) {
    $categoryName = $_POST['categoryName'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $sql = "update category set categoryName ='$categoryName' , categoryDescription='$description' where id='$id' ";

    if (mysqli_query($conn, $sql)) {
      $success = 'Record edited';
      header("Location: categories.php");
      exit();
    } else {
      echo "Error: " . $sql . " " . mysqli_error($conn);
    }
  }


  if (isset($_POST['deleteItem'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM category WHERE id = '$id' ";
    mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
      $success = 'Record Deleted';
      header("Location: categories.php");
      exit();
    } else {
      echo "Error: " . $sql . mysqli_error($conn);
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
        url: "fetchdata.php",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(data) {
          $('#categoryName').val(data.categoryName);
          $('#categoryDescription').val(data.categoryDescription);
          $('#id').val(data.id)
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
                <h2>Manage <b>Category</b></h2>
              </div>
              <div class="col-sm-6">
                <a href="#addCategoryModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Category</span></a>
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
                <th> Description</th>
                <th>Creation Date</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $query = "select * from category";
              $result = mysqli_query($conn, $query);


              while ($row = mysqli_fetch_array($result)) {
              ?>
                <tr>
                  <td><?= $row['id']; ?></td>
                  <td><?= $row['categoryName']; ?></td>
                  <td><?= $row['categoryDescription']; ?></td>
                  <td><?= $row['creationDate']; ?></td>
                  <td>

                    <a class="edit" name="edit" data-target="#editCategoriesModal" id="edit" data-id="<?php echo $row["id"]; ?>" data-toggle="modal">
                      <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#deleteCategory" class="delete" data-toggle="modal" id="delete" data-id="<?php echo $row["id"]; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                  </td>
                </tr>

              <?php $cnt = $cnt + 1;
              } ?>

            </tbody>
          </table>

        </div>
      </div>
    </div>


    <div id="addCategoryModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post">
            <div class="modal-header">
              <h4 class="modal-title">Add Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" class="form-control" name="categoryName" required>
              </div>

              <div class="form-group">
                <label>Description </label>
                <textarea class="form-control" required name="description"></textarea>
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


    <div id="editCategoriesModal" class="modal fade">
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
                <input type="text" class="form-control" name="categoryName" id="categoryName" value="" required>
              </div>

              <div class="form-group">
                <label>Description </label>
                <textarea class="form-control" name="description" id="categoryDescription" value='' required></textarea>
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


    <div id="deleteCategory" class="modal fade">
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






