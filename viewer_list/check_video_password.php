<?PHP session_start(); ?>
<?PHP
	$control_path = "../";
	
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	
	// Include database connection file.
	include("_DBTable.php");
	
	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	$viewer_password = $_POST['viewer_password'];
	$video_id = $_POST['ID'];
	$video_title = $_POST['VideoTitle'];
	
	$sql = "SELECT *
			FROM e_learning_video_info
			WHERE video_id = $video_id
				  AND viewer_password = '$viewer_password'";

	$rs = mysql_query($sql);
	if(mysql_num_rows($rs) > 0){
		// 密碼正確
		$_SESSION['e_learning_video_password'] = 1;
		echo "<script>location.href='../play_video/index?ID=$video_id&VideoTitle=$video_title';</script>";
	} else{
		// 密碼比對失敗
		echo "<script>location.href='password_content?ID=$video_id&VideoTitle=$video_title&password_error=1';</script>";
	}
?>