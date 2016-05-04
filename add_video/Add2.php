<?PHP session_start(); ?>
<?PHP
	// Get ID.
	$control_path = "../";
	$ID = $_GET['ID'];

	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include("_DBTable.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	if($memberType >= 2){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Video or Viewer</title>
<!-- homepage css -->
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<!-- end-->
<link rel="stylesheet" href="../../css/jquery.multiselect2side.css" type="text/css" media="screen" />
<link type="text/css" media="screen" rel="stylesheet" href="../../tipsy/tipsy.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../css/custom-theme/jquery-ui-1.8.8.custom.css" />
<script type="text/javascript" src="../../js/jquery.js" ></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>	
<script type="text/javascript" src="../../js/jquery-ui-1.8.8.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../js/jquery.multiselect2side.js" ></script>
<script type="text/javascript" src="../../tipsy/jquery.tipsy.js"></script>
<!--TimePicker-->
<script type="text/javascript" src="jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.timepicker.css" />
<!--TimePicler END-->
<script language="javascript" type="text/javascript">
$(document).ready( function() {
	$('#Viewer').tipsy({gravity: 's', html: true, fade: true});

	// Setup no cache.
	$.ajaxSetup({ cache: false });

	// Focus.
	setTimeout( function() {
		$('#VideoName').focus();    
	});
	
	// Start Datepicker Prevent exception
	$(".StartDate").datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect:function(dateText,inst){
			$(".StopDate").datepicker("option","minDate",dateText);
		}
	});
	// Stop Datepicker Prevent exception
	$(".StopDate").datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect:function(dateText,inst){
			$(".StartDate").datepicker("option","maxDate",dateText);
		}
	});

	// Tip.
	$('.Tip').tipsy({gravity: 's', html: true, fade: true});

	$('#Viewer').multiselect2side({
		search: "Search: "
	});
	
	$('#AddForm').submit( function() {
		// Video Name must have at least one character.
		if ($('#VideoName').val() == "")
		{
			alert("Video Name Cannot be empty!!");
			$('#VideoName').focus();
			return false;
		}
	});
	//Hide or Show Viewer list
	$('#select_all_people').change(function(){
		if($(this).attr('checked')){
			$('#select_all_people_list').hide();
		}else{
			$('#select_all_people_list').show();
		}
	});
	// Hide or Show Start date
	$('#not_start_date').change(function(){
		if($(this).attr('checked')){
			$('#StartDate').hide();
		}else{
			$('#StartDate').show();
		}
	});
	// Hide or Show Stop date
	$('#not_stop_date').change(function(){
		if($(this).attr('checked')){
			$('#StopDate').hide();
		}else{
			$('#StopDate').show();
		}
	});
});
</script>
<style type="text/css">
table
{
	font-family: Calibri, "標楷體";
	color: #000;
}
input[type=text]
{
	font: 13pt Calibri;
	border: #999 1px solid;
	padding-left: 6px;
	padding-right: 6px;
}

input[type=submit], input[type=reset], input[type=button]
{
	font: 15pt Calibri ,"標楷體";
	color: #000;
	border: #999 1px solid;
	padding-left: 6px;
	padding-right: 6px;
}
textarea
{
	font: 13pt Calibri;
	border: #999 1px solid;
	padding-left: 6px;
	padding-right: 6px;
	padding-top: 4px;
	padding-bottom: 4px;
}
textarea, select, option
{
	font: 13pt Calibri;
	color: #000000;
	border: #999 1px solid;
	padding-left: 6px;
}
</style>
</head>

<body>
<div id="wrapper">
	<div id="featured-wrapper">
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
			<form name="AddForm" id="AddForm" method="post" action="upload" enctype="multipart/form-data">
				<input name="ID"id="ID" type="hidden" value="<?=$ID;?>" />
				<table align="center" width="680">
					<tr height="46">
							<th colspan="2" align="center"><label style="font-size:18pt;">新增影片</label></th>
					</tr>
					<tr height="54">
						<td align="center" style="width:160px; height:20px;" id="title"><label style="font-size:14pt;" for="VideoName"><span class="require">*</span>影片名稱</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;"><input type="text" name="VideoName" id="VideoName" style="width:470px; height:30px;" value="<?=$VideoName;?>" placeholder="請填入影片名稱" Maxlength="30" /></td>
					</tr>
					<!--Edit-->
					<tr height="54">
						<td align="center" style="width:160px; height:20px;" id="title"><label style="font-size:14pt;" for="VideoName"><span class="require">*</span>上傳影片檔(MP4)</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;">
						<input type="file" name="file" id="file" /><br /></td>
					</tr>
					<tr height="54">
						<td align="center" style="width:160px; height:20px;" id="title"><label style="font-size:14pt;" for="VideoPassword" >密碼</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;"><input type="text" name="VideoPassword" id="VideoPassword" style="width:470px; height:30px;" placeholder="空白代表不設定密碼" Maxlength="20"/></td>
					</tr>
					<!--Edit end-->
					<tr height="54">
						<td align="center" style="width:75x; height:20px;" id="title"><label style="font-size:14pt;" for="Uploader"><span class="require">*</span> 上傳者</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;">
							<select name="Uploader" id="Uploader" style="width:484px; height:36px;">
<?PHP
				$MemberID	 = $_SESSION['s_MemberID'];
				$EnglishName = $_SESSION['s_EnglishName'];
				$ChineseName = $_SESSION['s_ChineseName'];
?>
								<option value="<?=$MemberID;?>" "selected" ><?=$EnglishName;?> (<?=$ChineseName?>) </option>
