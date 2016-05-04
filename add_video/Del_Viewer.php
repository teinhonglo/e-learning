<?PHP session_start(); ?>
<?PHP
	$ViewerID  	   = $_GET['ID'];
	$MemberID 	   = $_SESSION['s_MemberID'];
	$VideoID	   = $_SESSION['s_VideoID'];
	
	$contorl_path  = "../";
	
	// Include Permission Control file.
	include($contorl_path . "../PermissionControl.php");

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($contorl_path . "../db_Con.php");
	$ln = connectdb();
	
	if (($ViewerID != "") && ($MemberID != ""))
	{	
		// Delete viewer in e_learning_uploader table
		$sql = "DELETE	FROM e_learning_video_viewer
				WHERE   id = $ViewerID";
		
		mysql_query($sql, $ln);
	}

	mysql_close($ln);

	// Redirect to Home Page.
	echo "<script>location.href='show_video_viewer.php?ID=$VideoID';</script>";
?>
