<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />

</head>

<body>

<main id="main" class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">

<form id="ForgotPasswordForm" method="post" action="SendOTP.php" novalidate>

    <div class="loginPanel">

        <div>
            <img src="pictures\Post-Disaster-Reporting-Logo.png" width="55%">
        </div>

        <div class="panel-header justify-content-center">
            <div class="panel-title">
                <h4 style="font-weight:bold;">
                    Forgot Password
                </h4>
            </div>
        </div>

        <div class="mb-4">
            Enter your registered email and we'll send you a verification code.
        </div>

            <div class="input-group mb-4 w-100">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input
                    type="email"
                    class="form-control border-start-0 ps-0"
                    name="email"
                    placeholder="Email Address"
                    required>

            </div>

        <input type="submit" name="sendOTP" class=" btn btn-primary btn-lg btn-block w-100" value="Send OTP">

</form>

        <div style="padding-top:25px">
            Remember your password?
            <a href="LoginForm.php" class="stat-link" style="font-size:16px">
                Login here
            </a>
        </div>

    </div>
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

<script>
document.getElementById("ForgotPasswordForm").addEventListener("submit", function(e) {
    const email = document.querySelector('input[name="email"]').value.trim();

    if (email === "") {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Required Email",
            text: "Please enter your email address."
        });

        return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Invalid Email",
            text: "Please enter a valid email address."
        });
    }
});
</script>

</body>
</html>