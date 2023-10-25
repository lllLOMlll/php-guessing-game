<?php
session_start();

if (isset($_POST['logout'])) {
    // Resetting the tries to 3
    $filePath = "users/";
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $_SESSION['alertMessage'] = "You cannot play if your are not logged";
    }
    $fileName = $filePath . $username . ".txt";
    $userFileContents = file_get_contents($fileName);
    $userData = json_decode($userFileContents, true);
    $newTries = 3;
    $userData['tries'] = 3;
    $updatedUserFileContents = json_encode($userData);
    file_put_contents($fileName, $updatedUserFileContents);
    $_SESSION['tries'] = (int)$newTries;

    
    session_unset();

    // Destroy the session
    session_destroy();

    header("Location: index.php");
    exit();
}
?>

