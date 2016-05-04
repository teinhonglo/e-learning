<?PHP session_start(); ?>
<?PHP
$sCharset = 'utf-8';

if ($_GET)
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
	$VideoTitle		= $_SESSION['s_VideoName'];
	$Uploader		= $_SESSION['s_Uploader'];
	$VideoPassword	= $_SESSION['s_VideoPasswd'];
	//echo isset($_SESSION['select_all_people']) . "," . isset($_SESSION['not_start_date']) . "," . isset($_SESSION['not_stop_date']) . "</br>";
	// 是否設不要開始時間
	if(isset($_SESSION['not_start_date'])){
		$StartDate = "1000-01-01";
	} else{
		$StartDate = $_SESSION['s_StartDate'];
	}
	// 是否設不要結束時間
	if(isset($_SESSION['not_stop_date'])){
		$StopDate = "9999-12-31";
	} else{
		$StopDate = $_SESSION['s_StopDate'];
	}
	$StartTime		= $_SESSION['s_StartTime'];
	$StopTime		= $_SESSION['s_StopTime'];
	$VideoSrc		= $_SESSION['s_VideoPath'];
	$VideoSize		= $_SESSION['s_VideoSize'];
	$VideoID		= 0;
	$datetime 		= date("Y-m-d H:i:s");
	$isSendMail 	= false;
	
	if ($Uploader != $_SESSION['s_MemberID'] && ($_SESSION['s_Level'] != "Administrator"))
	{
		echo "<script>;alert('Sorry !! You do not have permission to access !!');location.href='index.php';</script>";
		exit;
	}
	
	/** Insert video table **/
	if($VideoTitle != ""){
		// Insert List Sheet table. 
		$sql = "SELECT MAX(video_id)
				FROM e_learning_video_info";
				
		$rs = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);
		$curMaxID = $row[0] + 1;
		$VideoID = $curMaxID;
		
		// 是否有填入密碼
		if($VideoPassword == ""){
			$sql = "INSERT INTO e_learning_video_info (video_id, video_title, name, size, upload_member_id, upload_datetime)
					VALUES ($curMaxID, '$VideoTitle', '$VideoSrc', $VideoSize, $Uploader, '$datetime')";
		} else{
			$sql = "INSERT INTO e_learning_video_info (video_id, video_title, name, size, upload_member_id, upload_datetime, viewer_password)
					VALUES ($curMaxID, '$VideoTitle', '$VideoSrc', $VideoSize, $Uploader, '$datetime', '$VideoPassword')";
		}
		mysql_query($sql, $ln);
		
		// 是否要選取全部人
		if(isset($_SESSION['select_all_people'])){
			$Viewers = array(0);
			
			/* $sql = "UPDATE e_learning_video_info
					SET open_everyone = 1
					WHERE video_id = $curMaxID";
			
			mysql_query($sql, $ln); */
		} else{
			$Viewers = $_SESSION['s_Viewers'];
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
		$isFirst 	  = true;
		
		foreach($Viewers as $viewer){
			// Process Insert viewer information Comment
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
			echo "<script>;alert('Please chose Video viewer or date time');location.href='index';</script>";
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
	
	unset($_SESSION['s_Viewers']);
	unset($_SESSION['s_VideoPasswd']);
	unset($_SESSION['s_StartDate']);
	unset($_SESSION['s_StopDate']);
	unset($_SESSION['s_VideoPath']);
	unset($_SESSION['s_VideoSize']);
	unset($_SESSION['s_StartTime']);
	unset($_SESSION['s_StopTime']);
	unset($_SESSION['not_start_date']);
	unset($_SESSION['not_stop_date']);
	unset($_SESSION['select_all_people']);
	
	mysql_close($ln);
}
	
// Redirect to Home Page.
echo "<script>location.href='index';</script>";
?>