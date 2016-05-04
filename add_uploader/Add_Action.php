<?PHP session_start(); ?>
<?PHP
$data['success'] = 0;
if ($_POST)
{
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	// Get post variable data.
	$Uploaders    = $_POST['Uploader'];
	$InsertSql 	 = "INSERT INTO e_learning_uploader (member_id, register_datetime)";
	$datetime = date("Y-m-d H:i:s");
	$count = false;
	foreach( $Uploaders as $uploader){
	// Check Meeting already exist.
	$sql = "SELECT  *
			FROM    $DatabaseName
			WHERE   member_id 	= '". $uploader . "'";
			$rs = mysql_query($sql, $ln);
			if(mysql_num_rows($rs)){
				echo "The Member ID ". $Uploaders . " is already in Uploader List" . "</br>";
				continue;
			} else{
				if($count){
					$InsertSql .= ",(" . $uploader . ", '" . $datetime ."')";
				}
				else{
					$InsertSql .= "VALUES (" . $uploader . ", '" . $datetime ."')";
					$count = true;
				}
				echo $uploader . "is success update!" . "</br>";
			}
	}
	
	if (mysql_query($InsertSql, $ln)){
		$data['success'] = 1;
	} else{
		$data['success'] = 0;
	}
	mysql_close($ln);
}

// Redirect to Home Page.
echo "<script>parent.$.fancybox.close();location.href='index';</script>";
?>