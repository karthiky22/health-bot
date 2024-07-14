<?php
include('server.php');

// Initialize variables
$email = $_SESSION['email'];
$errors = array();

// When user submits verification code
if (isset($_POST['verifyCode'])) {
    $code = mysqli_real_escape_string($db, $_POST['code']);

    // Check if entered code matches the one in database
    $query = "SELECT * FROM user WHERE email_id='$email' AND verification_code='$code'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // Code is correct, allow user to reset password
        $_SESSION['reset_email'] = $email; // Store email in session for password reset
        header('location: reset_password.php');
    } else {
        array_push($errors, "Invalid verification code. Please enter the correct code.");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Enter Verification Code - HealthCare Chatbot</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css"
        integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="enter_code.php" method="post">
        <img class="mb-4" src="images/robot.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Enter Verification Code</h1>
        <!-- Display Validation errors over here -->
        <?php include('errors.php'); ?>
        <label for="inputCode" class="sr-only">Verification Code</label>
        <input type="text" id="inputCode" class="form-control" placeholder="Verification Code" name="code" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="verifyCode">Verify Code</button>
        <br>
        <p class="text-center">
            <a href="login.php">Back to Login</a> <!-- Link back to the Login page -->
        </p>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="scripts/login.js"></script>
</body>

</html>
