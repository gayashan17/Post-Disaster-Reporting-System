<?php
session_start();

if(!isset($_SESSION['reset_email']))
{
    header("Location: ForgotPasswordForm.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="/Post-Disaster-Reporting-System/assets/css/style.css" rel="stylesheet" />
</head>

<body>

<main id="main" class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">

<form id="VerifyOTPForm" method="post" action="VerifyOTP.php" novalidate>
    <div class="loginPanel">

        <div>
            <img src="pictures\Post-Disaster-Reporting-Logo.png" width="55%">
        </div>

        <div class="panel-header justify-content-center">
            <div class="panel-title">
                <h4 style="font-weight:bold;">
                    Verify OTP
                </h4>
            </div>
        </div>

        <div class="mb-2">
            We've sent a verification code to
        </div>

        <div class="mb-4 text-primary fw-bold">
            <?php echo $_SESSION['reset_email']; ?>
        </div>


            <div class="input-group mb-4 w-100">

                <span class="input-group-text">
                    <i class="bi bi-shield-lock"></i>
                </span>

                <input
                    type="text"
                    class="form-control border-start-0 ps-0 text-center"
                    name="otp"
                    maxlength="6"
                    placeholder="Enter 6-digit OTP"
                    required>

            </div>

            <button
                type="submit"
                class="btn btn-primary btn-lg w-100">

                Verify OTP
        
            </button>

</form>

<div class="mt-4">

    <p id="timer" class="text-muted">
        Resend OTP in 30 seconds
    </p>

    <a id="resendLink"
       href="ResendOTP.php"
       class="stat-link"
       style="font-size:16px; display:none;">
       Resend OTP
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
    icon: '<?php echo $_SESSION['icon']; ?>',
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

let seconds = 30;

const timer = document.getElementById("timer");
const resendLink = document.getElementById("resendLink");

const countdown = setInterval(function() {

    seconds--;

    timer.innerHTML = "Resend OTP in " + seconds + " seconds";

    if(seconds <= 0)
    {
        clearInterval(countdown);

        timer.style.display = "none";
        resendLink.style.display = "inline";
    }

}, 1000);

</script>
</body>
</html>