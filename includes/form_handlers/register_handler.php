<?php

//Declaring variables to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$email = ""; //Email
$email2 = ""; //Email2
$password = ""; //Password
$password2 = ""; //Password2
$date = ""; //Sign up date
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

    //Registration form values

    //First name
    $fname = strip_tags($_POST['reg_fname']); //Remove html tags
    $fname = str_replace('','',$fname); //Remove spaces
    $fname = ucfirst(strtolower($fname)); //Capitalize only first letter
    $_SESSION['reg_fname'] = $fname; //Stores first name into session variable

    //Last name
    $lname = strip_tags($_POST['reg_lname']); //Remove html tags
    $lname = str_replace('','',$lname); //Remove spaces
    $lname = ucfirst(strtolower($lname)); //Capitalize only first letter
    $_SESSION['reg_lname'] = $lname; //Stores last name into session variable

    //Email
    $email = strip_tags($_POST['reg_email']); //Remove html tags
    $email = str_replace('','',$email); //Remove spaces
    $email = ucfirst(strtolower($email)); //Capitalize only first letter
    $_SESSION['reg_email'] = $email; //Stores email into session variable

    //Email 2
    $email2 = strip_tags($_POST['reg_email2']); //Remove html tags
    $email2 = str_replace('','',$email2); //Remove spaces
    $email2 = ucfirst(strtolower($email2)); //Capitalize only first letter
    $_SESSION['reg_email2'] = $email2; //Stores email2 into session variable

    //Password
    $password = strip_tags($_POST['reg_password']); //Remove html tags
    $password2 = strip_tags($_POST['reg_password2']); //Remove html tags

    $date = date("Y-m-d"); //This gets the current date

    if($email == $email2){
        //check if email is valid
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            
            //Check if email already exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

            //count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }
        
        }
        else{
            array_push($error_array, "Invalid Email format<br>");
        }
    }
    else{
        array_push($error_array, "Emails don't match<br>");
    }

    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    if($password != $password2) {
        array_push($error_array, "Your passwords do not match<br>");
    }
    else{
        if(preg_match('/[^A-Za-z0-9]/', $password)){ //Check that password only contain characters and numbers
            array_push($error_array, "Your password can only contain english characters or numbers<br>"); 
        }
    }

    if(strlen($password > 30 || strlen($password) < 5)) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if(empty($error_array)){
        $password = md5($password); //Encrypt password before sending to database

        //Generate username by concatenating firstname and lastname
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username ='$username'");

        $i = 0;
        //if username exists add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++; //Add 1 to i
            $username = $username . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username ='$username'");
       }

        //Profile picture assignment
        $rand = rand(1,2); //Random number between 1 and 2

        if($rand == 1)
            $profile_pic = "assets/images/profile_pic/defaults/head_deep_blue.png";
        else if($rand == 2)
           $profile_pic = "assets/images/profile_pic/defaults/head_carrot.png";

        $query = mysqli_query($con, "INSERT INTO users VALUE('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");
       
        array_push($error_array, "<span style='color:#14c800;'>You're all set! Go ahead and login</span><br>");
       
        //Clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }

}

?>