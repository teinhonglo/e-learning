<?PHP session_start(); ?>
<?PHP
	// Include Permission Control file.
	include("../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("../db_Con.php");
	$ln = connectdb();
	
	include("check_e_learning_permission.php");
	$memberType = check_member();
	
	$_SESSION['e_learning_video_password'] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>E-Learning</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
		<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
		<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
		<link rel="icon" type="image/ico" href="images/title_icon.png" />
		<!-- Add jQuery library -->
		<script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>
		<!-- Add mousewheel plugin (this is optional) -->
		<script type="text/javascript" src="lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<!-- Add fancyBox main JS and CSS files -->
		<link type="text/css" media="screen" rel="stylesheet" href="../fancyapps-fancyBox-18d1712/source/jquery.fancybox.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="../js/fancybox/jquery.fancybox-1.3.4.css" />
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.0/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.0/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="../fancyapps-fancyBox-18d1712/source/jquery.fancybox.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".various").fancybox( {
					'openEffect'	: 'fade',
					'closeEffect'	: 'elastic', 
					'type'			: 'iframe', 
					'overlayColor'  : '#000', 
					'autoSize'      : 'false', 
					'width'			: '100%', 
					'height'		: '100%', 
					iframe : {
						preload: false
					},
					'afterClose' : function() {
						parent.location.reload(true);
					}
				});
			});
		</script>
		<style>
			a{
				text-decoration:none
			};
		</style> 
	</head>
	<body>
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="hello_slide"><?echo $_SESSION['s_EnglishName'] . " ";?> 你好，歡迎登入! <a href="../">回到KM</a>&nbsp;&nbsp;&nbsp;<a href="../MemberLogout">登出&nbsp;&nbsp;</a></div>
				<div id="logo">
					<span class="icon icon-group"></span>
					<h1><a href="#">E-Learning</a></h1>
				</div>
				<div id="triangle-up"></div>
			</div>
		</div>
		<div id="menu-wrapper">
				<div id="menu">
					<ul>
						<li class="current_page_item"><a href="#" accesskey="1" title="">首頁</a></li>
		<?
			if($memberType >= 2){
				echo "<li><a href=\"add_video\" accesskey=\"2\" title=\"新增你的影片\">新增上傳影片</a></li>";
			}
		?>
						<li><a href="viewer_list" accesskey="3" title="目前可看的影片清單">我的影片清單</a></li>
						<li><a href="log_list" accesskey="4" title="影片歷程記錄">我的觀看歷程記錄</a></li>
		<?
			if($memberType >= 3)
			{
				echo "<li><a href=\"add_uploader\" accesskey=\"5\" title=\"新增上傳者\">新增上傳者</a></li>";
			}
		?>
						<li><a href="tutorial/E-Learning使用教學.pdf" accesskey="6" title="使用教學" target="_blank">使用教學</a></li>
					</ul>
				</div>
		</div>
		<div id="wrapper">
			<div id="featured-wrapper">
				<div class="extra2 container">
					<table class="List_Video_Table">
						<tr id="List_Video_Row">
							<thead>
								<tr class="video_title"><td colspan="3" rowspan="2"><img src="images/new_icon.png" class="index_icon"></img>最新上傳影片</td></tr>
							</thead>
							<tbody>
								<tr id="video_subtitle"><td>影片名稱</td><td>上傳日期</td><td>上傳者</td></tr>
<?
	$sql = "SELECT 	video_id id,
					video_title, 
					upload_datetime, 
					CONCAT(ChineseName,'(',EnglishName,')') name 
			FROM e_learning_video_info, Member 
			WHERE 	upload_member_id=MemberID
			AND		is_delete = 0
			ORDER BY `upload_datetime` DESC LIMIT 0,10";
			
	$rs = mysql_query($sql, $ln);
	$count = 0;
	while($row = mysql_fetch_assoc($rs)){
		if($count % 2 == 0){
			// odd row
			echo "<tr class=\"video_info_row_odd\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."& VideoTitle=" . $row['video_title'] . "\">" . $row['video_title'] . "</a></td><td>" . $row['upload_datetime'] . "</td><td>" . $row['name'] . "</td></tr>";
		} else{
			// even row
			echo "<tr class=\"video_info_row_even\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."&VideoTitle=" . $row['video_title'] . "\">" . $row['video_title'] . "</a></td><td>" . $row['upload_datetime'] . "</td><td>" . $row['name'] . "</td></tr>";;
		}
		$count++;
	}
