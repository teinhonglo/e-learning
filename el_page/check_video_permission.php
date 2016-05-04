<?PHP session_start(); ?>
<?PHP
	$sCharset = 'utf8';
	
	date_default_timezone_set('Asia/Taipei');
	
	function watch_permission($VideoID, $ln){
		$CurDate = date("Y-m-d");
		$CurTime = date("H:i:s");
		$MemberID = $_SESSION['s_MemberID'];
		$VideoID = $VideoID;
		
		$sql = "SELECT *
				FROM e_learning_video_viewer
				WHERE video_id = $VideoID
					AND (member_id = $MemberID
						OR  member_id = 0)";

		$rs = mysql_query($sql, $ln);	
		if(mysql_num_rows($rs) > 0){
			// Author member
			$sql = "SELECT video_title
					FROM e_learning_video_viewer W, e_learning_video_info V
					WHERE 	W.video_id = $VideoID
						AND W.video_id = V.video_id
						AND start_date <= '$CurDate'
						AND stop_date >= '$CurDate'
						AND start_time <= '$CurTime'
						AND stop_time >= '$CurTime'
						AND (member_id = $MemberID
						OR member_id = 0)";
			
			$rs = mysql_query($sql, $ln);
			
			if(mysql_num_rows($rs) > 0){
				// In time
				return 2;
			} else{
				// Out of time
				return 1;
			}
		} else{
			// Not in Author
			return 0;
		}
	}
?>