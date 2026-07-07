
<?php
session_start();

if(!isset($_SESSION['otp_verified']))
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
    <title>Reset Password</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
</head>

<body>

<main id="main" class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">
<form id="resetPasswordForm" method="POST" action="ResetPassword.php">

        <div class="loginPanel">

        <div>
            <img src="pictures\Post-Disaster-Reporting-Logo.png" width="55%">
        </div>

            <div class="panel-header justify-content-center">
                <div class="panel-title">
                    <h4 style="font-weight:bold;">
                        Reset Password
                    </h4>
                </div>
            </div>

            <div class="mb-4">
                Create a new password for your account.
            </div>

            <!-- New Password -->

            <div class="input-group mb-4 w-100">

                <span class="input-group-text">
                    <i class="bi bi-key"></i>
                </span>

                <input
                    type="password"
                    class="form-control border-start-0 ps-0"
                    id="newPassword"
                    name="newPassword"
                    placeholder="New Password">

                <span class="input-group-text bg-white"
                      id="toggleNewPassword"
                      style="cursor:pointer">

                    <i class="bi bi-eye" id="newPasswordEye"></i>

                </span>

            </div>

            <!-- Confirm Password -->

            <div class="input-group mb-4 w-100">

                <span class="input-group-text">
                    <i class="bi bi-key-fill"></i>
                </span>

                <input
                    type="password"
                    class="form-control border-start-0 ps-0"
                    id="confirmPassword"
                    name="confirmPassword"
                    placeholder="Confirm Password">

                <span class="input-group-text bg-white"
                      id="toggleConfirmPassword"
                      style="cursor:pointer">

                    <i class="bi bi-eye" id="confirmPasswordEye"></i>

                </span>

            </div>

            <input
                type="submit"
                name="resetPassword"
                class="btn btn-primary btn-lg btn-block w-100"
                value="Reset Password">

        </div>

    </form>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script>

// Show New Password

document.getElementById("toggleNewPassword").addEventListener("click", function(){

    const password = document.getElementById("newPassword");
    const icon = document.getElementById("newPasswordEye");

    if(password.type === "password")
    {
        password.type = "text";
        icon.classList.replace("bi-eye","bi-eye-slash");
    }
    else
    {
        password.type = "password";
        icon.classList.replace("bi-eye-slash","bi-eye");
    }

});

// Show Confirm Password

document.getElementById("toggleConfirmPassword").addEventListener("click", function(){

    const password = document.getElementById("confirmPassword");
    const icon = document.getElementById("confirmPasswordEye");

    if(password.type === "password")
    {
        password.type = "text";
        icon.classList.replace("bi-eye","bi-eye-slash");
    }
    else
    {
        password.type = "password";
        icon.classList.replace("bi-eye-slash","bi-eye");
    }

});

// Validation

document.getElementById("resetPasswordForm").addEventListener("submit", function(e){

    const newPassword = document.getElementById("newPassword").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();

    if(newPassword === "")
    {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Password Required",
            text: "Please enter a new password."
        });

        return;
    }

    if(!/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/.test(newPassword))
    {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Weak Password",
            text: "Password must contain uppercase, lowercase letters and a number."
        });

        return;
    }

    if(confirmPassword === "")
    {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Confirm Password Required",
            text: "Please confirm your password."
        });

        return;
    }

    if(newPassword !== confirmPassword)
    {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Password Mismatch",
            text: "Passwords do not match."
        });

        return;
    }

});

</script>

<?php if(isset($_SESSION['message'])): ?>

<script>
Swal.fire({
    icon: <?php echo json_encode($_SESSION['icon']); ?>,
    title: <?php echo json_encode($_SESSION['message']); ?>
});
</script>

<?php
unset($_SESSION['message']);
unset($_SESSION['icon']);
endif;
?>

</body>
</html>