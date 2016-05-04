<?PHP session_start(); ?>
<?PHP
	// Get some variable
	$control_path = "../";
	$ID = $_GET['ID'];
	$VideoTitle = $_GET['VideoTitle'];
	$MemberID = $_SESSION['s_MemberID'];
	
	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_video_permission.php");
	$watch_level = watch_permission($ID, $ln);
	if($_SESSION['e_learning_video_password'] == 0){
		if($watch_level > 1){
			
			$sql = "SELECT *
					FROM e_learning_video_info
					WHERE video_id = $ID AND viewer_password IS NULL";
			
			$rs = mysql_query($sql, $ln);
			// 預設密碼不為空
			if(mysql_num_rows($rs) > 0){
				$_SESSION['e_learning_video_password'] = 1;
				$row = mysql_fetch_assoc($rs);
				echo "<script>location.href='../play_video/index?ID=". $row['video_id'] ."&VideoTitle=". $row['video_title']."'</script>";
			}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Password Content - KM</title>
<!--index css-->
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<!--end-->
<link rel="stylesheet" href="../../css/jquery.multiselect2side.css" type="text/css" media="screen" />
<link type="text/css" media="screen" rel="stylesheet" href="../../tipsy/tipsy.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../css/custom-theme/jquery-ui-1.8.8.custom.css" />
<script type="text/javascript" src="../../js/jquery.js" ></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>	
<script type="text/javascript" src="../../js/jquery-ui-1.8.8.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../js/jquery.multiselect2side.js" ></script>
<script type="text/javascript" src="../../tipsy/jquery.tipsy.js"></script>

<style type="text/css">
table
{
	font-family: Calibri, "標楷體";
	color: #000;
}
input[type=text], input[type=submit], input[type=reset], input[type=button]
{
	font: 18pt Calibri, "標楷體";
	color: #000;
	border: #999 1px solid;
	padding-left: 6px;
	padding-right: 6px;
}
textarea
{
	font: 15pt Calibri;
	border: #999 1px solid;
	padding-left: 6px;
	padding-right: 6px;
	padding-top: 4px;
	padding-bottom: 4px;
}
textarea, select, option
{
	font: 15pt Calibri;
	color: #000000;
	border: #999 1px solid;
	padding-left: 6px;
}
</style>
</head>

<body>
<div id="wrapper">
	<div id="featured-wrapper" >
		<div class="extra2 container">
			<br />
<?PHP
	// Select Video Name.
		$sql = "SELECT  video_title
				FROM    e_learning_video_info
				WHERE   video_id = '$ID'";
			
		$rs  = mysql_query($sql, $ln);
		$row = mysql_fetch_row($rs);
		$VideoName = $row[0];
?>
			<table class="List_Video_Table" >
					<tr id="List_Video_Row">
						<thead>
							<tr class="video_title"><td colspan="3" rowspan="2"><?echo $_GET['VideoTitle'];?></td></tr>
						</thead>
					<br>
					<tbody>
						<tr class="video_title"><td colspan="3" rowspan="2">						
							<form name="PassForm" id="PassForm" method="post" action="check_video_password" enctype="multipart/form-data" style="width:100%;height:100%">
								<input name="ID" id="ID" type="hidden" value="<?=$ID;?>" />
								<input name="VideoTitle" id="VideoTitle" type="hidden" value="<?=$VideoTitle;?>" />
								<table align="center" style="width:100%;height:210px">
									<tr style="height:33%;">
										<th colspan="2" align="center" style="width:100%;"><label style="font-size:24pt;">請輸入影片密碼</label></th>
									</tr>
									<tr style="height:33%;">
										<td align="center" style="width:30%;text-align:center;" id="title"><label style="font-size:18pt;" for="viewer_password" >密碼</label></td>
										<td align="left" bgcolor="#FFEEFF" style="width:70%; padding:5px;"><input type="password" name="viewer_password" id="viewer_password" style="width:98%; height:80%;"/></td>
									</tr>
									<tr style="height:34%">
										<td align="right" colspan="2" bgcolor="#FFEEFF" style="padding:5px;">
<?PHP
		if(isset($_GET['password_error']))
		{
?>
											<div style="padding-left:10px;float:left;font-size:18pt;color:#ff0000">密碼錯誤，請重新輸入影片密碼</div>
<?PHP
		}
?>
											<input class="my_button" name="submit" type="submit" value="提交" style="width:20%; height:80%;" />
										</td>
									</tr>
<?PHP
		mysql_close($ln);
?>
								</table>
							</form>
						</td></tr>
					</tbody>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
<?
			}
		} else{
			echo "<script>location.href='../extend_submit?ID=". $ID ."&VideoTitle=". $row['video_title']."'</script>";
		}
	}  else{
		echo "<script>location.href='../index'</script>";
	}
?>