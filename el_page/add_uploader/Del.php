<?PHP session_start(); ?>
<?PHP
	$ID       = $_GET['ID'];
	$MemberID = $_SESSION['s_MemberID'];
	$contorl_path = "../";
	
	// Include Permission Control file.
	include($contorl_path . "../PermissionControl.php");

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($contorl_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();

	if (($ID != "") && ($MemberID != "") && $memberType >= 3)
	{
		// Delete uploader in e_learning_uploader table
		$sql3 = "DELETE
				 FROM    e_learning_uploader
				 WHERE   member_id = '$ID'";
		
		mysql_query($sql3);
	}

	mysql_close($ln);

	// Redirect to Home Page.
	echo "<script>location.href='index';</script>";
?>
