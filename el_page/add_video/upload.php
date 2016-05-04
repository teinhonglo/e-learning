<?PHP session_start(); ?>
<?php
$isUploaded = false;
if(isset($_POST['submit'])){
	$allowedExts = array("mp4");
	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$file_name = iconv("UTF-8", "big5", "" . $_FILES["file"]["name"]);
	$file_type = $_FILES["file"]["type"];
	$file_size = $_FILES["file"]["size"];
	$file_tmp_name = $_FILES["file"]["tmp_name"];
	$file_error = $_FILES["file"]["error"];

	if ((($file_type == "video/mp4"))
		&& ( $file_size / (1024 * 1024 ) < 1024)
		&& in_array($extension, $allowedExts)){
			
		if ($file_error > 0){
			echo "Return Code: " . $file_error . "<br />";
		}
		else{
			echo "Upload: " . $file_name . "<br />";
			echo "Type: " . $file_type . "<br />";
			echo "Size: " . ($file_size / (1024 * 1024)) . " MB<br />";
			
			$_SESSION['s_VideoName'] 	= $_POST['VideoName'];
			$_SESSION['s_Uploader']		= $_POST['Uploader'];
			$_SESSION['s_VideoPasswd']	= $_POST['VideoPassword'];
			$_SESSION['s_Viewers']		= $_POST['Viewer'];
			$_SESSION['s_StartDate']	= $_POST['StartDate'];
			$_SESSION['s_StopDate']		= $_POST['StopDate'];
			$_SESSION['s_StartTime']	= $_POST['StartTime'];
			$_SESSION['s_StopTime']		= $_POST['StopTime'];
			
			if(isset($_POST['not_start_date'])){
				$_SESSION['not_start_date'] = 1;
			} else{
				$_SESSION['s_StartDate'] = $_POST['StartDate'];
			}
			if(isset($_POST['not_stop_date'])){
				$_SESSION['not_stop_date'] = 1;
			} else{
				$_SESSION['s_StopDate'] = $_POST['StopDate'];
			}
			if(isset($_POST['select_all_people'])){
				$_SESSION['select_all_people'] = 1;
			}
			
			// 取得新名字
			$version = 1;
			$temp_file_name = $file_name;
			
			while(file_exists("../videos/" . $temp_file_name)){
				$temp_file_name = substr($file_name, 0, -4) . "_$version.mp4";
				$version++;
			}
			
			$file_name = $temp_file_name;
			$_SESSION['s_VideoPath'] = $file_name;
			$_SESSION['s_VideoSize'] = $file_size / 1024;
			
			if (file_exists("../videos/" . $file_name)){
				echo  $file_name . " already exists. ";
				echo "<script>parent.$.fancybox.close();alert('Duplicate file name.');location.href='index';</script>";
				exit;
			}else{
				move_uploaded_file($file_tmp_name,
									"../videos/" . $file_name);
				echo "Stored in: " . "/videos/" . $file_name;
				$isUploaded = true;
			}
		}
	}
	else{
		echo "<script>parent.$.fancybox.close();alert('Invalid file(type must be mp4 and size < 1GB).');location.href='index';</script>";
		exit;
	}
	
} else{
	echo "None!";
}

$randomKey = randomkeys(8);
echo "<script>parent.location.href='Add_Action.php?id=$randomKey';</script>";

function randomkeys($length){
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz@#$%^&*&%()";
	$encode_length = strlen($pattern);
	for($i=0; $i < $length; $i++){
		$key .= $pattern{rand(0, $encode_length)};
	}
	return $key;
}

?>