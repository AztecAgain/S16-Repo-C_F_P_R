<?php
	session_start();	
	require_once('studentDB_connect.php');
	
	if ($_SESSION['authorized']!=true) {
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/login.php");
	}
	
	if (!empty($_GET['studentID'])) {
		$_SESSION['tempStudentID'] = $_GET['studentID'];
	}
	$studentID = $_SESSION['tempStudentID'];	
		
	$query = "select *
				from students
				where studentID = '$studentID'";
	$result=mysqli_query($dbc,$query); 
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$error = false;
		$message=NULL;
		
		$lastName = $_POST['lastName'];
		$firstName = $_POST['firstName'];
		$birthday = $_POST['birthday'];
		$university = $_POST['university'];
		
		//error checks
		if (empty($firstName) || is_numeric($firstName)){
			$message.='<font color="red"><b>ERROR:</b></font> Invalid first name</b><br>';
			$error=true;
		}
		if (empty($lastName) || is_numeric($lastName)){
			$message.='<font color="red"><b>ERROR:</b></font> Invalid last name</b><br>';
			$error=true;
		}
		if (empty($birthday) || is_numeric($birthday)){
			$message.='<font color="red"><b>ERROR:</b></font> Enter birthday</b><br>';
			$error=true;
		}
		if (empty($university) || is_numeric($university)){
			$message.='<font color="red"><b>ERROR:</b></font> Enter University</b><br>';
			$error=true;
		}
	
		if(!isset($message)){
			
			$update_query = "UPDATE students 
				                SET lastName ='$lastName' ,
									firstName ='$firstName' ,
									birthday ='$birthday',
									university = '$university'
							  where studentID = '$studentID'";
			
			if (mysqli_query($dbc, $update_query)) {
				$message.= 'Successful editing the students information';					
			}
			else {
				$message.= 'Error editing the students information';	
			}
			$query = "select *
				from students
				where studentID = '$studentID'";
			$result=mysqli_query($dbc,$query); 
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			
		} 
	}
?>	

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Systems Integration</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="students.php">Systems Integration</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                 
                        <li>
                            <a href="students.php"><i class="fa fa-dashboard fa-fw"></i> Student</a>
                        </li>
						<li >
							<a href="addStudents.php"><i class="fa fa-plus fa-fw"></i> Add Student</a>
						</li>
						<li >
							<a href="accounts.php"><i class="glyphicon glyphicon-user"></i> Accounts</a>
						</li>
						<li >
							<a href="addAccount.php"><i class="	fa fa-user-plus"></i> Create New Account</a>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			
		
            <div class="row">
				
                <div class="col-lg-12">
				
                    <h1 class="page-header">Edit Student Information</h1>
			
					<ol class="breadcrumb">
						<li>
							<i class="fa  fa-users fa-fw"></i>  <a href="students.php">Students</a>
						</li>
						<li >
							<i class="fa fa-plus fa-fw"></i>  <a href="numberOfStudentsPerUniversity.php">University</a>
						</li>
						<li class="active">
							<i class="fa fa-plus fa-fw"></i>  <a href="groupBy.php">Group by University and Age</a>
						</li>
						
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
			<div id="success-alert" style="display:none" class="alert alert-success fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Success!<br></strong> <?php echo $message; ?>
			</div>
			
			<div id="error-alert" style="display:none" class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Error!<br></strong> <?php echo $message; ?>
			</div>
			
            <div class="row">
				<!-- /.col-lg-8 -->
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Student Information Form
						</div>
						
						<!-- /.panel-heading -->
						<div class="panel-body" size>
							
							<fieldset><legend>Student Information</legend>
							<p>							
							</fieldset>
													
							<form id="editStudentInformationForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							
							
							     <div class="form-group">
									 <label>Last Name</label>
									 <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="<?php echo $row['lastName'];?>" required>
							     </div>
							  
							     <div class="form-group">
								     <label>First Name</label>
								     <input type="text" name="firstName" class="form-control" placeholder="First Name" value="<?php echo $row['firstName'];?>" required>	
							     </div>
							  
								 <div class="form-group">
									 <label>Birthday</label>
									 <input type="date" class="form-control" name="birthday" placeholder="Birthday" value="<?php echo $row['birthday'];?>" required>
								 </div>
								 
								 <div class="form-group">
								     <label>University</label>
								     <input type="text" name="university" class="form-control" placeholder="University" value="<?php echo $row['university'];?>" required>	
							     </div>
						
								 <div align="center">
									  <button class='btn btn-primary' id="confirm" type="button" name="submit-button" value="submit" >Save</button>
								 </div>
				  
							</form>
						</div>
						<!-- /.panel-body -->
						
						<!-- Modal -->
						<div id="message-modal" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							     <div class="modal-header">
								    <button type="button" class="close" data-dismiss="modal">&times;</button>
								    <h4 class="modal-title">Message</h4>
							     </div>
							     <div class="modal-body">
								 <p><?php echo $message; ?></p>
							     </div>
							     <div class="modal-footer">
								     <button type="button" class="btn btn-default" data-dismiss="modal">Close  </button>
							     </div>
							</div>

						    </div>
						</div>
					</div>
				</div>								
			</div>	

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Confirm Jquery Github -->  
	<script src="../js/jquery.confirm.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

		
	<script>
	$("#confirm").confirm({
		title:"Submit confirmation",
		text:"Are you sure you want to continue changes?",
		confirm: function(button) {
			$(function() { $("#editStudentInformationForm").submit(); });
			$(this).modal('hide');	
		},
		confirmButton: "Continue",
		cancelButton: "No"
	});
	</script>
	
	<script>
	<?php 
		if (isset($message)) {
			if (!$error) {
				echo '$("#success-alert").show();';
			}	
			else {
				echo '$("#error-alert").show();';
			}
		}
			
	?>	
	</script>


</body>

</html>
