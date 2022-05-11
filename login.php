<?php
session_start();
error_reporting(0);
include 'connection.php';


if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = mysqli_fetch_array($result);


  if (mysqli_num_rows($result) == 1) {
    $_SESSION['login'] = $_POST['email'];
    $_SESSION['id'] = $row['id'];
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    echo '<script>window.location.href = "https://'.$host.$uri.'/home.php";</script>';
    $stmt->close();
    exit();
  } else {
    $_SESSION['errmsg'] = "Invalid userid id or Password";
  }
}


?>






<!doctype html>
<html lang="en">


<body>

  <section class="mt-1 mb-5">
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

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                    <span style="color:red;">
                      <?php
                      echo htmlentities($_SESSION['errmsg']);
                      ?>

                      <?php
                      echo htmlentities($_SESSION['errmsg'] = "");
                      ?>
                    </span>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="form2Example17">Email</label>
                      <input type="text" class="form-control form-control-lg" name="email" id="email" />
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="form2Example27">Password</label>
                      <input type="password" id="password" class="form-control form-control-lg" name="password" />
                    </div>

                    

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Login</button>
                    </div>


                    <a class="small text-muted" href="#!">Forgot password?</a>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="signup.php">Register here</a></p>
                    <a href="#!" class="small text-muted">Terms of use.</a>
                    <a href="#!" class="small text-muted">Privacy policy</a>


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