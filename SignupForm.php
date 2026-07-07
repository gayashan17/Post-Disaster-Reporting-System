<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign up</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />

</head>
<body>
<main id="main"  class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">

    <form id="signupForm" method="post" action="Signup.php" onsubmit="">
    <div class="loginPanel">        1
        <div>
            <img src="pictures\Post-Disaster-Reporting-Logo.png" width="55%">
        </div>
        <div class="panel-header justify-content-center">
            <div class="panel-title">
                <h4 style="font-weight:bold;">Create Your Account</h4>
            </div>
        </div>
        <div class="mb-4">Register to submit disaster reports and track compensation requests</div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-person"></i>
              </span>
            <input type="text" class="form-control border-start-0" name="username-input" placeholder="Username">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-person-lines-fill"></i>
              </span>
            <input type="text" class="form-control border-start-0" name="fullname-input" placeholder="FullName">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-person-badge"></i>
              </span>
            <input type="text" class="form-control border-start-0" name="nic-input" placeholder="National Identity Card (NIC) Number">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-house"></i>
              </span>
            <input type="text" class="form-control border-start-0" name="address-input" placeholder="Home Address">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-phone"></i>
              </span>
            <input type="tel" class="form-control border-start-0" name="phoneNo-input" placeholder="Mobile Number">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-envelope"></i>
              </span>
            <input type="email" class="form-control border-start-0" name="email-input" placeholder="Email Address">
        </div>

        <label class="text-muted fw-bold " for="bDay-input">Birthday</label>
        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-calendar4-week"></i>
              </span>
            <input type="date" class="form-control border-start-0 text-muted" id="bDay-input" name="bDay-input">
        </div>

        <label class="text-muted fw-bold" for="gender-input">Gender</label>
        <div class="input-group mb-5 w-100">
            <select class="form-select text-muted" id="gender-input" name="gender-input">
                <option value="default">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-key"></i>
              </span>
            <input type="password" class="form-control border-start-0 " name="password-input" placeholder="Choose a Strong Password">
            <span class="input-group-text bg-white  " id="togglePassword" style="cursor: pointer;">
                <i class="bi bi-eye" id="PWeyeIcon"></i>
            </span>
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-key"></i>
              </span>
            <input type="password" class="form-control border-start-0 " name="confPassword-input" placeholder="Confirm Password">
            <span class="input-group-text bg-white  " id="toggleConfPassword" style="cursor: pointer;">
                <i class="bi bi-eye " id="ConfPWeyeIcon"></i>
            </span>
        </div>



        <label class="mb-1 fw-bold" style="color:white"></label>
        <input type="submit" name="register" class=" btn btn-primary btn-lg btn-block w-100" value="REGISTER" >
        <div style="padding-top:25px">
            Already have an account? <a href="LoginForm.php" class="stat-link" style="font-size:16px">Login Here</a>
        </div>
    </div>
    </form>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="Sign-up.js"></script>
</body>
</html>