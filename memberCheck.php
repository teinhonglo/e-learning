<?PHP
	function isMember()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) && (strcmp($_SESSION['s_Level'], "2") != 0) && (strcmp($_SESSION['s_Level'], "3") != 0) && (strcmp($_SESSION['s_Level'], "4") != 0) && (strcmp($_SESSION['s_Level'], "Administrator") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not Member !!</h3></center>";
			exit;
		}
	}

	function isAdministrator()
	{
		if ( (strcmp($_SESSION['s_Level'], "Administrator") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not Administrator !!</h3></center>";
			exit;
		}
	}

	function isLevel1()
	{
		if ( (strcmp($_SESSION['s_Level'], "1") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 工程師 !!</h3></center>";
			exit;
		}
	}

	function isLevel2()
	{
		if ( (strcmp($_SESSION['s_Level'], "2") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 經理 !!</h3></center>";
			exit;
		}
	}

	function isLevel3()
	{
		if ( (strcmp($_SESSION['s_Level'], "3") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 副總、協理 !!</h3></center>";
			exit;
		}
	}

	function isLevel4()
	{
		if ( (strcmp($_SESSION['s_Level'], "4") != 0) )
		{
			echo "<center><h3>Sorry !!<br>You are not 董事長、總經理 !!</h3></center>";
			exit;
		}
	}

	function isLogin()
	{
		if ( !isset($_SESSION['s_DepartmentID']) )
		{
			echo "<center><h3>Sorry !!<br>You are not Login !!</h3></center>";
			exit;
		}
	}
?>