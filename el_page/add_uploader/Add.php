<?PHP session_start(); ?>
<?PHP
	// Page start time.
	$pagestartime = microtime();
	
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	Check_Login();
	
	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	if($memberType >= 3){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Uploader - KM</title>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<link type="text/css" media="screen" rel="stylesheet" href="../../css/css.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../css/custom-theme/jquery-ui-1.8.8.custom.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../tipsy/tipsy.css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>	
<script type="text/javascript" src="../../js/jquery-ui-1.8.8.custom.min.js"></script>
<script type="text/javascript" src="../../tipsy/jquery.tipsy.js"></script>
</head>

<body>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form name="AddForm" id="AddForm" method="post" action="Add_Action">
				<br />
				<center><label id="my_sub_module_title" style="color:#000;">e-learning system</label></center>
				<br />
				<table align="center" width="860">
					<tr height="50">
						<th style="background:none; background-color:#641b6c;"><label style="font-size:20px;">Update Uploader List</label></th>
					</tr>
					<tr height="180">
						<td width="100%" height="80%" bgcolor="#FFFF99">
							<table width="100%" height="100%" style="border-style:none;">
								<tr width="50%">
									<td align="left" style="border-style:none;"><input type="radio" name="AddMMType" id="New" value="New" checked="checked" /> <label for="New" style="font-size:16px; font-weight:bold; color:#F00;">新增上傳的人.</label><br /></td>
									<td>
									<select name="Uploader[]"  style="width:484px; height:140px;" multiple>
<?PHP
			// Select Member List.
			$MemberID       = $_SESSION['s_MemberID'];
			$sql = "SELECT    MemberID, EnglishName, ChineseName 
					FROM      Member";
			
			$rs  = mysql_query($sql, $ln);
			if (mysql_num_rows($rs))
			{
				while ($row = mysql_fetch_row($rs))
				{
?>
								<option value="<?=$row[0];?>" <?PHP if($AddMMType == "Copy"){ if($row[0] == $oldRow[2]){echo "selected";}} else { if($row[0] == $_SESSION['s_MemberID']){echo "selected";} } ?>><?=$row[1];?> (<?=$row[2];?>) </option>
<?PHP
				}
			}
?>
									</select>
								</td>
								</tr>
								
							</table>
						</td>
						
					</tr>
					<tr height="54">
						<td align="right" bgcolor="#641B6C">
							<input type="submit" value="Add" style="width:90px; height:38px" />&nbsp;&nbsp;
							<input type="button" value="Close" style="width:90px; height:38px" onclick="parent.$.fancybox.close();" />
						</td>
					</tr>
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