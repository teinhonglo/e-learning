<?PHP session_start(); ?>
<?PHP
$DatabaseName = "Member";

$data['success'] = 0;

if ($_POST)
{
	// Check post variable(MemberID & Passowrd) isset.
	if ((isset($_POST["englishName"])) && (isset($_POST["password"])))
	{
		// Include database connection file.
		include("../db_Con.php");
		$ln = connectdb();

		// Get login form post variable.
		$englishName = $_POST['englishName'];
		$pw          = $_POST['password'];

		// Select Member data ('binary' keyword to compare password Uppercase & Lowercase).
		$sql = "SELECT  MemberID, PWGID, EnglishName, ChineseName, Mail, DepartmentID, DepartmentName, BU, Level, Active, OnDay 
				FROM    $DatabaseName 
				WHERE   EnglishName = '$englishName' 
				AND     Password    = binary '$pw' 
				AND     Active      = '1'";
		$rs  = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);

		// Check have data.
		if (mysql_num_rows($rs))
		{
			$MemberID       = $row[0];
			$PWGID          = $row[1];
			$EnglishName    = $row[2];
			$ChineseName    = $row[3];
			$Mail           = $row[4];
			$DepartmentID   = $row[5];
			$DepartmentName = $row[6];
			$BU             = $row[7];
			$Level          = $row[8];
			$Active         = $row[9];
			$OnDay          = $row[10];

			// Update Member lastVisitDatetime data.
			$sql = "UPDATE  $DatabaseName 
					SET     LatestVisitDatetime = NOW(), 
					        LoginCount          = LoginCount + 1 
					WHERE   MemberID = '$MemberID'";
			mysql_query($sql, $ln);

			// Set PHP Session variable.
			$_SESSION['s_MemberID']       = $MemberID;
			$_SESSION['s_PWGID']          = $PWGID;
			$_SESSION['s_EnglishName']    = $EnglishName;
			$_SESSION['s_ChineseName']    = $ChineseName;
			$_SESSION['s_Mail']           = $Mail;
			$_SESSION['s_DepartmentID']   = $DepartmentID;
			$_SESSION['s_DepartmentName'] = $DepartmentName;
			$_SESSION['s_BU']             = $BU;
			$_SESSION['s_Level']          = $Level;
			$_SESSION['s_Active']         = $Active;
			$_SESSION['s_OnDay']          = $OnDay;

			// Select Center English Name.
			$EnglishCenter = "";
			$sql = "SELECT  EnglishCenter 
					FROM    Member_Center 
					WHERE   ChineseCenter = '$BU'";
			$rs2  = mysql_query($sql, $ln);
			$row2 = mysql_fetch_row($rs2);
			if (mysql_num_rows($rs2))
			{
				$EnglishCenter = $row2[0];
			}
			$_SESSION['s_EnglishBU'] = $EnglishCenter;

			// Select Department English Name.
			$EnglishDepartment = "";
			$sql = "SELECT  EnglishDepartment  
					FROM    Member_Department 
					WHERE   DepartmentID = '$DepartmentID'";
			$rs2  = mysql_query($sql, $ln);
			$row2 = mysql_fetch_row($rs2);
			if (mysql_num_rows($rs2))
			{
				$EnglishDepartment = $row2[0];
			}
			$_SESSION['EnglishDepartment'] = $EnglishDepartment;

			// Administrator (Read & Write) (Level=99).
			if ($Level == "99")
			{
				$_SESSION['s_Level'] = "Administrator";
			}
			// Read Administrator (Level=98).
			else if ($Level == "98")
			{
				$_SESSION['s_Level'] = "ReadAdministrator";
			}

			$data['success'] = 1;
		}
		else
		{
			// Select Member data ('binary' keyword to compare password Uppercase & Lowercase).
			$sql = "SELECT  *
					FROM    $DatabaseName 
					WHERE   EnglishName = '$englishName' 
					AND     Active      = '0'";
			$rs  = mysql_query($sql, $ln);
			$row = mysql_fetch_row($rs);

			// Check have data.
			if (mysql_num_rows($rs))
			{
				$data['success'] = 2;
			}
		}
	}
}

echo json_encode($data);
?>