<?PHP session_start();?>
<?
	date_default_timezone_set('Asia/Taipei');
	function find_video($random_pass_key, $ln){
		
		$CurDate = date("Y-m-d");
		$CurTime = date("H:i:s");
		
		$VideoID = $_SESSION['s_VideoID'];
		$MemberID = $_SESSION['s_MemberID'];
		
		$sql = "SELECT name
				FROM e_learning_video_info V, e_learning_video_viewer W
				WHERE V.pass_key = '$random_pass_key'
					  AND (W.member_id = $MemberID
					  OR W.member_id = 0)
					  AND V.video_id = W.video_id
					  AND V.video_id = $VideoID
					  AND W.start_date <= '$CurDate'
					  AND W.stop_date >= '$CurDate'
					  AND W.start_time <= '$CurTime'
					  AND W.stop_time >= '$CurTime'";
		
		$rs = mysql_query($sql, $ln);
		
		if(mysql_num_rows($rs) > 0){
			// �X�k���o�v�����|
			$row = mysql_fetch_assoc($rs);
			// �u��v�����|
			$real_src = "../videos/" . $row['name'];
			$ViewDatetime = date("Y-m-d H:i:s");
			
			// �M�żv����pass_key
			$sql = "UPDATE e_learning_video_info
					SET pass_key = NULL
					WHERE video_id = $VideoID";
					
			mysql_query($sql, $ln);
			
			// ���o�ثe�̤j��ID
			$sql = "SELECT MAX(id)
					FROM e_learning_log";
					
			$rs = mysql_query($sql, $ln);
			$row = mysql_fetch_array($rs);
			
			// �s�W�[�ݬ���
			$curMaxID = $row[0] + 1;
			$sql = "INSERT INTO e_learning_log(id, member_id, video_id, view_datetime) 
					VALUES($curMaxID, $MemberID, $VideoID, '$ViewDatetime')";
					
			mysql_query($sql, $ln);
			
			return $real_src;
		}else{
			// �D�k���o�v�����|
			return "Invalid.";
		}
		mysql_close($ln);
	}
?>