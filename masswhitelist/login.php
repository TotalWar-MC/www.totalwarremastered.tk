<?php
require("config.php");
$output = "";

if(isset($_POST['submitbtn'])){
  if ( !isset($_POST['username'], $_POST['password']) ) {
  	// Could not get the data that should have been sent.
  	$output = "Please fill both the username and password field!";
  }

  // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
  if ($stmt = $con->prepare('SELECT id, password FROM masswl_users WHERE username = ?')) {
  	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
  	$stmt->bind_param('s', $_POST['username']);
  	$stmt->execute();
  	// Store the result so we can check if the account exists in the database.
  	$stmt->store_result();

  	if ($stmt->num_rows > 0) {
  		$stmt->bind_result($id, $password);
  		$stmt->fetch();
  		// Account exists, now we verify the password.
  		// Note: remember to use password_hash in your registration file to store the hashed passwords.
  		if ($_POST['password'] === $password) {
  			// Verification success! User has loggedin!
  			// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
  			session_regenerate_id();
  			$_SESSION['loggedin'] = TRUE;
  			$_SESSION['name'] = $_POST['username'];
  			$_SESSION['id'] = $id;
  			header('Location: index.php');
  		} else {
  			$output = "Incorrect password!";
  		}
  	} else {
  		$output = "Incorrect username!";
  	}

  	$stmt->close();
  }
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

  <title>MassWhitelist - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

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
                    <h1 class="h4 text-gray-900 mb-4">MassWhitelist - Login</h1>
                  </div>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="username" name="username" class="form-control form-control-user" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submitbtn" class="btn btn-primary btn-user btn-block" value="Login">
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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
