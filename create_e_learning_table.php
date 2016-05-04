<?PHP session_start(); ?>
<?PHP
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
	date_default_timezone_set('Asia/Taipei');
	// Include Permission Control file.
	include("../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("../db_Con.php");
	$ln = connectdb();
	
	include("check_e_learning_permission.php");
	$memberType = check_member();
	
	if($memberType >= 3){		
		// Drop uploader table
		$sql = "DROP TABLE e_learning_uploader";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_uploader");
		
		// Drop viewer table
		$sql = "DROP TABLE e_learning_video_viewer";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_video_viewer");
		
		// Drop Information about video table
		$sql = "DROP TABLE e_learning_video_info";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_video_info");
		
		// Drop log table
		$sql = "DROP TABLE e_learning_log";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_log");
		
		/* /**
		// Drop uploader_video table(relationship)
		$sql = "DROP TABLE e_learning_uploader_video";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_uploader_video");
		
		// Drop viewr_video table(relationship)
		$sql = "DROP TABLE e_learning_viewer_video";
		printRelsult(mysql_query($sql, $ln), "Drop", "e_learning_viewer_video");
		**/
		
		// Create uploader table	
		$sql = "CREATE TABLE e_learning_uploader(
					member_id 			INT(10)	UNSIGNED,
					register_datetime 	DATETIME,
					PRIMARY KEY(member_id)
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_uploader");
		
		// Create Information about video table	
		$sql = "CREATE TABLE e_learning_video_info (
					video_id 			INT(10) 	UNSIGNED,
					pass_key 			VARCHAR(32) NULL,
					video_title			VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
					name 				VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
					size 				INT(11)		UNSIGNED,
					upload_member_id	INT(10) 	UNSIGNED,
					upload_datetime		DATETIME,
					viewer_password		VARCHAR(20)	NULL,
					is_delete			INT(1) DEFAULT 0,
					open_everyone		INT(1) DEFAULT 0,
					PRIMARY KEY(video_id),
					FOREIGN KEY(upload_member_id) REFERENCES e_learning_uploader(member_id) ON DELETE CASCADE
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_video_info");
		
		// Create viewer table	
		$sql = "CREATE TABLE e_learning_video_viewer (
					id					INT(10)		UNSIGNED,
					member_id 			INT(10) 	UNSIGNED,
					video_id	 		INT(10)		UNSIGNED,
					start_date	 		DATE,
					start_time 			TIME,
					stop_date			DATE,
					stop_time			TIME,
					create_datetime		DATETIME,
					create_member_id	INT(10),
					PRIMARY KEY(id),
					FOREIGN KEY(create_member_id) 	REFERENCES e_learning_uploader(member_id) ON DELETE CASCADE,
					FOREIGN KEY(video_id) 			REFERENCES e_learning_video_info(video_id) ON DELETE CASCADE
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_video_viewer");
		
		// Create log table
		$sql = "CREATE TABLE e_learning_log (
					id				INT(10)		UNSIGNED,
					video_id 		INT(10) 	UNSIGNED,
					member_id 		INT(10) 	UNSIGNED,
					view_datetime	DATETIME,
					PRIMARY KEY(id),
					FOREIGN KEY(video_id) REFERENCES e_learning_video_info(video_id),
					FOREIGN KEY(member_id) REFERENCES e_learning_video_viewer(member_id)
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_log");
		/*
			Relationship
		
		// Create uploader_video table(relationship)
		$sql = "CREATE TABLE e_learning_uploader_video(
					MemberID 	INT(10)		UNSIGNED,
					VideoID 	INT(10) 	UNSIGNED
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_uploader_video");
		
		// Create viewr_video table(relationship)
		$sql = "CREATE TABLE e_learning_viewer_video(
					MemberID 	INT(10)		UNSIGNED,
					VideoID 	INT(10) 	UNSIGNED,
					Alive		INT			UNSIGNED
				)";
		printRelsult(mysql_query($sql, $ln), "Create", "e_learning_uploader_video");
		*/
		// Insert initialization admin
		
		$datetime = date("Y-m-d H:i:s");
		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		$sql = "INSERT INTO e_learning_uploader (member_id, register_datetime)
				VALUES (272, '" . $datetime ."') ";
		
		$sql = "INSERT INTO e_learning_uploader (member_id, register_datetime)
				VALUES (801, '" . $datetime ."') ";
		printRelsult(mysql_query($sql, $ln), "Insert Value in", "uploader");
		
		/*
		$sql = "INSERT INTO e_learning_video_info (video_id, video_title, name, size, upload_member_id, upload_datetime)
				VALUES (1, '數學中的愛情(TED)','TED_LOVE_IN_MATH.mp4', 155, 801, '" . $datetime ."')";
		printRelsult(mysql_query($sql, $ln), "Insert Value in", "video_info");
		
		$sql = "INSERT INTO e_learning_video_info (video_id, video_title, name, size, upload_member_id, upload_datetime)
				VALUES (2, '神秘的海鷗', 'oceans.mp4', 15, 767, '" . $datetime ."')";
		printRelsult(mysql_query($sql, $ln), "Insert Value in", "video_info");
		*/
		/* 
		$sql = "INSERT INTO e_learning_video_viewer (id, member_id, video_id, start_date, start_time, stop_date, stop_time, create_datetime,create_member_id)
				VALUES (1, 801, 1, '$date', '$time', '$date', '$time', '$datetime', 798)";
		
		printRelsult(mysql_query($sql, $ln), "Insert Value in", "e_learning_video_viewer"); 
		*/
		
		function printRelsult($success, $action, $tableName){
			if ($success === true){
				echo $action . " " .$tableName. " table is OK!" . "</br>";
			}else{
				echo $action . " " .$tableName. "  table is Failure!" . "</br>";
			}
		}
	}
	mysql_close($ln);
?> 