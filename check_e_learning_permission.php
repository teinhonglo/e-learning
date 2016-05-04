<?PHP session_start(); ?>
<?
	function check_member(){
		$ln = connectdb();
		$member_level = 0;
		if($_SESSION['s_Level'] == "Administrator"){
			$member_level = 3;
		}else{
			// Check is Uploader or Not
			$sRecord = "SELECT *
						FROM e_learning_uploader
						WHERE member_id = " . $_SESSION['s_MemberID'];
						
			$rs = mysql_query($sRecord, $ln);
			
			if(mysql_num_rows($rs) > 0){
				$member_level = 2;
			} else{
				$member_level = 1;
			}
		}
		return $member_level;
		mysql_close($ln);
	}
?>