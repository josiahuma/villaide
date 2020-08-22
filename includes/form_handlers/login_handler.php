<?php

if(isset($_POST['login_button'])) {
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //Check that the email is in the right format

    $_SESSION['log_email'] = $email; //Store email into session variable
    $password = md5($_POST['log_password']); //Get password

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'"); //Check for email AND password in datatbase
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query ==1) {
        $row = mysqli_fetch_array($check_database_query); //Store all the values of the user returned by the query for later use
        $username = $row['username']; //Assigning the username into a variable

        //Reactivate user account that was previously closed by simply loging in
        $user_close_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
        if(mysqli_num_rows($user_close_query) == 1) {
            $reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
        }

        $_SESSION['username'] = $username; //Check if the user is legally logged in using their username
        header("Location: index.php"); //Direct user to the homepage
        exit();
    }
    else {
        array_push($error_array, "Email or password was incorrect<br>");
    }


}

?>