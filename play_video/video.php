<?PHP session_start();?>
<?
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../onetime_password.php");
	
	include("find_video.php");
	
	$mesh_pash = $_POST["select_op"];
	$check_str = "PATH";
	$get_length = strlen($mesh_pash);
	$isValid  = strpos($mesh_pash, $check_str);
	$validPath = $_SESSION['e_learning_video_password'];
	unset($_SESSION['e_learning_video_password']);
	
	if($get_length == 36 && $isValid && $validPath == 3){
		
		$random_pass_key = onetime_passwd();
		$VideoID = $_SESSION['s_VideoID'];
		
		$sql = "UPDATE e_learning_video_info
				SET pass_key = '$random_pass_key'
				WHERE video_id = $VideoID";
		
		mysql_query($sql, $ln);
		
		$real_src = find_video($random_pass_key, $ln);
		echo ($real_src);
		
	}else{
		$content=<<<EOT
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /KM/e-learning/play_video/video.php was not found on this server.</p>
<hr>
<address>Apache/2.2.4 (Win32) PHP/5.2.3 Server at 192.168.2.150 Port 80</address>
</body></html>
EOT;
		echo ($content);
		exit;
	}
?>