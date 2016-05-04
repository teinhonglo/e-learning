<?PHP session_start(); ?>
<?
	// Generator Create(Status 1) E-Mail content Function.
	function CreateAssignVideoContent($ManagerMember, $VideoTitle, $StartDate, $StopDate, $StartTime, $StopTime, $AssignedMember)
	{
		$StartDate = ($StartDate == "1000-01-01")?"None": $StartDate;
		$StopDate = ($StopDate == "9999-12-31")?"None": $StopDate;
		
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
您剛剛被<font color="#0000ff"><b>$AssignedMember</b></font>指派去看一個新影片<font color="#0000ff"><b>「 $VideoTitle 」</b></font>
<br>
請務必在<font color="#0000ff"><b>$StartDate</b></font> 到 <font color="#0000ff"><b>$StopDate</b></font>,</br>
且在時間區段<font color="#0000ff"><b>$StartTime</b></font>~<font color="#0000ff"><b>$StopTime</b></font>內觀看完畢。</br>
<font color="#0000ff"><b><a href='http://192.168.2.150/KM/e-learning/viewer_list/'>觀看影片頁面</a></b></font>
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

</p>
</body>
</html>
EOT;
		return $content;
	}
	
	function CreateRequestVideoContent($RequestMember, $VideoTitle, $AssignedMember)
	{
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
Dear $AssignedMember,
</p>

<p>
您剛剛有一個影片─<font color="#0000ff"><b>「 $VideoTitle 」</b></font>
<br>
被<font color="#0000ff"><b>$RequestMember</b></font> 請求觀看。</p>
<p>請至<font color="#0000ff"><b><a href="http://192.168.2.150/KM/e-learning/add_video/">影片上傳頁面</a></b></font>修改權限</p>
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

</p>
</body>
</html>
EOT;
		return $content;
	}
?>