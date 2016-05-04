<?PHP
	session_start();
?>
<?php
	function curPageURL()
	{
		$pageURL = 'http';

		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";

		if ( $_SERVER["SERVER_PORT"] != "80" )
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}

		return $pageURL;
	}
	function curSystemURL()
	{
		$pageURL = 'http';

		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";

		if ( $_SERVER["SERVER_PORT"] != "80" )
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		}
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"];
		}

		return $pageURL;
	}
?>
<?PHP
// Check InfoID.
	function Check_InfoID_Parameter( $InfoID )
	{
		if ( $InfoID == "" || (!isset($InfoID)) || $InfoID == NULL )
		{
			echo "<center><h3>Sorry !!<br>Your parameter is not correct !!</h3></center>";
			exit;
		}
	}
	function Have_InfoID_Parameter( $InfoID )
	{
		if ( $InfoID == "" || (!isset($InfoID)) || $InfoID == NULL )
			return false;
		else
			return true;
	}


// Check Log-in.
	function Check_Login()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) && 
			 (strcmp($_SESSION['s_Level'], "2") != 0) && 
			 (strcmp($_SESSION['s_Level'], "3") != 0) && 
			 (strcmp($_SESSION['s_Level'], "4") != 0) && 
			 (strcmp($_SESSION['s_Level'], "Administrator") != 0) && 
			 (strcmp($_SESSION['s_Level'], "ReadAdministrator") != 0) 
  		   )
		{
			//echo "<center><h3>Sorry !!<br>You are not Log-in !!</h3></center>";
			echo "<script>parent.document.location.href='".curSystemURL()."/KM/MemberLogin/?PrePageURL=".curPageURL()."';</script>";
			exit;
		}
	}
	// No direct to PrePageURL.
	function Check_Login2()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) && 
			 (strcmp($_SESSION['s_Level'], "2") != 0) && 
			 (strcmp($_SESSION['s_Level'], "3") != 0) && 
			 (strcmp($_SESSION['s_Level'], "4") != 0) && 
			 (strcmp($_SESSION['s_Level'], "Administrator") != 0) && 
			 (strcmp($_SESSION['s_Level'], "ReadAdministrator") != 0) 
  		   )
		{
			//echo "<center><h3>Sorry !!<br>You are not Log-in !!</h3></center>";
			echo "<script>parent.document.location.href='".curSystemURL()."/KM/MemberLogin/';</script>";
			exit;
		}
	}
	function Is_Login()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) && 
			 (strcmp($_SESSION['s_Level'], "2") != 0) && 
			 (strcmp($_SESSION['s_Level'], "3") != 0) && 
			 (strcmp($_SESSION['s_Level'], "4") != 0) && 
			 (strcmp($_SESSION['s_Level'], "Administrator") != 0) && 
			 (strcmp($_SESSION['s_Level'], "ReadAdministrator") != 0) 
			)
			return false;
		else
			return true;
	}


// Check Administrator.
	function Check_Administrator()
	{
		if ( (strcmp($_SESSION['s_Level'], "Administrator") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not Administrator !!</h3></center>";
			exit;
		}
	}
	function Is_Administrator()
	{
		if ( (strcmp($_SESSION['s_Level'], "Administrator") != 0) )
			return false;
		else
			return true;
	}


// Check Rea dAdministrator.
	function Check_ReadAdministrator()
	{
		if ( (strcmp($_SESSION['s_Level'], "Read Administrator") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not Read Administrator !!</h3></center>";
			exit;
		}
	}
	function Is_ReadAdministrator()
	{
		if ( (strcmp($_SESSION['s_Level'], "ReadAdministrator") != 0) )
			return false;
		else
			return true;
	}


// Check Level 1.
	function Check_Level1()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 工程師 !!</h3></center>";
			exit;
		}
	}
	function Is_Level1()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) )
			return false;
		else
			return true;
	}


