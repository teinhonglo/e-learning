<?PHP session_start(); ?>
<?PHP
	$VideoID       = $_GET['ID'];
	$MemberID 	   = $_SESSION['s_MemberID'];
	
	$contorl_path  = "../";
	
	// Include Permission Control file.
	include($contorl_path . "../PermissionControl.php");

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($contorl_path . "../db_Con.php");
	$ln = connectdb();
	
	if (($VideoID != "") && ($MemberID != ""))
	{
		/* 
		// GET real file name from video information table
		$sql = " SELECT  name
				 FROM    e_learning_video_info
				 WHERE   video_id = '$VideoID'";
				 
		$rs = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);
		
		// Delete video file
		$file = "../videos/" . $row[0];
		
		if (!unlink($file)){
			echo ("Error deleting");
			exit;
		}
		else{
			echo ("Deleted");
		} 
		*/
		
		// Delete uploader in e_learning_uploader table
		$sql = "UPDATE	e_learning_video_info
				SET     is_delete = 1
				WHERE   video_id = '$VideoID'";
		
		mysql_query($sql, $ln);
	}

	mysql_close($ln);

	// Redirect to Home Page.
	echo "<script>location.href='index';</script>";
?>