<?PHP
				
?>
							</select>
						</td>
					</tr>
					<tr height="186">
						<td align="center" style="width:75x; height:20px;" id="title"><label style="font-size: 14pt;" for="Viewer"><span class="require"></span> 影片觀看者</label></td>
						<td align="left" bgcolor="#FFEEFF" style="padding:10px;">
							<label style="font-size:14pt;" for="Viewer"><input type="checkbox" id="select_all_people" name="select_all_people" value="select_all_people" title="選取全部觀看者"/>全部觀看者<label>
							<div id="select_all_people_list">
								<select name="Viewer[]" id="Viewer"  multiple="multiple" hidden="true">
<?PHP
				// Select Member List.
				$sql3 = "SELECT    MemberID, EnglishName, ChineseName 
						 FROM      Member";
						 
				$rs3  = mysql_query($sql3, $ln);
				if (mysql_num_rows($rs3))
				{
					while ($row3 = mysql_fetch_row($rs3))
					{
?>
									<option value="<?=$row3[0];?>"><?=$row3[1];?> (<?=$row3[2];?>)</option>
<?PHP
					}
				}
?>
								</select>
							</div>
						</td>
					</tr>
					<tr height="54">
						<td align="center" style="width:75x; height:20px;" id="title"><label style="font-size:14pt;" for="Date"><span class="require"></span>開始日期</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;"><label style="font-size:14pt;" for="Date"><input type="checkbox" id="not_start_date" name="not_start_date" value="not_start_date" title="不設開始時間"/>不設開始時間<label><input type="text" name="StartDate" id="StartDate" style="width:470px; height:30px;" class="StartDate" value="<?=$row[6];?>" /></td>
					</tr>
					<tr height="54">
						<td align="center" style="width:75x; height:20px;" id="title"><label style="font-size:14pt;" for="Date"><span class="require"></span>結束日期</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;"><label style="font-size:14pt;" for="Date"><input type="checkbox" id="not_stop_date" name="not_stop_date" value="not_stop_date" title="不設結束時間"/>不設結束時間<label><input type="text" name="StopDate" id="StopDate" style="width:470px; height:30px;" class="StopDate" value="<?=$row[6];?>" /></td>
					</tr>
					<tr height="54">
						<td align="center" style="width:75x; height:20px;" id="title"><label style="font-size:14pt;" for="Date"><span class="require"></span> 時間區段</label></td>
						<td bgcolor="#FFEEFF" style="padding:10px;">
							<select name="StartTime" id="StartTime" type="text" class="time">
<?PHP
	$time_range_hour = 0;
	$time_range_minute = 0;
	$time_range = "";
	$isSelected = false;
	
	while($time_range_hour < 24){
		// 小時小於10補0
		if($time_range_hour < 10){
			$time_range = "0" . $time_range_hour . ":";
		}else{
			$time_range = "" . $time_range_hour . ":";
		}
		// 分鐘小於10補0
		if($time_range_minute < 10){
			$time_range .= "0" . $time_range_minute . ":00";
		}else{
			$time_range .= "" . $time_range_minute . ":00";
		}
		// 呈現每個時間區段
		if(!$isSelected){
			echo 	"<option value=\"$time_range\">$time_range</option>";
		} else{
			echo 	"<option value=\"$time_range\" selected=true>$time_range</option>";
			$isSelected = false;
		}
		// 每次以30分鐘為單位
		if($time_range_minute == 0){
			$time_range_minute = 30;
		}else{
			$time_range_minute = 0;
			$time_range_hour++;
			// 上班時間 9:00
			if($time_range_hour == 9){
				$isSelected = true;
			}
		}
	}
?>
						</select>&nbsp;<b>to&nbsp;</b>
						<select name="StopTime" id="StopTime" type="text" class="time"/>
<?PHP
	$time_range_hour = 0;
	$time_range_minute = 0;
	$time_range = "";
	$isSelected = false;
	
	while($time_range_hour < 24){
		// 小時小於10補0
		if($time_range_hour < 10){
			$time_range = "0" . $time_range_hour . ":";
		}else{
			$time_range = "" . $time_range_hour . ":";
		}
		// 分鐘小於10補0
		if($time_range_minute < 10){
			$time_range .= "0" . $time_range_minute . ":00";
		}else{
			$time_range .= "" . $time_range_minute . ":00";
		}
		// 呈現每個時間區段
		if(!$isSelected){
			echo 	"<option value=\"$time_range\">$time_range</option>";
		} else{
			echo 	"<option value=\"$time_range\" selected=true>$time_range</option>";
			$isSelected = false;
		}
		// 每次以30分鐘為單位
		if($time_range_minute == 0){
			$time_range_minute = 30;
		}else{
			$time_range_minute = 0;
			$time_range_hour++;
			// 下班時間 18:00
			if($time_range_hour == 18){
				$isSelected = true;
			}
		}
	}
?>
						</select>
						</td>
					</tr>
					<tr height="54">
						<td align="right" colspan="2" bgcolor="#FFEEFF" style="padding:10px;">
							<input class="my_button" name="submit" type="submit" value="上傳" style="width:86px; height:38px" />&nbsp;&nbsp;
							<input class="my_button" type="reset" value="清除" style="width:86px; height:38px" />&nbsp;&nbsp;
							<input class="my_button" type="button" value="關閉" style="width:86px; height:38px" onclick="parent.$.fancybox.close();" />
						</td>
					</tr>
<?PHP
	mysql_close($ln);
?>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<?PHP
	} else{
		echo "<script>parent.location.href='../';</script>";
	}
?>