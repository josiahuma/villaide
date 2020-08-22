<?php 
require 'config/config.php';

//Check if user is logged in, then set the username, else send them back to login
if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'"); //Get all users information if they are logged in
    $user = mysqli_fetch_array($user_details_query); //Store it in an array for future use
}
else {
    header("Location: register.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villaide - An Online Community for Prayer and Counseling</title>
    
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    
    <!-- CSS -->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Villaide</a>
        </div>
        <nav>
            <a href="<?php echo $userLoggedIn; ?>">
                <?php echo $user['first_name']; ?>
            </a>
            <a href="index.php">
                <i class="icon-home icon-large"></i>
            </a>
            <a href="#">
                <i class="icon-envelope icon-large"></i></i>
            </a>
            <a href="#">
                <i class="icon-bell icon-large"></i>
            </a>
            <a href="#">
                <i class="icon-users icon-large"></i>
            </a>
            <a href="#">
                <i class="icon-cog icon-large"></i>
            </a>
            <a href="#">
                <i class="icon-signout icon-large"></i>
            </a>
            

        </nav>
    </div>

    <div class="wrapper">


