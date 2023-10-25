<?php
session_start();

$filePath = "users/";
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $_SESSION['alertMessage'] = "You cannot play if your are not logged";
}
$fileName = $filePath . $username . ".txt";
$userFileContents = file_get_contents($fileName);
$userData = json_decode($userFileContents, true); 

$won = (int)$userData['won'];
$_SESSION['won'] = $won;
$lost = (int)$userData['lost'];
$_SESSION['lost'] = $lost;
$tries = (int)$userData['tries'];
$_SESSION['tries'] = $tries;


// When the user click on submit
if(isset($_POST['game'])) {
    $guess = trim(strtolower($_POST['guess']));
    $originalWord = strtolower($_SESSION['originalWord']);
    
    // WINNING
    if ($guess == $originalWord) { 
        // Set the message
        $_SESSION['alertMessage'] = "Congratulations!!!\n" . $guess . " is the right answer";

        //Adding one to the victory
        $newWon = $won + 1;
        $userData['won'] = $newWon;
        
        // Reseting the tries to 3 
        $newTries = 3;
        $userData['tries'] = 3;

        // Updating the session variable for display purpose
        $_SESSION['won'] = (int)$newWon;
        $_SESSION['tries'] = (int)$newTries;
        $_SESSION['gameOver'] = true;
        
        // Increment the played games
        $newGamesPlayed = $userData['won'] + $userData['lost'];
        $userData['played'] = $newGamesPlayed; 
        $_SESSION['played'] = $newGamesPlayed;
        
        // Convert the updated user data array to a JSON string
        $updatedUserFileContents = json_encode($userData); 
        // Write the updated JSON string to the user's file
        file_put_contents($fileName, $updatedUserFileContents); 
    }

    // LOOSING
    else {
        if($_SESSION['tries'] > 1) {
            $newTries = $_SESSION['tries'] - 1;
            $userData['tries'] = $newTries;
            $_SESSION['tries'] = (int)$newTries;
            $_SESSION['alertMessage'] = "Sorry, your guess is incorrect. \n" . $newTries . " tries left!";
        }
        else { 
            $_SESSION['alertMessage'] = "Game Over";
            $newLost = $lost + 1;
            $userData['lost'] = $newLost;
            $_SESSION['lost'] = $newLost;

            $newTries = 3;
            $userData['tries'] = 3;
            $_SESSION['tries'] = (int)$newTries;
            
            // Increment the played games
            $newGamesPlayed = $userData['won'] + $userData['lost'];
            $userData['played'] = $newGamesPlayed; 
            $_SESSION['played'] = $newGamesPlayed;
            
            $_SESSION['gameOver'] = true;
        }

        $updatedUserFileContents = json_encode($userData);
        file_put_contents($fileName, $updatedUserFileContents);
    }

    // Redirecting to index.php 
    header("Location: index.php");
    exit();
}
?>
