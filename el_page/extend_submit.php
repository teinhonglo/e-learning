<?PHP session_start(); ?>
<?PHP
	$sCharset = 'utf8';
	// Include Permission Control file.
	include("../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("../db_Con.php");
	$ln = connectdb();
	
	include("check_e_learning_permission.php");
	$memberType = check_member();
	
	$VideoID = $_GET['ID'];
	$VideoTitle = $_GET['VideoTitle'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-learning</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
<script src="dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
<script>
	/* $(document).ready( function() {
		$('#send_request_email').submit(function(){
			sweetAlert("Good job!", "You clicked the button!", "success");
		});
	}); */
</script>
</head>
<body>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form action="send_request_email" method="post">
				<table class="List_Video_Table">
					<thead>
						<tr class="video_title"><td colspan="3" rowspan="2"></img>影片資訊</td></tr>
					</thead>
					<tr id="video_subtitle"><td>影片名字</td><td>上傳者</td><td>上傳日期</td></tr>
					<tbody>
<?
	$sql = "SELECT 	video_id id,
					video_title,
					CONCAT(ChineseName,'(',EnglishName,')') name,
					upload_datetime
			FROM 	e_learning_video_info, Member
			WHERE 	upload_member_id = MemberID
					AND video_id = $VideoID";
	
	$rs = mysql_query($sql, $ln);

	while($row = mysql_fetch_assoc($rs)){
		echo "<tr class=\"video_info_row_odd\"><td><input name=\"video_id\" type=\"hidden\" value=\"". $row['id'] ."\">" . $row['video_title'] . "</td><td>" . $row['name'] . "</td><td>" . $row['upload_datetime'] . "</td></tr>";
	}
	
	mysql_close($ln);
?>
					</tbody>
					<thead>
						<tr id="video_subtitle" style="padding:5px;height:50px"><td colspan="3"><input name="submit" type="submit" value="申請觀看權限" style="width:15%; height:45px; font-size:20px; font-family:Microsoft JhengHei, 標楷體 , sans-serif;" /></td></tr>
					</thead>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>
