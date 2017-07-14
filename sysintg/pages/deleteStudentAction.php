<?php
	session_start();	
	require_once('studentDB_connect.php');
	
	if (isset($_GET['studentID'])) {
		$studentID = $_GET['studentID'];
	}
				 
	$sql = "DELETE 
			FROM students
			where studentID = '$studentID'"; 

	$result = mysqli_query($dbc, $sql);
	
	header('Location: students.php');
	
?>		
