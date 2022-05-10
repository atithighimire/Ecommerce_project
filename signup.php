<?php
session_start();
include 'connection.php';

if (isset($_POST['submit'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $shippingAddress = $_POST['shippingAddress'];
    $password = md5($_POST['password']);
    $result = "SELECT count(*) FROM users WHERE email=?";
    $stmt = $conn->prepare($result);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        echo "<script>alert('Email id already associated with another account. Please try with diffrent EmailId.');</script>";
    } else {
        $stmti = $conn->prepare("INSERT into users (name,email,contactno,password,shippingAddress) VALUES (?, ? , ? , ? , ?)");
        $stmti->bind_param('ssiss', $name, $email, $contactno, $password, $shippingAddress);
        if (!$stmti->execute()) {
            trigger_error("there was an error...." . $conn->error, E_USER_WARNING);
        } else {
            echo "<script>alert('User has been Registered Please Login ');</script>";
            header("Location: index.php");
            $stmti->close();
        }
    }
}




?>







<!doctype html>
<html lang="en">

<body>
    <?php include 'mainBar.php'; ?>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="assets/img/login1.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;height:100%" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form role="form" method="post" name="register" onSubmit="return valid();">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-store fa-2x me-3 mr-2" style="color: #ff6219;"></i>
                                            <span class="h4 fw-bold mb-0"> <a href="index.php">Go Back to Login</a></span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign up your account</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Full Name<span class="required">*</span></label>
                                            <input type="text" id="fullname" name="fullname" class="form-control form-control-lg" required />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Email address<span class="required">*</span></label>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" required />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Contact Number<span class="required">*</span></label>
                                            <input type="number" class="form-control form-control-lg" id="contactno" name="contactno" maxlength="10" required />
                                        </div>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example27">Password<span class="required">*</span></label>
                                            <input type="password" id="password" class="form-control form-control-lg" name="password" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example27">Shipping Address</label>
                                            <input type="text" id="shippingAddress" name="shippingAddress" class="form-control form-control-lg" required />
                                        </div>


                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" id="submit">Signup</button>
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

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


</body>

</html>