?>
							</tbody>
						</tr>
					</table>
					<table class="List_Video_Table">
						<tr id="List_Video_Row">
							<thead>
								<tr class="video_title"><td colspan="3" rowspan="2"><img src="images/hot_icon.png" class="index_icon"></img>最新熱門影片</td></tr>
							</thead>
							<tbody>
								<tr id="video_subtitle"><td>影片名稱</td><td>觀看次數</td><td>上傳者</td></tr>
<?
	$sql = "SELECT 	L.video_id id, 
					video_title, 
					count( L.video_id ) watch, 
					CONCAT( ChineseName, '(', EnglishName, ')' ) name
			FROM e_learning_log L, e_learning_video_info V, Member M
			WHERE 	L.video_id = V.video_id
					AND V.upload_member_id = M.MemberID
					AND V.is_delete = 0
			GROUP BY L.video_id
			ORDER BY count( L.video_id ) DESC
			LIMIT 0 , 10 ";
			
	$rs = mysql_query($sql, $ln);
	$count = 0;
	while($row = mysql_fetch_assoc($rs)){
		if($count % 2 == 0){
			// odd row
			echo "<tr class=\"video_info_row_odd\" value=\"".$row['id']."\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."& VideoTitle=" . $row['video_title'] . "\">". $row['video_title'] . "</a></td><td>" . $row['watch'] . "</td><td>" . $row['name'] . "</td></tr>";
		} else{
			// even row
			echo "<tr class=\"video_info_row_even\" value=\"".$row['id']."\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."& VideoTitle=" . $row['video_title'] . "\">". $row['video_title'] . "</a></td><td>" . $row['watch'] . "</td><td>" . $row['name'] . "</td></tr>";;
		}
		$count++;
	}
?>
							</tbody>
						</tr>
					</table>
					<table class="List_Video_Table">
						<tr id="List_Video_Row">
							<thead>
								<tr class="video_title"><td colspan="3" rowspan="2"><img src="images/click_icon.png" class="index_icon"></img>最新點擊影片</td></tr>
							</thead>
							<tbody>
								<tr id="video_subtitle"><td>影片名稱</td><td>最新點擊時間</td><td>上傳者</td></tr>
<?
	$sql = "SELECT 	V.video_id id,
					V.video_title, 
					MAX(L.view_datetime) view_datetime, 
					CONCAT(M.ChineseName,'(',M.EnglishName,')') name 
			FROM  e_learning_log L, e_learning_video_info V, Member M
			WHERE upload_member_id = MemberID
				  AND L.video_id = V.video_id
				  AND V.is_delete = 0
			GROUP BY L.video_id
			ORDER BY MAX(view_datetime) DESC LIMIT 0,10";
	
	$rs = mysql_query($sql, $ln);
	$count = 0;
	while($row = mysql_fetch_assoc($rs)){
		if($count % 2 == 0){
			// odd row
			echo "<tr class=\"video_info_row_odd\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."& VideoTitle=" . $row['video_title'] . "\">". $row['video_title'] . "</a></td><td>" . $row['view_datetime'] . "</td><td>" . $row['name'] . "</td></tr>";
		} else{
			// even row
			echo "<tr class=\"video_info_row_even\"><td><a class=\"various\" href=\"viewer_list/password_content?ID=".$row['id']."& VideoTitle=" . $row['video_title'] . "\">". $row['video_title'] . "</a></td><td>" . $row['view_datetime'] . "</td><td>" . $row['name'] . "</td></tr>";;
		}
		$count++;
	}
?>
							</tbody>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div id="stamp" class="container">
			<div class="hexagon"><span class="icon icon-wrench"></span></div>
		</div>
		<p align="center" id="bottom_text_style"><b>Contact me：Tien-Hong Lo</b></p>
		<div id="copyright" class="container"></div>
	</body>
</html>
