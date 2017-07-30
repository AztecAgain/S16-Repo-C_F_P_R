<?php 
	session_start();
	require_once('studentDB_connect.php');
	
	if (isset($_POST['submit'])){	
		$message=NULL;

		if (empty($_POST['username'])){
			 $_SESSION['username']=FALSE;
		     $message.='You forgot to enter your username!';
		} 
		else {
		     $_SESSION['username']=$_POST['username']; 
		}

		if (empty($_POST['password'])){
			 $_SESSION['password']=FALSE;
			 $message.='You forgot to enter your password!';
		} 
		else {
		     $_SESSION['password']=$_POST['password']; 		
		}
			
		if(!isset($message)){
		
			$username = $_POST['username'];
			$password = $_POST['password'];

			$query_test="SELECT  *
						   FROM accounts 
						  WHERE username = '$username' AND password ='$password'";
			$result=mysqli_query($dbc,$query_test);
			
			$count=mysqli_num_rows($result);
			
			if ($count == 1) {
				$_SESSION['authorized'] = true;
				$row = $result->fetch_assoc();
				$_SESSION['accountID'] = $row['accountID'];
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/students.php");
			}
			else {
				$message = "Wrong username or password";
				$_SESSION['authorized'] = false;
			}
								
		}
	}
	if (isset($message)){
		echo '<script type="text/javascript">alert("'.$message.'");</script>';
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

    <title>System Integration</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" value="" <?php if (isset($_POST['username'])) echo $_POST['username']; ?>/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
								<div align="center"><input style="height:40px; width:320px" type="submit" name="submit" value="Login" /></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
