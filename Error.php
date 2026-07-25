<?php
session_start();

$error = isset($_SESSION['message'])
    ? $_SESSION['message']
    : "Unexpected Error occurred, please try again.";

unset($_SESSION['message']);
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">

<title>Error</title>
```

</head>

<body>

<main id="main">
    <div class="container d-flex justify-content-center align-items-center"
         style="min-height: 100vh;">

```
    <div class="text-center">

        <i class="bi bi-exclamation-triangle-fill text-danger"
           style="font-size: 80px;"></i>

        <h1 class="mt-3">Error</h1>

        <p class="text-muted" style="font-size: 20px;">
            <?php echo htmlspecialchars($error); ?>
        </p>

        <a href="LoginForm.php" class="btn btn-primary mt-3">
            <i class="bi bi-box-arrow-in-right"></i>
            Back to Login
        </a>

    </div>
</div>
```

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>
