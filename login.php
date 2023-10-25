<?php

session_start();

if (isset($_POST['login'])) {
    $username = trim($_POST['usernameLogin']);
    $password = trim($_POST['passwordLogin']);

    // Initializing the error message (empty)
    $errorMessage = "";

    // Username
    $filePath = "users/";
    $testingUsername = $filePath . $username . ".txt";
    if (!file_exists($testingUsername)) {
        $errorMessage .= "The username or the password does not exist. <br>";
    } else {
        // If file exists, check password
        $userFileContents = file_get_contents($testingUsername);
        $userData = json_decode($userFileContents, true); 
        $storedPassword = trim($userData['password']); 
        if ($storedPassword != $password) {
            $errorMessage .= "The username or the password does not exist. <br>";
        }
    }

    // ERROR
    if (!empty($errorMessage)) {
        $_SESSION['errorMessage'] = $errorMessage;
        header("Location: index.php");
        exit();
    }

    // SUCCESSFUL LOGIN
    if (empty($errorMessage)) {
    	// To display the Game Status data
    	// Casting my variables to integer so I can do some math
        $played = trim($userData['played']);
        $_SESSION['played'] = (int)$played;
        $won = trim($userData['won']);
        $_SESSION['won'] = (int)$won;
        $lost = trim($userData['lost']);
        $_SESSION['lost'] = (int)$lost;
        $tries = trim($userData['tries']);
        $_SESSION['tries'] = (int)$tries;

        $_SESSION['username'] = $username;  
        $_SESSION['successMessage'] = "Successful Login!" . "<br> Welcome " . $username;
        $_SESSION['logged'] = true;
        unset($_SESSION['errorMessage']);
        header("Location: index.php");
        exit();
    }
}
?>
