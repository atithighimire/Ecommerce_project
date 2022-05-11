<?php
session_start();
error_reporting(0);
include 'connection.php';
?>
<?php include 'navbar.php'; ?>


<!doctype html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 

      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">





</head>

<style>
    .container {
        justify-content: center;
        display: flex;

    }
</style>

<body>




    <div class="container">

        <?php

        $id =   $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE id = '$id' ";

        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        ?>

        <div class="card mt-4" style="width: 700px">
            <div class="card-header bg-transparent border-success text-center">
                <h2 style="color: red;">My Profile</h2>
            </div>
            <img class="card-img-top" src="assets/img/avatar.jpg" alt="Card image cap" height="350px" width="200px">
            <hr>
            <div class="card-body">
                <h5 class="card-title">Name: <? echo $result['name'] ?></h5>
                <h5 class="card-title">Email: <? echo $result['email'] ?> </h5>
                <h5 class="card-title">Signedup Date: <? echo $result['regDate'] ?> </h5>
                <h5 class="card-title">Contact Number : <? echo $result['contactno'] ?> </h5>
            </div>
        </div>


</body>

</html>