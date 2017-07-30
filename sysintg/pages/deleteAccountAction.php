<?php
	session_start();	
	require_once('studentDB_connect.php');
	
	if (isset($_GET['accountID'])) {
		$accountID = $_GET['accountID'];
	}
				 
	$sql = "DELETE 
			FROM accounts
			where accountID = '$accountID'"; 

	$result = mysqli_query($dbc, $sql);
	
	header('Location: accounts.php');
	
?>		
