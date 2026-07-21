<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />

</head>
<body>
<main id="main"  class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">

    <form id="loginForm" method="post" action="Login.php" onsubmit="">
    <div class="loginPanel">
        <div>
            <img src="pictures\Post-Disaster-Reporting-Logo.png" width="55%">
        </div>
        <div class="panel-header justify-content-center">
            <div class="panel-title">
                <h4 style="font-weight:bold;">Welcome Back!</h4>
            </div>
        </div>
            <div class="mb-4">Please login back to your account</div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-envelope"></i>
              </span>
            <input type="text" class="form-control border-start-0 ps-0" id="username-input" name="username-input" placeholder="Username">
        </div>

        <div class="input-group mb-4 w-100">
              <span class="input-group-text">
                <i class="bi bi-key"></i>
              </span>
            <input type="password" class="form-control border-start-0 ps-0" id="password-input" name="password-input" placeholder="Password">
            <span class="input-group-text bg-white  " id="togglePassword" style="cursor: pointer;">
                <i class="bi bi-eye" id="eyeIcon"></i>
            </span>
        </div>

        <div class="d-flex justify-content-between align-items-center w-100 mb-4 px-1">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                <label class="form-check-label" style="cursor: pointer;" for="rememberMe">
                    Remember me
                </label>
            </div>

            <a href="ForgotPasswordForm.php" class="stat-link" style="font-size:16px">Forgot Password?</a>
        </div>

        <input type="submit" name="login" class=" btn btn-primary btn-lg btn-block w-100" value="LOGIN">
        <div style="padding-top:25px">
            Don't have an account? <a href="SignupForm.php" class="stat-link" style="font-size:16px">Register here</a>
        </div>
    </div>
    </form>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<?php if(isset($_SESSION['message'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['icon'] ?? "error"; ?>',
        title: '<?php echo $_SESSION['message']; ?>',
        confirmButtonColor: '#0d6efd'
    });
</script>

<?php
unset($_SESSION['message']);
unset($_SESSION['icon']);
endif;
?>

<script src="Log-in.js"></script>
</body>
</html>