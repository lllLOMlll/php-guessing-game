<?php
session_start();

if (isset($_POST['buttonRegister'])) {
    // Save the input of the registration form
    $username = trim($_POST['username']);
    $_SESSION['inputUsername'] = $username;  

    $email = trim($_POST['email']);
    $_SESSION['inputEmail'] = $email; 

    $passwordRegistration = trim($_POST['password']);
    $_SESSION['inputPasswordRegistration'] = $passwordRegistration;  
  
    $confirmPassword = trim($_POST['confirmPassword']);
    $_SESSION['inputConfirmPassword'] = $confirmPassword;  

      $errorMessage = "";

    // Username
    if (strlen($username) < 4) {
      $errorMessage .= "Username must be at least 4 characters long. <br>";
    }

    $filePath = "users/";
    $testingUsername = $filePath . $username . ".txt";
    if (file_exists($testingUsername)) {
      $errorMessage .= "That username is already taken. <br>";
    }

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errorMessage .= "Invalid email format. <br>";
    }

    // Password
    if (strlen($passwordRegistration) < 8) {
      $errorMessage .= "Password must be at least 8 characters long. <br>";
    } 
    if (!preg_match("/[A-Z]/", $passwordRegistration)) {
      $errorMessage .= "Password must contain at least one uppercase letter. <br>";
    } 
    if (!preg_match("/[!@#\$%\^&*()]/", $passwordRegistration)) {
      $errorMessage .= "Password must contain at least one special character. <br>";
    }

    // Confirm password
    if ($passwordRegistration != $confirmPassword) {
      $errorMessage .= "Your password and your confimation password does not match. <br>";
    }



    // ERROR
    if (!empty($errorMessage)) {
      $_SESSION['errorMessage'] = $errorMessage;
      header("Location: index.php");
      exit();
    }

    // SUCCESS REGISTRATION
    if (empty($errorMessage)) {
      // Create a file.txt for the user 
      $filePath = "users/";
      $fileName = $filePath . $username . '.txt';
      // "a+" allows reading and writing into the file
      $handle = fopen($fileName, 'a+');

      unset($_POST['buttonRegister']);
      unset($_POST['confirmPassword']);
      // Creating and initializing variables for the games
      $_POST['played'] = "0";
      $_POST['won'] = "0";
      $_POST['lost'] = "0";
      $_POST['tries'] = "3";
      $user = json_encode($_POST) . PHP_EOL;
      fwrite($handle, $user);
      fclose($handle);



      $_SESSION['successMessage'] = "Successful registration!";
      unset($_SESSION['inputUsername']);
      unset($_SESSION['inputEmail']);
      unset($_SESSION['inputPasswordRegistration']);
      unset($_SESSION['inputConfirmPassword']);
      unset($_SESSION['errorMessage']);
      header("Location: index.php");
      exit();
    }
  }
  ?>
