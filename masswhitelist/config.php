<?php
session_start();

/* Database credentials. Usage: $ID = 'info_goes_here';
Example: $DATABASE_HOST = 'db4free.net'; Use with all others respectively. If you have a different port than default (3306), append :<port> after the host.
For example, db4free.net:3204 (where 3204 is a port number different than 3306).*/
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'opsec';
$DATABASE_PASS = 'b]hK_juq},/$8X)d';
$DATABASE_NAME = 'opsec';

/* RCON credentials for running MassWhitelist remotely. Change the values of $RCON_HOST, $RCON_PORT and $RCON_PASSWORD to your set credentials.*/
$RCON_HOST = ''; // Server IP Address
$RCON_PORT = 25575; // RCON Port
$RCON_PASSWORD = ''; // RCON Password

// DO NOT EDIT BELOW THIS LINE!
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>