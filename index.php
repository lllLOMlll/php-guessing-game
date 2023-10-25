<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Guessing Game - Hezing College</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">

</head>
<body>
	<div class="content">
		<!-- Alert message -->
		<?php
		if (isset($_SESSION['alertMessage'])) {
			$alertMessage = str_replace("\n", "\\n", $_SESSION['alertMessage']);
			echo "<script>alert('$alertMessage');</script>";
   			// Unset the alert message from the session to prevent it from displaying on refresh
			unset($_SESSION['alertMessage']);
		}

		?>

		<!-- Game over -->
		<?php if (isset($_SESSION['gameOver']) && $_SESSION['gameOver']): ?>
			<script>
				window.onload = function() {

					var modal = document.getElementById('modalGameOver');
					modal.style.display = "block";
				}
			</script>
		<?php endif; ?>
		<!-- GAME OVER MODAL -->
		<div id="modalGameOver" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<span class="close">&times;</span>
				<p class="text-center">Would you like to continue?</p>
				<form method="post" action="start.php">
					<div class="text-center">
						<input type="submit" class="btn btn-lg btn-success mr-2" value="YES" name="start" id="yesBtn">
					</div>
				</form>
				<br>
				<form method="post" action="logout.php">
					<div class="text-center">
						<input type="submit" class="btn btn-lg btn-danger mr-2 mb-5" value="NO (Logout)" name="logout" id="noBtn">
					</div>
				</form>
			</div>
		</div>
		<?php
		unset($_SESSION['gameOver']);
		?>

		<script>
  			// Get the modal
			var modal = document.getElementById("modalGameOver");

   			 // Get the buttons
			var yesBtn = document.getElementById("yesBtn");
			var noBtn = document.getElementById("noBtn");

  			  // When the user clicks on either button, close the modal
			yesBtn.onclick = function() {
				modal.style.display = "none";
				window.location.href = 'start.php';
			}

			noBtn.onclick = function() {
				modal.style.display = "none";
				window.location.href = 'logout.php';
			}
		</script>




		<div class="container-fluid">
			<div class="container">
				<?php
				if(!isset($_SESSION['logged'])){
					?>
					<h2 class="text-center" id="title">PHP Impossible Guessing Game</h2>
					<hr>

					<!-- ************* SIGN UP FORM ****************************** -->
					<div class="row">
						<div class="col-md-5">
							<form role="form" method="post" action="register.php">
								<fieldset>

									<p class="text-uppercase"><b>SIGN UP</b></p>
									<div class="form-group">
										<!-- Username -->
										<input type="text" name="username" id="usernameRegistration" class="form-control input-lg" placeholder="username" value="<?php echo isset($_SESSION['inputUsername']) ? ($_SESSION['inputUsername']) : ''; ?>"> 

									</div>

									<div class="form-group">
										<!-- Email -->
										<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php echo isset($_SESSION['inputEmail']) ? ($_SESSION['inputEmail']) : ''; ?>">
									</div>
									<div class="form-group">

										<!-- Password -->
										<input type="password" name="password" id="passwordRegistration" class="form-control input-lg" placeholder="Password" value="<?php echo isset($_SESSION['inputPasswordRegistration']) ? ($_SESSION['inputPasswordRegistration']) : ''; ?>" >
									</div>
									<div class="form-group">
										<!-- Confirm password -->

										<input type="password" name="confirmPassword" id="confirmPassword" class="form-control input-lg" placeholder="Confirm Password" value="<?php echo isset($_SESSION['inputConfirmPassword']) ? ($_SESSION['inputConfirmPassword']) : ''; ?>">
									</div>
									<!-- Buttons -->
									<div>
										<!-- Register button -->
										<input type="submit" class="btn btn-lg btn-primary mr-2" value="Register" name="buttonRegister">
										<!-- Clear button -->
										<button type="button" class="btn btn-lg btn-primary" onclick="clearForm()" id="buttonClear">Clear</button>

										<script type="text/javascript">
											function clearForm() {
												document.getElementById('usernameRegistration').value = '';
												document.getElementById('email').value = '';
												document.getElementById('passwordRegistration').value = '';
												document.getElementById('confirmPassword').value = '';
											}
										</script>


									</div>

								</fieldset>
							</form>
						</div>



						<!-- ******************** LOGIN *********************** -->
						<div class="col-md-5 offset-md-2">
							<form role="form"  method="post" action="login.php">
								<fieldset>
									<p class="text-uppercase"><b>Login using your account</b></p>

									<div class="form-group">
										<input type="text" name="usernameLogin" id="usernameLogin" class="form-control input-lg" placeholder="username">
									</div>
									<div class="form-group">
										<input type="password" name="passwordLogin" id="passwordLogin" class="form-control input-lg" placeholder="Password">
									</div>
									<div>
										<input type="submit" class="btn btn-md btn-success" value="Sign In" name="login">
									</div>

								</fieldset>
							</form>
						</div>
					</div>


					<!-- ****************** ERROR AND SUCCES MESSAGES **************************-->
					<!-- SUCCESS MESSAGE -->
					<br>
					<?php
					if (isset($_SESSION['successMessage'])) {
						?>
						<div class="alert alert-success fade in alert-dismissible show" style="margin-top:18px;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true" style="font-size:20px">×</span>
							</button>    
							<strong>Yahoo!</strong><br><?php echo $_SESSION['successMessage'] ?>
						</div>
						<?php
   					 // Unset the error message from the session to prevent it from displaying on refresh
						unset($_SESSION['successMessage']);
					}
					?>

					<!-- ERROR MESSAGE -->
					<?php
					if (isset($_SESSION['errorMessage'])) {
						?>
						<div class="alert alert-danger fade in alert-dismissible show">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true" style="font-size:20px">×</span>
							</button>
							<strong>Oups!</strong><br><?php echo $_SESSION['errorMessage'] ?>
						</div>	
						<?php
   				 // Unset the error message from the session to prevent it from displaying on refresh
						unset($_SESSION['errorMessage']);
					}
					?>


					<!-- Closing tag of hiding Register, Login and Alert messages -->
					<?php
				}
				?>



				<!-- ************************** THE GAME ********************************** -->	
				<!-- Display the game only if a user is login -->
				<?php
				if (isset($_SESSION['logged'])) {
					?>
					<h2 class="text-center mb-3" id="title">
						PHP Impossible Guessing Game <br>
						<!-- Displaying the name of the user -->
						<small>Welcome back <?php echo $_SESSION['username'] ?>, have fun!</small>
					</h2>


					<!-- Start the game - START  -->
					<?php
					if (!isset($_SESSION['start'])){
						?>
						<form method="post" action="start.php">
							<div class="text-center">
								<input type="submit" class="btn btn-lg btn-warning mr-2" value="Start the game" name="start">
							</div>
						</form>
						<br>
						<!-- Closing tag of the start button -->
						<?php
					}
					?>


					<!-- Displaying the game only if the user clicked on the start button -->
					<?php
					if (isset($_SESSION['start'])) {
						?>
						<div class="row">
							<div class="col-md-12">
								<form method="post" action="game.php">
									<fieldset>
										<p class="text-uppercase"><b>Try to guess the following word: <big class="text-danger"><em><?php echo isset($_SESSION['scrambleWord']) ? ($_SESSION['scrambleWord']) :  '';?></em></big></b></p>

<!-- *************   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   ****************** -->
										<!-- Display the answer! -->
										<?php 
										echo $_SESSION['originalWord']
										?>
										<!-- Display the answer! -->
<!-- *************   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   ****************** -->
										

										<div class="input-group mb-3">
											<input type="text" class="form-control" placeholder="Guess Here" aria-describedby="basic-addon2" name="guess">
											<div class="input-group-append">
												<input type="submit" class="btn btn-info" name="game">
											</div>
										</div>
									</fieldset>
								</form>

							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1 class="text-center">Game Status</h1>
								<hr>
							</div>
							<div class="col-md-3 text-center text-primary text-uppercase">
								<div class="card">
									<strong>Game Played</strong>
									<h1><?php echo isset($_SESSION['played']) ? ($_SESSION['played']) : ''; ?></h1>
								</div>
							</div>
							<div class="col-md-3 text-center text-success text-uppercase">
								<div class="card">
									<strong>Game Won</strong>
									<h1><?php echo isset($_SESSION['won']) ? ($_SESSION['won']) : ''; ?></h1>
								</div>
							</div>
							<div class="col-md-3 text-center text-danger text-uppercase">
								<div class="card">
									<strong>Game Lost</strong>
									<h1><?php echo isset($_SESSION['lost']) ? ($_SESSION['lost']) : ''; ?></h1>
								</div>
							</div>
							<div class="col-md-3 text-center text-info text-uppercase">
								<div class="card">
									<strong>Current Tries</strong>
									<h1><?php echo isset($_SESSION['tries']) ? ($_SESSION['tries']) : ''; ?></h1>
								</div>
							</div>
						</div>
						<hr>
					</div>

					<!-- Closing tag for Game Start -->
					<?php
				}
				?>




				<!-- ******************** LOGOUT **************************************** -->
				<form method="post" action="logout.php">
					<div class="text-center">
						<input type="submit" class="btn btn-lg btn-danger mr-2" value="Log Out" name="logout">
					</div>
				</form>
				<br>

				

				<!-- Closing the part for not displaying the Game and the logout  -->
				<?php
			}
			?>
		</div>
	</div>

</div>

<!-- FOOTER -->
<footer>
	<p class="text-center">
		<small id="passwordHelpInline" class="text-muted"> Copyright &#64; 2023 Louis-Olivier Major. All Rights Reserved. </a>
		</p>
	</footer>

	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
</body>


</html>