<?php
session_start();
error_reporting(0);

include 'connection.php';


//Login code for admin

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $query = mysqli_query($conn, "SELECT * FROM owner WHERE username='$username' and password='$password'");
  $num = mysqli_fetch_array($query);

  if ($num > 0) {
    $extra = "manageUsers.php";
    $_SESSION['login'] = $_POST['username'];
    $_SESSION['id'] = $num['id'];
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("location:http://$host$uri/$extra");
    exit();
  } else {
    $extra = "index.php";
    $username = $_POST['username'];
    $host  = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("location:http://$host$uri/$extra");
    $_SESSION['errmsg'] = "Invalid userid id or Password";
    exit();
  }
}
?>





<!doctype html>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>


  <section class="mt-2">
    <div class="container py-4 h-90 ">
      <div class="row d-flex justify-content-center align-items-center h-100 mt-4">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="assets/img/login1.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;height:100%" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form method="post">
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-store fa-2x me-3 mr-2" style="color: #ff6219;"></i>
                      <span class="h4 fw-bold mb-0">RARITAN VALLEY</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Owner Login panel</h5>
                    <span style="color:red;">
                      <?php
                      echo htmlentities($_SESSION['errmsg']);
                      ?>

                      <?php
                      echo htmlentities($_SESSION['errmsg'] = "");
                      ?>
                    </span>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="form2Example17">User Name</label>
                      <input type="text" class="form-control form-control-lg" name="username" id="username" />
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="form2Example27">Password</label>
                      <input type="password" id="password" class="form-control form-control-lg" name="password" />
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>