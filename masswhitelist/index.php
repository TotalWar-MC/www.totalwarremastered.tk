<?php

require("config.php");

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Count Applications
$server = mysql_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS); 
$db = mysql_select_db($DATABASE_NAME); 

$queryaccepted = mysql_query("SELECT COUNT(*) as accepted FROM masswl_applications WHERE accepted = 'yes'");
$dataaccepted = mysql_fetch_assoc($queryaccepted);

$querydeclined = mysql_query("SELECT COUNT(*) as declined FROM masswl_applications WHERE accepted = 'no'");
$datadeclined = mysql_fetch_assoc($querydeclined);

$querypending = mysql_query("SELECT COUNT(*) as pending FROM masswl_applications WHERE accepted IS NULL");
$datapending = mysql_fetch_assoc($querypending);

$queryapps = mysql_query("SELECT COUNT(*) as apps FROM masswl_applications");
$dataapps = mysql_fetch_assoc($queryapps);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MassWhitelist - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://github.com/Acme-Plugins/MassWhitelist">
        <div class="sidebar-brand-text mx-3">MassWhitelist 1.0</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Applications
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Whitelist Applications</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Application Tables</h6>
            <a class="collapse-item" href="./accepted_apps.php">Accepted</a>
            <a class="collapse-item" href="./declined_apps.php">Declined</a>
            <a class="collapse-item" href="./pending_apps.php">Pending</a>
            <a class="collapse-item" href="./all_apps.php">All</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Stats
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="./charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">2</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notifications
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="./all_apps.php">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas text-white"></i>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">Whitelist Applications are ready to be processed! Click here to go to the All Applications panel.</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="./profile.php">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas text-white"></i>
                    </div>
                  </div>
                  <div>
                    Welcome to MassWhitelist Web Interface, <?=$_SESSION['name']?>! Click here to view your profile!
                  </div>
                </a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$_SESSION['name']?></span>
                <img class="img-profile rounded-circle" src="./img/server_image.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="./profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="./changepassword.php">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Accepted Players -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Players Accepted</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dataaccepted['accepted']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Rejected Players -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Players Rejected</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $datadeclined['declined']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Applications -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Applications</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $datapending['pending']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Applications -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applications</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dataapps['apps']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

              <!-- Run MassWhitelist -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Remotely run MassWhitelist</h6>
                </div>
                <div class="card-body">
                <p>Remotely send the /masswl command to your server, that will automatically add accepted players to the whitelist, with just a click of a button. Your server administrator must have enabled this feature for this to work.</p>
                  <form method="POST" action=''>
                    <input type="submit" class="btn btn-primary btn-user btn-block" name="runmasswl" value="Run MassWhitelist">
                  </form>
                  </div>
              </div>


          <!-- Content Row -->
          <div class="row">
              
            <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">MassWhitelist - Information</h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
                  </div>
                  <p>MassWhitelist is the ultimate Whitelisting platform for Minecraft. It makes whitelisting a large ammount of players easily, in a short ammount of time, through the Web Interface. Then, with just one command, players can be whitelisted on the server and get notified about it. All through one, powerful Spigot Plugin. MassWhitelist - by AcmePlugins - Developer: konsyr11</p>
                  <a target="_blank" rel="nofollow" href="https://www.spigotmc.org/resources/masswhitelist.75127/">View MassWhitelist on SpigotMC &rarr;</a><br>
                  <a target="_blank" rel="nofollow" href="https://www.github.com/Acme-Plugins/MassWhitelist">View MassWhitelist on GitHub &rarr;</a>
                </div>
              </div>

              <!-- News Box -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Notice for Server Admins:</h6>
                </div>
                <div class="card-body">
                  <p>You can change this to add notices or news that you would like your staff team to see. You can also delete the whole box between the "News Box" comments.</p>
                  <a target="_blank" rel="nofollow" href="https://www.github.com/Acme-Plugins/MassWhitelist/wiki">Find out more on our Wiki &rarr;</a>
                </div>
              </div>
              <!-- News Box -->

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;2020 MassWhitelist - AcmePlugins - konsyr11</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Logout?
          </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you done with your work? Select "Logout" to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
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

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>


<?php
// RCON Code for running MassWhitelist directly from your website.

require_once('Rcon.php');
require_once('config.php');
$host = $RCON_HOST; // Server IP Address
$port = $RCON_PORT; // RCON Port
$password = $RCON_PASSWORD; // RCON Password
$timeout = 3; // Timeout interval
use Thedudeguy\Rcon;
if (isset($_POST['runmasswl']))
{
	$rcon = new Rcon($host, $port, $password, $timeout);

		if ($rcon->connect())
		{
			$rcon->sendCommand("masswl run");
			echo "<script>alert('MassWhitelist command was send to your server. Check console for output!');</script>";
		} else {
			echo "<script>alert('Your server admin has opted not to use the remote MassWhitelist feature. You need to run /masswl from the server's console or in-game to whitelist accepted players.');</script>";
		}
}
?>