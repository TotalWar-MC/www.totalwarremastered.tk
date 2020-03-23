<?php
require("config.php");
$output = "";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables
$username = htmlentities($_SESSION['name'], ENT_QUOTES, 'UTF-8');
$password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');

if(isset($_POST['submitbtn'])){
  if ( !isset($_POST['password']) ) {
  	// Could not get the data that should have been sent.
  	$output = ('Please supply a new password!');
  }

  // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
  if ($stmt = $con->prepare("UPDATE masswl_users SET password = '$password' WHERE username = '$username'")) {
      $stmt->execute();
      $stmt->close();

      $output = "<script>alert('Successfuly changed password!');</script>";
      header('Location: logout.php');

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

  <title>MassWhitelist - Change Password</title>

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
                    <h1 class="h4 text-gray-900 mb-4">Change your account password</h1>
                  </div>
                  <form class="user" action="" method="post">
                  <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="New Password" required>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submitbtn" class="btn btn-primary btn-user btn-block" value="Change Password">
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
