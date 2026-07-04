<?php
    session_start();
    $error = isset($_SESSION['message']) ? $_SESSION['message'] : "Unexpected Error occurred, please try again.";
    unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />

    <title>Error</title>
</head>
<body>
<main id="main">
    <div style="align:center">
        <label style="font-size:100px;">Error</label><br>
        <label style="font-size:20px">Unexpected Error: <?php echo htmlspecialchars($error); ?> </label>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>