// Check Level 2.
	function Check_Level2()
	{
		if ( (strcmp($_SESSION['s_Level'], "2") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 經理 !!</h3></center>";
			exit;
		}
	}
	function Is_Level2()
	{
		if ( (strcmp($_SESSION['s_Level'], "2") != 0) )
			return false;
		else
			return true;
	}


// Check Level 3.
	function Check_Level3()
	{
		if ( (strcmp($_SESSION['s_Level'], "3") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 副總、協理 !!</h3></center>";
			exit;
		}
	}
	function Is_Level3()
	{
		if ( (strcmp($_SESSION['s_Level'], "3") != 0) )
			return false;
		else
			return true;
	}


// Check Level 3.
	function Check_Level4()
	{
		if ( (strcmp($_SESSION['s_Level'], "4") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 董事長、總經理 !!</h3></center>";
			exit;
		}
	}
	function Is_Level4()
	{
		if ( (strcmp($_SESSION['s_Level'], "4") != 0) )
			return false;
		else
			return true;
	}



// Check Read Permission.
	/*
		1. Read Department.
		2. Write Department.
		3. Administrator.
		4. Confirm Member.
		5. All(Portwell, Caswell & Customer).
		6. Read Administrator.
	*/
	function Enable_Read_Permission( $ReadDepartment, $WriteDepartment, $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 2. Read Administrator.
		else if ( strcmp($_SESSION['s_Level'], "ReadAdministrator") == 0 )
		{
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
		}
		// 4. Write Department.
		else if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
		}
		// 5. Read Department.
		else if ( !(strpos($ReadDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
		}
		// 6. All(Portwell, Caswell & Customer).
		else if ( $ReadDepartment == ";All;" )
		{
		}
		else
		{
			Check_Login();
			echo "<center><br><p style='font:16pt Calibri, Helvetica, sans-serif; font-weight:bold; color:#FF0000;'>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></center></p>";
			exit;
		}
	}
	function Enable_Read_Permission_Show( $ReadDepartment, $WriteDepartment, $ConfirmMember, $Status )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 2. Read Administrator.
		else if ( strcmp($_SESSION['s_Level'], "ReadAdministrator") == 0 )
		{
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
		}
		// 4. Write Department.
		else if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
		}
		// 5. Read Department.
		else if ( !(strpos($ReadDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			if ( $Status < 5 )
			{
				Check_Login();
				echo "<br><center><h3>Sorry !!<br><br>You do not have permission to access yet confirm's job !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></h3></center>";
				exit;
			}
		}
		// 5. All(Portwell, Caswell & Customer).
		else if ( $ReadDepartment == ";All;" )
		{
			if ( $Status < 5 )
			{
				Check_Login();
				echo "<center><br><p style='font:16pt Calibri, Helvetica, sans-serif; font-weight:bold; color:#FF0000;'>Sorry !!<br><br>You do not have permission to access yet confirm's job !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></p></center>";
				exit;
			}
		}
		else
		{
			Check_Login();
			echo "<center><br><p style='font:16pt Calibri, Helvetica, sans-serif; font-weight:bold; color:#FF0000;'>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></p></center>";
			exit;
		}
	}
	function Can_Read_Permission( $ReadDepartment, $WriteDepartment, $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 2. Read Administrator.
		else if ( strcmp($_SESSION['s_Level'], "ReadAdministrator") == 0 )
		{
			return true;
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		// 4. Write Department.
		else if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			return true;
		}
		// 5. Read Department.
		if ( !(strpos($ReadDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			return true;
		}
		// 6. All(Portwell, Caswell & Customer).
		else if ( $ReadDepartment == ";All;" )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function Can_Read_Permission_Show( $ReadDepartment, $WriteDepartment, $ConfirmMember, $Status )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 2. Read Administrator.
		else if ( strcmp($_SESSION['s_Level'], "ReadAdministrator") == 0 )
		{
			return true;
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		// 4. Write Department.
		else if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			return true;
		}
		// 5. Read Department.
		if ( !(strpos($ReadDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			if ( $Status < 5 )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		// 6. All(Portwell, Caswell & Customer).
		else if ( $ReadDepartment == ";All;" )
		{
			if ( $Status < 5 )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	function Can_Show_Full_Status_Permission( $ConfirmMember )
	{
		/*
			1. Confirm Member.
			2. Administrator.
			3. For Create, Assign or Latest Update Member.(*)
			4. Read Administrator.
		*/
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		else if ( strcmp($_SESSION['s_Level'], "ReadAdministrator") == 0 )
		{
			return true;
		}
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}



// Check Write Permission.
	/*
		1. Write Department.
		2. Administrator.
		3. Confirm Member.
		4. All(Portwell, Caswell & Customer).
	*/
	function Enable_Write_Permission( $WriteDepartment, $ConfirmMember )
	{
		// 1. Write Department.
		if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
		}
		// 2. Administrator.
		else if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
		}
		// 4. All(Portwell, Caswell & Customer).
		else if ( $WriteDepartment == ";All;" )
		{
		}
		else
		{
			Check_Login();
			echo "<center><h3>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></h3></center>";
			exit;
		}
	}
	function Can_Write_Permission( $WriteDepartment, $ConfirmMember )
	{
		// 1. Write Department.
		if ( !(strpos($WriteDepartment, ";".$_SESSION['s_DepartmentID'].";") === false) )
		{
			return true;
		}
		// 2. Administrator.
		else if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 3. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		// 4. All(Portwell, Caswell & Customer).
		else if ( $WriteDepartment == ";All;" )
		{
			return true;
		}
		else
		{
			return false;
		}
	}


// Can Add Permission.
	function Enable_Add_Permission( $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 2. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
		}
		else
		{
			Check_Login();
			echo "<center><h3>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></h3></center>";
			exit;
		}
	}
	function Can_Add_Permission( $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 2. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}



// Check Delete Permission.
	/*
		1. Administrator.
		2. Confirm Member[Status:1~4(No confirm)].
	*/
/*
	function Enable_Delete_Permission( $ConfirmMember, $Status )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 2. Confirm Member[Status:1~4(No confirm)].
		else if ( (strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0) && ($Status < 5) )
		{
		}
		else
		{
			echo "<center><h3>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></h3></center>";
			exit;
		}
	}
	function Can_Delete_Permission( $ConfirmMember, $Status )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 2. Confirm Member[Status:1~4(No confirm)].
		else if ( (strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0) && ($Status < 5) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
*/



// Check Full Delete Permission(Full).
	/*
		1. Administrator.
		2. Confirm Member.
	*/
	function Enable_Delete_Permission( $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
		}
		// 2. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
		}
		else
		{
			Check_Login();
			echo "<center><h3>Sorry !!<br><br>You do not have permission to access !!<br><br><a href='javascript:history.go(-1);'>Go Back</a></h3></center>";
			exit;
		}
	}
	function Can_Delete_Permission( $ConfirmMember )
	{
		// 1. Administrator.
		if ( strcmp($_SESSION['s_Level'], "Administrator") == 0 )
		{
			return true;
		}
		// 2. Confirm Member.
		else if ( strcmp($_SESSION['s_MemberID'], $ConfirmMember) == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}




	// Send PHP E-Mail Function.
	function SendPHPMail($eMailTo, $title, $content)
	{	
		require_once('phpmailer/class.phpmailer.php');

		$mail = new PHPMailer(true);	// the true param means it will throw exceptions on errors, which we need to catch

		$mail -> IsSMTP();				// telling the class to use SMTP

  		// Smtp Setting (Using Gmail.com).
/*
		$mail -> Host       = "smtp.gmail.com";           // SMTP server (sets GMAIL as the SMTP server)
		$mail -> SMTPDebug  = 2;                          // enables SMTP debug information (for testing)
		$mail -> SMTPAuth   = true;                       // enable SMTP authentication
		$mail -> SMTPSecure = "ssl";                      // sets the prefix to the servier
		$mail -> Port       = 465;                        // set the SMTP port for the GMAIL server
		$mail -> CharSet    = "utf-8";                    // Sets the CharSet of the message
		$mail -> Username   = "portwellsic@gmail.com";    // GMAIL username
		$mail -> Password   = "123webSERVER)(!!";         // GMAIL password
*/

		// Smtp Setting (Using Portwell.com.tw SMTP Server).
		$mail -> Host       = "smtp.portwell.com.tw";     	// SMTP server (sets MAIL as the SMTP server)
		$mail -> Port       = 25;                        	// set the SMTP port for the MAIL server
		$mail -> CharSet    = "utf-8";                    	// Sets the CharSet of the message
		$mail -> Username   = "kimi.lin@portwell.com.tw";	// MAIL username
		$mail -> Password   = "portwell";             		// MAIL password

		// Setting the Sender, Receicer, ...
//		$mail -> SetFrom   ("portwellsic@gmail.com");		// Adds a "From" address.
		$mail -> SetFrom   ("kimi.lin@portwell.com.tw", "Portwell KM");	// Adds a "From" address.
		$mail -> AddAddress($eMailTo);	// Adds a "To" address.
//		$mail -> AddCC     ("kimi.lin@portwell.com.tw");	// Adds a "CC" address.
//		$mail -> AddBCC    ("kimi.lin@portwell.com.tw");	// Adds a "BCC" address(Hide).
//		$mail -> AddReplyTo("kimi.lin@portwell.com.tw");	// Adds a "Reply-to" address.

		// Setting the mail title, content ...
		$mail -> Subject  = $title;
		$mail -> Body     = $content;	// HTML Body
		$mail -> WordWrap = 50;			// set word wrap
		$mail -> IsHTML(true);
// 		$mail -> AddAttachment('images/phpmailer.gif');	// attachment

		$mail -> Send();
	}

	// Generator Create(Status 1) E-Mail content Function.
	function CreateTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $ManagerMember,
</p>

<p>
感謝您使用Portwell KM系統！
</p>

<p>
您剛剛在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，完成新增一筆標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
並將該工作委託指派給 <font color="#0000ff"><b>$AssignMember</b></font> 協助處理，我們已經發信通知 <font color="#0000ff"><b>$AssignMember</b></font>，請求儘快進行工作的處理。
</p>

<p>
請您隨時留意您的信箱，一旦該工作有新進度時，系統會自動發信通知您！
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Assign(Status 2) E-Mail content Function.
	function AssignTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
您剛剛在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，被管理者 <font color="#0000ff"><b>$ManagerMember</b></font> 指派協助處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
請儘快安排時間，儘快去完成被指派的工作！
</p>

<p>
您可以在登入Portwell KM系統後，到
<br>
<font color="#0000ff"><b>1.) $Department -> $FormName 表單</b></font>
<br>
或
<br>
<font color="#0000ff"><b>2.) My Job Management -> Waiting for Process Job (待處理工作)</b></font>
<br>
頁面找到您被指派的 <font color="#0000ff"><b>$TaskTitle</b></font> 工作，然後完成它。
</p>

<p>
<b><font color="#ff0000">※ 提醒您，在完成被指派的工作後，千萬別忘了到 My Job Management -> Waiting for Process Job (待處理工作) 頁面進行最後的確認動作！
<br>在確認無誤後，請點擊Submit按鈕將該工作送交給管理者請求進行確認！</font></b>
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Testing(Status 3) E-Mail content Function.
	function TestingTaskMailContent($Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
感謝您使用Portwell KM系統！
</p>

<p>
您剛剛在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，處理/編輯了被指派標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
</p>

<p>
<b><font color="#ff0000">※ 提醒您，千萬別忘了到 My Job Management -> Waiting for Process Job (待處理工作) 頁面進行最後的確認！
<br>在確認無誤後，請點擊Submit按鈕將該工作送交給管理者請求進行確認！</font></b>
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Complete1[Manager](Status 4) E-Mail content Function.
	function CompleteManagerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $ManagerMember,
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，委託指派給 <font color="#0000ff"><b>$AssignMember</b></font> 處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作，在剛剛已經順利完成了。
</p>

<p>
請您儘快到 <font color="#0000ff"><b>My Job Management -> Waiting for Process Job (待處理工作)</b></font> 頁面進行確認的動作！
<br>
<font color="#0000ff"><b>1.) 如果在確認後無誤，請您點擊Submit按鈕將工作進行結案。</b></font>
<br>
<font color="#0000ff"><b>2.) 如果在確認後有誤，您可以點擊Send Back按鈕將工作退還給 <font color="#0000ff"><b>$AssignMember</b></font> ，請求重新進行工作的處理。</b></font>
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Complete2[Assign Engineer](Status 4) E-Mail content Function.
	function CompleteEngineerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
感謝您使用Portwell KM系統！
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，被管理者 <font color="#0000ff"><b>$ManagerMember</b></font> 指派協助處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
在剛剛已經成功將工作遞交給管理者等待進行確認，我們已經發信通知管理者，請求儘快進行工作的確認動作！
</p>

<p>
請您隨時留意您的信箱，一旦該工作有新進度時，系統會自動發信通知您！
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Confirm1(Status 5) E-Mail content Function.
	function ConfirmAllTaskMailContent($Department, $FormName, $TaskTitle)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear All,
</p>

<p>
與您相關 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作，已經在剛剛順利的完成了！
</p>

<p>
現在您可以登入到Portwell KM系統，去瀏覽/查詢/下載 <font color="#0000ff"><b>$TaskTitle</b></font> 工作。
</p>

<p>
如果對於工作內容有任何疑問/建議，您可以直接與相關人員進行討論。
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Confirm2(Status 5) E-Mail content Function.
	function ConfirmManagerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $ManagerMember,
</p>

<p>
感謝您使用Portwell KM系統！
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，委託指派給 <font color="#0000ff"><b>$AssignMember</b></font> 協助處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
在剛剛已經成功將工作完成確認的動作，我們已經發信通知與該Project相關的群組人員，可以登入Portwell KM去瀏覽/查詢/下載 <font color="#0000ff"><b>$TaskTitle</b></font> 工作！
</p>

<p>
如果對於工作內容有任何疑問/建議，您可以直接與相關人員進行討論。
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator Confirm3(Status 5) E-Mail content Function.
	function ConfirmEngineerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，被管理者 <font color="#0000ff"><b>$ManagerMember</b></font> 委託指派協助處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
在剛剛已經順利被管理者完成確認的動作，我們已經發信通知與該Project相關的群組人員，可以登入Portwell KM去瀏覽/查詢/下載 <font color="#0000ff"><b>$TaskTitle</b></font> 工作！
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator SendBack1(Status 4 -> 3) E-Mail content Function.
	function SednBackEngineerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，遞交給管理者 <font color="#0000ff"><b>$ManagerMember</b></font> 確認標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
在經過管理者確認後發現有錯誤。目前系統已將工作退還給您，請儘快登入到Portwell KM系統重新進行工作的處理/測試！
</p>

<p>
<b><font color="#ff0000">※ 提醒您，千萬別忘了到 My Job Management -> Waiting for Process Job (待處理工作) 頁面進行最後的確認！在確認無誤後，請點擊Submit按鈕將該工作送交給管理者請求進行確認！</font></b>
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator SendBack2(Status 4 -> 3) E-Mail content Function.
	function SednBackManagerTaskMailContent($ManagerMember, $Department, $FormName, $TaskTitle, $AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $ManagerMember,
</p>

<p>
感謝您使用Portwell KM系統！
</p>

<p>
您之前在 <font color="#0000ff"><b>$Department</b></font> -> <font color="#0000ff"><b>$FormName</b></font> 表單中，委託指派給 <font color="#0000ff"><b>$AssignMember</b></font> 協助處理標題為 <font color="#0000ff"><b>$TaskTitle</b></font> 的工作。
<br>
在剛剛已經成功將工作退還給 <font color="#0000ff"><b>$AssignMember</b></font> 了，要求重新針對工作進行處理/測試！
</p>

<p>
請您隨時留意您的信箱，一旦該工作有新進度時，系統會自動發信通知您！
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}

	// Generator ATE Complete(Status 2 -> 3) E-Mail content Function.
	function ATECompleteTaskMailContent($AssignMember)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $AssignMember,
</p>

<p>
感謝您使用ATE工具！
</p>

<p>
您使用的ATE工具已經順利完成工作的測試，現在您可以登入到Portwell KM系統，去進行數據的確認動作！
</p>

<p>
<b><font color="#ff0000">※ 提醒您，千萬別忘了到 My Job Management -> Waiting for Process Job (待處理工作) 頁面進行最後的確認！在確認無誤後，請點擊Submit按鈕將該工作送交給管理者請求進行確認！</font></b>
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}



// Active Account E-Mail content Function.
	function ActiveAccountMailContent($EnglishName, $Password)
	{
		$datetime = date("Y/m/d H:m:s", strtotime('+8HOUR'));

		$content = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portwell KM - Notification by E-Mail</title>
<style type="text/css">
<!--
body p {
	font-size: 18px;
}
-->
</style>
</head>
<body>
<p>
Dear $EnglishName,
</p>

<p>
恭禧您，您在KM系統的帳號在剛剛已經被管理者完成啟動了!!
</p>

<p>
以下是您在KM系統的帳號資訊：
<br>
帳號：<b><font color="#0000ff">$EnglishName</font></b>
<br>
密碼：<b><font color="#0000ff">$Password</font></b>&nbsp;&nbsp;(※請留意英文字母大小寫)
</p>

<p>
網址：<b><font color="#0000ff"><a href='http://sickm.portwell.com.tw/'>http://sickm.portwell.com.tw/</a></font></b>&nbsp;&nbsp;(※公司內、外部網路皆可使用)
</p>

<p>
最後，
<br>
感謝您的使用與支持～
</p>

<p>
Best Regards,
<br>
<a href='http://sickm.portwell.com.tw/'>Portwell KM System</a>
<br>
$datetime
</p>
</body>
</html>
EOT;

		return $content;
	}
?>