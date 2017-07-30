<?php
	session_start();	
	require_once('studentDB_connect.php');
	
	if ($_SESSION['authorized']!=true) {
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/login.php");
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
                    <h1 class="page-header">Students</h1>

					<ol class="breadcrumb">
						<li class="active">
							<i class="fa  fa-users fa-fw"></i>  <a href="students.php">Students</a>
						</li>
						<li >
							<i class="fa fa-plus fa-fw"></i>  <a href="numberOfStudentsPerUniversity.php">University</a>
						</li>
						<li>
							<i class="fa fa-plus fa-fw"></i>  <a href="groupBy.php">Group by University and Age</a>
						</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
			<div id="note-alert" style="display:none" class="alert alert-info fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Note!</strong> You just removed a student
			</div>
			
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                     
							<table width="100%" class="table table-striped table-bordered table-hover" id="students-table">						
								<thead>
									<tr>
										<th class="text-center"></th>
										<th class="text-center"></th>
										<th class="text-center">Last Name</th>
										<th class="text-center">First Name</th>
										<th class="text-center">Birthday</th>
										<th class="text-center">University</th>
						 
									</tr>
								</thead>
								<tbody>
									<?php 
										$student_query = "select * 
														  from students";
										$result = mysqli_query($dbc,$student_query);
										
										$row_count=mysqli_num_rows($result);
										while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ ?>
											<tr>
												<td class="text-center"><a style="color:blue;" href="editStudentInformation.php?studentID=<?php echo $row['studentID'];?>">Edit</td>
												<td class="text-center"><a style="color:red;" href="deleteStudentAction.php?studentID=<?php echo $row['studentID'];?>" class="cancel">Remove</td>
												<td class="text-center"><?php echo $row['lastName']; ?></td>
												<td class="text-center"><?php echo $row['firstName']; ?></td>	
												<td class="text-center"><?php echo $row['birthday']; ?></td>
												<td class="text-center"><a href="studentsOfUniversity.php?university=<?php echo $row['university'];?>"><u><?php echo $row['university']; ?></u></td>
											</tr>
									<?php } ?>
								</tbody>
							</table>                       
                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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
	
	<!-- JQUERY Confirm -->
	<script src="../js/jquery.confirm.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#students-table').DataTable({
            responsive: true
        });
    });
    </script>
	
	<script>
	$(".cancel").confirm({
		title:"Remove confirmation",
		text:"You are about to remove this student. Are you sure you want to continue?",	
	});
	</script>

</body>

</html>
