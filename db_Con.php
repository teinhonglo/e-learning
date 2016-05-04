<?PHP
	function connectdb() {
		$dbhost  = "localhost";
		$user    = "root";
		$passwd  = "888888";
		$used_db = "KM";
		$link    = mysql_connect($dbhost, $user, $passwd) or die("Error:" . mysql_error());
		mysql_select_db($used_db) or die("Could not select database");
		mysql_query("SET NAMES 'UTF8'");

		return $link;
    }
?>