<!doctype html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>



<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item ml-2 ">
                    <a class="nav-link" href="home.php" style="color: white;">Home</a>
                </li>


                <li class="nav-item ml-2 ">
                    <a class="nav-link" href="myprofile.php" style="color: white;">My Profile</a>
                </li>

                <li class="nav-item ml-2 ">
                    <a class="nav-link" href="orders.php" style="color: white;">My Orders</a>
                </li>
                <li class="nav-item">

                    <a classs="nav-link" id="cart-popover" class="btn" data-placement="bottom" title="Shopping Cart" href="cart.php">
                        <span style="color: white;">
                            My Cart
                            <i class="fas fa-shopping-cart" style="color: #ff6219;"></i>

                            <?php
                            if (!empty($_SESSION['cart'])) {
                            ?>
                                <span class="badge bg-danger" style="top:-13px"><?php echo $_SESSION['qnty']; ?></span>

                            <?php } else { ?>

                                <span class="badge bg-danger" style="top:-13px"></span>


                            <?php } ?>


                        </span>
                    </a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="logout.php" style="color: white; text-decoration:none">
                    <i class="fas fa-sign-out-alt fa-1x me-3 " style="color: #ff6219;"></i>
                    <span> logout</span>
                </a>





            </form>
        </div>
    </nav>


</body>

<script>

</script>

</html>