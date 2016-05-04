<?PHP session_start();?>
<?PHP
	// Page start time.
	$pagestartime = microtime();
	
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	Check_Login();
	
	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	if($_SESSION['e_learning_video_password'] == 1){
		$_SESSION['e_learning_video_password'] = 2;
?>
<!DOCTYPE html>
<html>
<head>
	<title>e-Learning</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
	<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
	<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
</head>
<body>
	<div id="wrapper">
		<div id="featured-wrapper">
			<div class="extra2 container">
				<table class="List_Video_Table" >
					<tr id="List_Video_Row">
						<thead>
							<tr class="video_title"><td colspan="3" rowspan="2"><?echo $_GET['VideoTitle'];?></td></tr>
						</thead>
					<br>
					<tbody>
						<tr class="video_title" style="background-color:#3A3A3A"><td colspan="3" rowspan="2">
							<div style="padding: 15px 15px">
								<iframe src="embed.php?ID=<? echo $_GET['ID'];?>" width="640" height="400" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe>
							</div>
						</td></tr>
					</tbody>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
<?PHP
	} else{
		unset($_SESSION['e_learning_video_password']);
		echo "<script>parent.location.href='../';</script>";
	}
?>