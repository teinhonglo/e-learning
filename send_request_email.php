<?PHP session_start(); ?>
<?PHP
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	
	$sCharset = 'utf-8';
	// Include Permission Control file.
	include("../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("../db_Con.php");
	$ln = connectdb();
	
	include("check_e_learning_permission.php");
	$memberType = check_member();
	
	include("SendAssignEmail.php");
	
	if(isset($_POST['video_id'])){
		$VideoID = $_POST['video_id'];
		// Select Information about video
		$sql = "SELECT 	video_title,
						EnglishName name,
						Mail
				FROM 	e_learning_video_info, Member
				WHERE 	upload_member_id = MemberID
						AND video_id = $VideoID";
		
		$rs = mysql_query($sql, $ln);
		while($row = mysql_fetch_assoc($rs)){
			$RequestMember = $_SESSION['s_ChineseName'] . "(" . $_SESSION['s_EnglishName'] . ")";
			$AssignedMember = $row['name'];
			$VideoTitle = $row['video_title'];
			$AssignedMail = $row['Mail'];
			
			// Convert utf8 to big5
			$VideoTitle = iconv($sCharset, 'big5', $VideoTitle);
			$RequestMember = iconv($sCharset, 'big5', $RequestMember);
			
			// Process Sender Information
			$content = CreateRequestVideoContent($RequestMember, $VideoTitle, $AssignedMember);
			
			// Convert html content big5 to utf8
			$content = iconv('big5', $sCharset, $content);
			$VideoTitle = iconv('big5', $sCharset, $VideoTitle);
			SendPHPMail($AssignedMail, "您被請求開放新的影音權限─" . $VideoTitle, $content);
		}
		mysql_close($ln);
	}
	echo "<script>alert('申請成功，請耐心等待開啟權限');parent.close();parent.location.href=\"index\"</script>";
?>