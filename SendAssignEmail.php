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
�z���Q<font color="#0000ff"><b>$AssignedMember</b></font>�����h�ݤ@�ӷs�v��<font color="#0000ff"><b>�u $VideoTitle �v</b></font>
<br>
�аȥ��b<font color="#0000ff"><b>$StartDate</b></font> �� <font color="#0000ff"><b>$StopDate</b></font>,</br>
�B�b�ɶ��Ϭq<font color="#0000ff"><b>$StartTime</b></font>~<font color="#0000ff"><b>$StopTime</b></font>���[�ݧ����C</br>
<font color="#0000ff"><b><a href='http://192.168.2.150/KM/e-learning/viewer_list/'>�[�ݼv������</a></b></font>
</p>

<p>
�̫�A
<br>
�P�±z���ϥλP�����
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
�z��観�@�Ӽv���w<font color="#0000ff"><b>�u $VideoTitle �v</b></font>
<br>
�Q<font color="#0000ff"><b>$RequestMember</b></font> �ШD�[�ݡC</p>
<p>�Ц�<font color="#0000ff"><b><a href="http://192.168.2.150/KM/e-learning/add_video/">�v���W�ǭ���</a></b></font>�ק��v��</p>
<p>
�̫�A
<br>
�P�±z���ϥλP�����
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