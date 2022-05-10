<?php
session_start();
error_reporting(0);
include 'connection.php';
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
        echo "<script>alert('Product has been updated to the cart')</script>";
        echo "<script type='text/javascript'> document.location ='cart.php'; </script>";
    } else {
        $sql_p = "SELECT * FROM product WHERE id={$id}";
        $query_p = mysqli_query($conn, $sql_p);
        if (mysqli_num_rows($query_p) != 0) {
            $row_p = mysqli_fetch_array($query_p);
            $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['price']);
            echo "<script>alert('Product has been added to the cart')</script>";
            echo "<script type='text/javascript'> document.location ='cart.php'; </script>";
            exit;
        }
    }
}
?>


<?php include 'navbar.php'; ?>
<!doctype html>
<html lang="en">

<head>

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
</head>

<script>
    $(document).ready(function() {
        let data = new URLSearchParams(window.location.search).get('cid');
        if (data) {
            $("#all").hide();
            $("#other").show();

        } else {
            $("#other").hide();
            $("#all").show();

        }

    });


    function myFunction() {
        window.location.replace("home.php");
    }

    function category() {
        window.location.reload()

    }
</script>

<body>


    <main>
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light mdb-color lighten-3 mt-3 mb-5">
                <span class="navbar-brand">Categories:</span>
                <?php
                $query = "select * from category";
                $result = mysqli_query($conn, $query);

                ?>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="basicExampleNav">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item active">
                            <a class="nav-link" onclick="myFunction()" href="#">All
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <?php

                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <li class="nav-item">
                                <a href="home.php?cid=<?php echo $row['id']; ?>" class="nav-link" id="category" onclick="category()">
                                    <?php echo $row['categoryName']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <form name="search" method="post" action="search-result.php">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" name="product" aria-describedby="search-addon" />
                            <button type="button" class="btn btn-outline-primary">search</button>
                        </div>
                    </form>
                </div>

            </nav>




            <section class="text-center mb-4" id="all">
                <div class="row wow fadeIn">
                    <?php
                    $sql = "SELECT * FROM product";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <form method="post" name="addToCart">
                                <div class="card">
                                    <div class="image">
                                        <img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['image']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['image']); ?>" alt="" width="200" height="300"></a>
                                    </div>


                                    <div class="card-body text-center">
                                        <h5>
                                            <a class="dark-grey-text productName" id="productName" name="productName" value=<?= $row['productName']; ?>><?php echo $row['productName']; ?></a>

                                        </h5>
                                        <h4 class="font-weight-bold blue-text">

                                            <strong>$<?= $row['price']; ?></strong>
                                        </h4>

                                        <a href="home.php?page=product&action=add&id=<?php echo $row['id']; ?>">
                                            <button class="btn btn-primary" type="button" name="addToCart">Add to cart</button></a>

                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php } ?>
                </div>
            </section>


            <section class="text-center mb-4" id="others">
                <hr>
                <div class="row wow fadeIn mt-5">
                    <?php
                    if ($_GET['cid']) {
                        $cid =  $_GET['cid'];
                        $ret = mysqli_query($conn, "select * from product where categoryName='$cid'");
                        $num = mysqli_num_rows($ret);
                        if ($num > 0) {
                            while ($row = mysqli_fetch_array($ret)) { ?>
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <form method="post">
                                        <div class="card">
                                            <div class="image">
                                                <img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['image']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['image']); ?>" alt="" width="200" height="300"></a>
                                            </div>


                                            <div class="card-body text-center">
                                                <h5>
                                                    <a class="dark-grey-text productName" id="productName" name="productName" value=<?= $row['productName']; ?>><?php echo $row['productName']; ?></a>

                                                </h5>
                                                <h4 class="font-weight-bold blue-text">

                                                    <strong>$<?= $row['price']; ?></strong>
                                                </h4>

                                                <a href="home.php?page=product&action=add&id=<?php echo $row['id']; ?>">
                                                    <button class="btn btn-primary" type="button">Add to cart</button></a>

                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php }
                        } else { ?>

                            <div class="col-sm-6 col-md-4 wow fadeInUp">
                                <h3>No Product Found</h3>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>
</body>
<?php include 'footer.php'; ?>

</html>