<?php
require("config.php");

$output = "";

// Define variables for application data (and escape quotes and potentially malicious code)
$minecraft = htmlentities($_POST['minecraft'], ENT_QUOTES, 'UTF-8');
$discord = htmlentities($_POST['discord'], ENT_QUOTES, 'UTF-8');
$paragraph = htmlentities($_POST['paragraph'], ENT_QUOTES, 'UTF-8');
$referral = htmlentities($_POST['referral'], ENT_QUOTES, 'UTF-8');
	
if(isset($_POST['submitbtn'])){
	if ( !isset($_POST['minecraft'], $_POST['discord'], $_POST['paragraph']) ) {
		// Could not get the data that should have been sent.
		$output = ('Please fill all required fields! Click the Back button on your browser to go back to your application!');
	}
	
	// Send data to the database
	$sql = "INSERT INTO masswl_applications (username, discord, paragraph, referral) VALUES ('$minecraft', '$discord', '$paragraph', '$referral')";
	if(mysqli_query($con, $sql)){
		$output = "Your application was sent to the server. You will be soon notified via Discord!";
	} else{
		$output = "ERROR: Could not send your application. Contact the server administrator. Info they might ask for: " . mysqli_error($con);
	}
	
	// Close connection
	mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Whitelist Application</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/whitelist.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
  <form method="POST" class="signup-form" id="signup-form">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">TotalWar Whitelist Application</h1>
                  </div>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="username" name="minecraft" class="form-control form-control-user" id="minecraft" placeholder="Minecraft Username" required>
                    </div>
                    <div class="form-group">
                      <input type="username" name="discord" class="form-control form-control-user" id="discord" placeholder="Discord Username with Identifier (#)" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="paragraph" class="form-control form-control-user" id="paragraph" placeholder="A sentence or two explaining why you should be accepted." required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="referral" class="form-control form-control-user" id="refferal" placeholder="Who referred you?" optional>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submitbtn" class="btn btn-primary btn-user btn-block" value="Send Application!">
                    </div>
                      <div class="form-check">
                      <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                      <label for="agree-term" class="label-agree-term"><span><span></span></span>I have read the <a href="#" class="term-service">Rules and Disclaimer</a></label>
                    </div>
					<div>
					    <?php echo $output; ?>
					</div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Footer -->
  <footer id="footer">
				<ul class="copyright">
          <li>Powered by MassWhitelist</li>
          <li>Version 1.1.1</li>
          <li>Copyright &copy;2020 MassWhitelist - AcmePlugins - konsyr11</li>
					<li>Built for TW:R, TW:MC, MIT License &copy; 2020</li>
				</ul>
      </footer>
  
  <!-- Footer
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Powered by MassWhitelist</span><br>
		<span>Version 1.1.1</span><br>
        <span>Copyright &copy;2020 MassWhitelist - AcmePlugins - konsyr11</span>
      </div>
    </div>
  </footer>
  End of Footer -->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

	<!-- Scripts -->
	<script src="assets/js/main.js"></script>

</body>

</html>
