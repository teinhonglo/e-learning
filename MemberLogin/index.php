<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM Login</title>
<link rel="stylesheet" type="text/css" media="screen" href="../css/css.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../tipsy/tipsy.css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready( function() {
	// Focus on English Name
    setTimeout( function() {
        $('#englishName').focus();
    });

	$('#englishName').tipsy({trigger:'focus', gravity:'s', html:true, fade:true});
	$('#password').tipsy({trigger:'focus', gravity:'s', html:true, fade:true});
//	$('#captcha').tipsy({gravity:'s', html:true, fade:true});
//	$('#captcha_code').tipsy({trigger:'focus', gravity:'s', html:true, fade:true});
	$('#logo').tipsy({gravity:'s', html:true, fade:true});

	$('#MemberLoginForm').submit( function() {
		// Check user name & password
		if ($('#englishName').val() == "" && $('#password').val() == "")
		{
			alert("Please enter your English Name & Password !!");
			$('#englishName').focus();
			return false;
		}
		// Check memberID
		else if ($('#englishName').val() == "")
		{
			alert("Please enter your English Name !!");
			$('#englishName').focus();
			return false;
		}
		// Check password
		else if ($('#password').val() == "")
		{
			alert("Please enter your Password !!");
			$('#password').focus();
			return false;
		}
/*
		// Check verify
		else if ($('#captcha_code').val() == "")
		{
			alert("Please enter verify code !!");
			$('#captcha_code').focus();
			return false;
		}
*/
		// Send form data
		else
		{
/*
			// Vailid verify code
			$.post('verifyCodeCheck.php', { captcha_code:$('#captcha_code').val() }, function(data) {
				if (data.success == 0)
				{
					alert('The veridy code you entered was incorrect. \nPlease try again.');
					$('#captcha_code').val('');

					// Refresh verifry code
					document.getElementById('captcha').src = '../verify/securimage_show_4char.php?' + Math.random();
					return false;
				}
				else
				{
					// Submit
					checkSubmit();
				}
			}, 'json');
*/
			// Submit
			checkSubmit();
		}

		return false;
	});

	// Submit form function
	function checkSubmit()
	{
		// Post form data
		$.post('MemberLogin.php', {englishName:$('#englishName').val(), password:$('#password').val()}, function(data) {
			// Login OK
			if (data.success == 1)
			{
				if ( $('#PrePageURL').val() != "" )
				{
					location.href = $('#PrePageURL').val();
				}
				else
				{
					//location.href = '../TaskManagement/';
					location.href = '../';
				}
			}
			// Account inactive.
			else if (data.success == 2)
			{
				var account = $('#englishName').val();
				$('#englishName').val('');
				$('#password').val('');
				$('#englishName').focus();
				alert('Sorry !! Your \'' + account + '\' account is not activated !!\n\nPlease contact the administrator to activate your account !!\n\nAdministrator contact info :\nKimi Lin\n+886-2-7731-8888 ext.8258\nkimi.lin@portwell.com.tw');
			}
			// Login failed
			else
			{
				$('#englishName').val('');
				$('#password').val('');
//				$('#captcha_code').val('');
				$('#englishName').focus();
				alert('Sorry !!\nLogin failed !!\nPlease Re-Login !!');

/*
				// Refresh verifry code
				document.getElementById('captcha').src = '../verify/securimage_show_4char.php?' + Math.random();
				return false;
*/
			}
		}, 'json');
	}
});
</script>
</head>

<body>
<div style="position:absolute; width:500px; height:300px; left:50%; top:50%; margin:-140px 0 0 -250px;">
	<form name="MemberLoginForm" id="MemberLoginForm" method="POST" action="MemberLogin.php" style="margin:0px; padding:0px;">
		<input type="hidden" name="PrePageURL" id="PrePageURL" value="<?=$_GET['PrePageURL'];?>" />
		<table align="center" valign="middle" width="340" border="1" bordercolor="#641B6C" style="border-collapse:collapse; border:2px solid #641b6c;">
			<tr height="41">
				<th width="348" height="42" background="images/table_header.png" style="color:#FFF;"><center><label style="font-size:22px; font-weight:bold; font-family:Calibri;">Portwell KM System Login</label></center></th>
			</tr>
			<tr>
				<td style="margin:4px; padding:4px;">
					<table width="351" style="border:none; margin:0; padding:0;">
						<tr>
							<td width="70" height="70" rowspan="3" align="center" valign="middle" style="border:none;"><img id="logo" src="../images/Portwell_Icon.png" style="margin:0; padding:0;" title="Welcome to Portwell KM System" /></td>
							<td height="36" align="right" style="border:none;" valign="middle"><label for="englishName" style="font-size:17px; font-family:Calibri;">English Name : </label>&nbsp;<input type="text" name="englishName" id="englishName" style="width:121px; height:26px; font-size:12pt; margin-top:4px; font-family:Calibri;" title="Ex : kimi.lin" /></td>
						</tr>
						<tr>
							<td height="36" align="right" style="border:none;" valign="middle"><label for="password" style="font-size:17px; font-family:Calibri;">Password : </label>&nbsp;<input type="password" name="password" id="password" style="width:121px; height:26px; font-size:12pt; font-family:Calibri;" title="PS : At least 4 characters" /></td>
						</tr>
<!--
						<tr align="right">
							<td height="36" align="right" style="border:none;"><a href="#" onClick="document.getElementById('captcha').src = '../verify/securimage_show_4char.php?' + Math.random(); return false;"><img id="captcha" src="../verify/securimage_show_4char.php" alt="Verify Image" border="0" title="Click! To Refresh Image." /></a>&nbsp;&nbsp;<input type="text" name="captcha_code" id="captcha_code" maxlength="4" style="width:54px; height:25px;" title="Enter left Verify Code" /></td>
						</tr>
-->
						<tr align="right" valign="middle" height="40">
							<td colspan="2" style="border:none;">
								<input type="submit" name="login" id="login" value="Login" style="font-size:16px; width:74px; height:36px; margin-top:2px; margin-bottom:5px; font-family:Calibri;" />&nbsp;&nbsp;
								<input type="reset" name="reset" value="Reset" style="font-size:16px; width:72px; height:36px; margin-top:2px; margin-bottom:5px; font-family:Calibri;" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>