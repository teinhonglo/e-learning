<?PHP session_start();?>
<?
	function onetime_passwd(){
		$meshCode = $_SESSION['s_DepartmentName'] . time();
		$meshCode .= $_SESSION['s_MemberID'];
		$meshCode .= $_SESSION['s_EnglishName'];
		$meshCode = md5($meshCode);
		$meshCode = md5(strtoupper($meshCode));
		$meshCode = strtoupper($meshCode);
		return $meshCode;
	}
?>