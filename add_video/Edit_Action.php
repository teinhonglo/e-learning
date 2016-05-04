<?PHP session_start(); ?>
<?PHP
$sCharset = 'utf-8';

if ($_POST)
{	
	$control_path = "../";
	date_default_timezone_set('Asia/Taipei');
	
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include($control_path . "SendAssignEmail.php");
		
	// Get InfoID.
	$VideoID 		= $_POST['ID'];
	$VideoTitle		= $_POST['VideoName'];
	$Uploader		= $_POST['Uploader'];
	$ViewerPassword	= $_POST['VideoPassword'];
	$Viewers		= $_POST['Viewer'];
	
	// 是否設不要開始時間
	if(isset($_POST['not_start_date'])){
		$StartDate = "1000-01-01";
	} else{
		$StartDate = $_POST['StartDate'];
	}
	// 是否設不要結束時間
	if(isset($_POST['not_stop_date'])){
		$StopDate = "9999-12-31";
	} else{
		$StopDate = $_POST['StopDate'];
	}
	
	$StartTime		= $_POST['StartTime'];
	$StopTime		= $_POST['StopTime'];
	$isSendMail 	= false;
	$datetime 	  	= date("Y-m-d H:i:s");

	// Check user permission.
	$sql = "SELECT  upload_member_id 
			FROM    e_learning_video_info
			WHERE   video_id = '$VideoID'";
			
	$rs  = mysql_query($sql, $ln);
	$row = mysql_fetch_row($rs);
	$Uploader = $row[0];

	if ($Uploader != $_SESSION['s_MemberID'] && ($_SESSION['s_Level'] != "Administrator"))
	{
		echo "<script>;alert('Sorry !! You do not have permission to access !!');location.href='index.php';</script>";
		exit;
	}
	
	if($VideoName != ""){
		// Update List Sheet table. 
		if (isset($_POST['reset_password'])){
			// Update Table reset Password.
			$sql = "UPDATE  e_learning_video_info 
					SET  	`video_title` = '$VideoName', viewer_password = NULL
					WHERE   video_id = '$VideoID'";
		} else{
			if($ViewerPassword == ""){
				// Update Table without Password.
				$sql = "UPDATE  e_learning_video_info 
						SET  	`video_title` = '$VideoName'
						WHERE   video_id = '$VideoID'";
			} else{
				// Update Table with Password.
				$sql = "UPDATE  e_learning_video_info 
						SET  	video_title = '$VideoName', viewer_password = '$ViewerPassword'
						WHERE   video_id = '$VideoID'";
			}
		}
		
		mysql_query($sql);
		
		// 是否要選取全部人
		if(isset($_POST['select_all_people'])){
			$Viewers = array(0);
			
			/* $sql = "UPDATE e_learning_video_info
					SET open_everyone = 1
					WHERE video_id = $VideoID";
			
			mysql_query($sql, $ln); */
		} else{
			$Viewers = $_POST['Viewer'];
		}
	}
	
	/** Insert video viewer **/
	if($Viewers != "" && $StartDate != "" && $StopDate != ""){
		$isSendMail = true;
		
		// Get Current Maximum ID
		$sql = "SELECT MAX(id)
				FROM e_learning_video_viewer";
		
		$rs = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);
		$curMaxID = $row[0] + 1;
		$viewerMemberID = $curMaxID;
		
		// Initial viewer information, create datetime, check is first or not
		$InsertViewer = "INSERT INTO e_learning_video_viewer (id, member_id, video_id, start_date, stop_date, start_time, stop_time, create_datetime, create_member_id) VALUES";
		$datetime 	  = date("Y-m-d H:i:s");
		$isFirst 	  = true;
		
		foreach($Viewers as $viewer){
			// Process Insert viewer information
			if(!$isFirst){
				$InsertViewer .= ",($viewerMemberID, $viewer, $VideoID, '$StartDate', '$StopDate', '$StartTime', '$StopTime', '$datetime', $Uploader)";
			} else{
				$InsertViewer .= "($viewerMemberID, $viewer, $VideoID, '$StartDate', '$StopDate', '$StartTime', '$StopTime', '$datetime', $Uploader)";
				$isFirst = false;
			}
			$viewerMemberID++;
		}
	}else{
		if($Viewers != "" || $StartDate != "" || $StopDate != ""){
			echo "Please chose <b>video viewer</b> or <b>datetime</b> </br>";
			exit;
		}
	}
	mysql_query($InsertViewer, $ln);
	
	//Send Mail
	if($isSendMail && $Viewers[0] != 0){
		// Select Video uploader English name, e-Mail
		$sql = "SELECT EnglishName
				FROM member
				WHERE MemberID = $Uploader";
		
		$rs = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);
		$UploaderName = $row[0];
		
		// Send email to every video viewer.
		for($sendMemberID = $curMaxID; $sendMemberID < $viewerMemberID; $sendMemberID++){
			// Select Video viewer English name, e-Mail
			$sql = "SELECT 		EnglishName, Mail
					FROM 		e_learning_video_viewer W, member M
					WHERE 		W.member_id = M.MemberID
								AND id = $sendMemberID";
			
			
			$rs = mysql_query($sql, $ln);
			$row = mysql_fetch_row($rs);
			
			$ViewerName = $row[0];
			$AssignedMail = $row[1];
			
			// Convert utf8 to big5
			$VideoTitle = iconv($sCharset, 'big5', $VideoTitle);
			
			$content = CreateAssignVideoContent($ViewerName, $VideoTitle, $StartDate, $StopDate, $StartTime, $StopTime, $UploaderName);
			
			// Convert html content big5 to utf8
			$content = iconv('big5', $sCharset, $content);
			$VideoTitle = iconv('big5', $sCharset, $VideoTitle);
			SendPHPMail($AssignedMail, "您被授權觀看一個新的Video─" . $VideoTitle, $content);
		}
	}
	
	mysql_close($ln);
}
	
// Redirect to Home Page.
echo "<script>parent.$.fancybox.close();parent.location.href='index.php';</script>";
?>