<?php
	session_start();	
	require_once('studentDB_connect.php');
	
	if ($_SESSION['authorized']!=true) {
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/login.php");
	}
	else {

		$continueQuery = false;
		$tableTitle = null;
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {									
			$dateToday = date('Y-m-d');
			$message=NULL;
			
			$lowestAge = 0;
			$highestAge = 0;
			$university = "";
			
			$groupByAge = false;
			$groupByUniversity = false;
		
			if(isset($_POST['ageCheckbox'])){
				$groupByAge = true;
				if (!empty($_POST['lowestAge']) && !is_numeric($_POST['lowestAge'])) {
					$message.='Invalid age Input<br>';
				}
				if (!empty($_POST['highestAge']) && !is_numeric($_POST['highestAge'])) {
					$message.='Invalid age Input<br>';
				}
				if (empty($_POST['lowestAge']) && empty($_POST['highestAge']) ) {
					$message.='Invalid age Input<br>';
					$continueQuery = false;
				}
				
			}
			
			if (isset($_POST['universityCheckbox'])) {
				$groupByUniversity = true;
				$university = $_POST['university'];
			}
			
			if (!isset($_POST['universityCheckbox']) && !isset($_POST['ageCheckbox'] )) {
				$message.='Please check age or university<br>';
			}
										
			if (!isset($message)) {
				$continueQuery = true;
				if ($groupByAge) {
					if ($_POST['lowestAge'] > $_POST['highestAge']) {
						$lowestAge = $_POST['highestAge'];
						$highestAge = $_POST['lowestAge'];
					}
					else {
						$lowestAge = $_POST['lowestAge'];
						$highestAge = $_POST['highestAge'];
					}
				}
				
				// group by age only
				if ($groupByAge && !$groupByUniversity) {
					$tableTitle = "<center><b>Age:</b> $lowestAge to $highestAge<br><br></center>";
					$groupByQuery =	$groupByQuery =	"Select studentID,lastName,firstName, FLOOR(DATEDIFF(NOW(),birthday) /365) as 'age', university  
									 From
									 (
									   select
										  studentID,
										  firstName, 
										  lastName,
										  birthday,
										  FLOOR(DATEDIFF(NOW(),birthday) /365) AS age,
										  university
									   from students   
									 ) as innerTable
									 Where age >= '$lowestAge' and
										   age <= '$highestAge' ";
				}
				// group by university only
				else if (!$groupByAge && $groupByUniversity) {
					$tableTitle = "<center>Students from <b>$university</b></center>";
					$groupByQuery =	"Select studentID,lastName,firstName, FLOOR(DATEDIFF(NOW(),birthday) /365) as 'age', university  
									 From
									 (
									   select
										  studentID,
										  firstName, 
										  lastName,
										  birthday,
										  FLOOR(DATEDIFF(NOW(),birthday) /365) AS age,
										  university
									   from students   
									 ) as innerTable
									 Where university = '$university'";
				}
				// group by age and university
				else if ($groupByAge && $groupByUniversity) {
					$tableTitle = "<center> Students of <b>$lowestAge</b> to <b>$highestAge</b> years old from <b>$university</b></center>";
					$groupByQuery =	"Select studentID,lastName,firstName, FLOOR(DATEDIFF(NOW(),birthday) /365) as 'age', university  
									 From
									 (
									   select
										  studentID,
										  firstName, 
										  lastName,
										  birthday,
										  FLOOR(DATEDIFF(NOW(),birthday) /365) AS age,
										  university
									   from students   
									 ) as innerTable
									 Where age >= '$lowestAge' and
										   age <= '$highestAge' and
										   university = '$university'";
				}																		
			}
			else {
				$continueQuery = false;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

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
			
			<div id="error-alert" style="display:none" class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Error!<br></strong> <?php echo $message; ?>
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
			
							<form id="groupByForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">	
								<div>
									<b>Group By:</b>
									<input type="checkbox" name="universityCheckbox" onclick="showUniversityDropdown('universityDropdown')" value="" <?php if (isset($_POST['university'])) echo $_POST['university']; ?>> University
									<input type="checkbox" name="ageCheckbox" onclick="showAgeInput('ageInput')" <?php if (isset($_POST['age'])) echo $_POST['age']; ?>> Age
									<input type="submit" value="Submit"><br><br>
								</div>
								
								<?php

									$query = "select university 
									            from students 
										    group by university";
									$result = mysqli_query($dbc,$query);	
					
									echo "<select name='university' id='universityDropdown' style='display:none;'>";

									while ($row = $result->fetch_assoc()) {
										unset($university);
										$university = $row['university']; 
										echo '<option value="'.$university.'">'.$university.'</option>';
									}

									echo "</select>";

								?> 
								
								<br>
								<div id="ageInput" style="display:none;">
									<input id="lowestAge" name="lowestAge" size="5" type="text" class="small" value="" <?php if (isset($_POST['lowestAge'])) echo $_POST['lowestAge']; ?>/> 
									to
									<input id="highestAge" name="highestAge" size="5" type="text" class="small" value="" <?php if (isset($_POST['highestAge'])) echo $_POST['highestAge']; ?>/> years old
								</div>	
								<br>
								
							</form>
							
							<?php if ($tableTitle != null) { echo "<center>$tableTitle</center>";} ?>
						
							<table width="100%" class="table table-striped table-bordered table-hover" id="students-table">						
								<thead>
									<tr>
										<th class="text-center"></th>
										<th class="text-center"></th>
										<th class="text-center">Last Name</th>
										<th class="text-center">First Name</th>
										<th class="text-center">Age</th>
										<th class="text-center">University</th>
						 
									</tr>
								</thead>
								<tbody>
									<?php 
										if ($continueQuery) {
											$result=mysqli_query($dbc,$groupByQuery);
											
											while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ ?>
											<tr>
												<td class="text-center"><a style="color:blue;" href="editStudentInformation.php?studentID=<?php echo $row["studentID"];?>">Edit</td>
												<td class="text-center"><a style="color:red;" href="deleteStudentAction.php?studentID=<?php echo $row["studentID"];?>" class="cancel">Remove</td>
												<td class="text-center"><?php echo $row["lastName"]; ?></td>
												<td class="text-center"><?php echo $row["firstName"]; ?></td>	
												<td class="text-center"><?php echo $row["age"]; ?></td>
												<td class="text-center"><?php echo $row["university"]; ?></td>
											</tr>
										<?php } 
										}										
									?>
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
	
	<script>
	function showAgeInput (box) {

		var chboxs = document.getElementsByName("ageCheckbox");
		var vis = "none";
		for(var i=0;i<chboxs.length;i++) { 
			if(chboxs[i].checked){
			 vis = "block";
				break;
			}
		}
		document.getElementById(box).style.display = vis;
	}
	</script>
	
	<script>
	function showUniversityDropdown (box) {

		var chboxs = document.getElementsByName("universityCheckbox");
		var vis = "none";
		for(var i=0;i<chboxs.length;i++) { 
			if(chboxs[i].checked){
			 vis = "block";
				break;
			}
		}
		document.getElementById(box).style.display = vis;
	}
	</script>

	<script>
	<?php 
		if (isset($message)) {
			echo '$("#error-alert").show();';
		}
			
	?>	
	</script>

</body>

</html>
