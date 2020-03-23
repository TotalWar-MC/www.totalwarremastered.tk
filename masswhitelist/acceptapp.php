<?php
require("config.php");
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['applid']) ) {
	// Could not get the data that should have been sent.
	die ('Please supply an application ID!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare("UPDATE masswl_applications SET  accepted = 'yes', status = 'pending' WHERE id = ?")) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the ID is an integer so we use "i"
	$stmt->bind_param('i', $_POST['applid']);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Successfuly accepted selected Whitelist Application!');</script>";
    header('Location: pending_apps.php');

}
?>