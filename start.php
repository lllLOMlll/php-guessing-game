<?php
session_start();

if (isset($_POST['start'])) {



	// Generation a random word
	$file_name = "words.txt";
	$handle = fopen($file_name, "a+") or die("Unable to open the file words.txt");
	$file = file($file_name);
	fclose($handle);

	
		// Generating a number between 0 and 109582 (inclusive)
	$randomNum = rand(0, 109582);
	
		// Saving the original word as the variable $originalWord
	$originalWord = trim($file[$randomNum]);

	
		// Creating a function to scramble the selected word
	function scramble($word)
	{
		$numberOfLetters = strlen($word);

			// $word = trim($word);
		$word = str_replace(["\0", "\t", "\n", "\x0B", "\r", " "], '', $word);

		    // Splitting the word into an array
		$wordTransformIntoAnArray = str_split($word);
		    // Shuffle the word (array)
		shuffle($wordTransformIntoAnArray);
		    // Converting the array into a string (for display purposes)
		return trim(implode('', $wordTransformIntoAnArray)); 

		
	}

	// Calling the function
	$_SESSION['scrambleWord'] = scramble($originalWord);
	$_SESSION['originalWord'] = $originalWord;

	
	// Declaring and initializing the start variable
	$_SESSION['start'] = true;
	header("Location: index.php");
	exit();

}

?>