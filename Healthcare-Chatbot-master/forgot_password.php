<?php
include('server.php');

// Initialize variables
$email = "";
$errors = array();

// When user submits email to reset password
if (isset($_POST['forgotPassword'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);

    // Check if email exists in database
    $query = "SELECT * FROM user WHERE email_id='$email'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // Generate a verification code
        $verificationCode = mt_rand(100000, 999999);

        // Store verification code in database
        $updateQuery = "UPDATE user SET verification_code='$verificationCode' WHERE email_id='$email'";
        mysqli_query($db, $updateQuery);

        // Send verification code to user's email
        $to = $email;
        $subject = 'Password Reset Verification Code';
        $message = 'Your verification code is: ' . $verificationCode;
        $headers = 'From: your_email@example.com'; // Replace with your email address

        if (mail($to, $subject, $message, $headers)) {
            // Email sent successfully, redirect to enter_code.php
            $_SESSION['email'] = $email;
            header('location: enter_code.php');
        } else {
            array_push($errors, "Failed to send email. Please try again later.");
        }
    } else {
        array_push($errors, "Email not found. Please enter a valid email address.");
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

    <title>Forgot Password - HealthCare Chatbot</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css"
        integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="forgot_password.php" method="post">
        <img class="mb-4" src="images/robot.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Forgot Password</h1>
        <!-- Display Validation errors over here -->
        <?php include('errors.php'); ?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email"
            value="<?php echo $email; ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="forgotPassword">Reset Password</button>
        <br>
        <p class="text-center">
            <a href="login.php">Back to Login</a> <!-- Link back to the Login page -->
        </p>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="scripts/login.js"></script>
</body>

</html>
