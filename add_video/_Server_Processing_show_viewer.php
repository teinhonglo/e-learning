<?PHP session_start(); ?>
<?PHP
	date_default_timezone_set('Asia/Taipei');
	
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();

	include("_DBTable.php");
	
	// Columns List.
	$aColumns = array('Name', 'start_date', 'stop_date', 'start_time', 'stop_time', 'create_datetime', 'viewer_id');
	
	// Login User ID
	$MemberID = $_SESSION['s_MemberID'];
	
	// Index column.
	$sIndexColumn = "viewer_id";
	$VideoID = $_SESSION['s_VideoID'];
	
	// Get current date and time.
	$CurDate = date("Y-m-d");
	$CurTime = date("H:i:s");
	
	// Select List.
	$sTable = "(SELECT  CONCAT( EnglishName,'(',ChineseName,')') Name,
						V.start_date start_date,
						V.stop_date stop_date,
						V.start_time start_time,
						V.stop_time stop_time,
						V.create_datetime create_datetime,
						V.id	viewer_id
				FROM    e_learning_video_info F, e_learning_video_viewer V, member M
				WHERE   F.video_id = $VideoID
				AND 	F.is_delete = 0
				AND 	F.video_id = V.video_id
				AND 	(V.member_id = M.MemberID)
				ORDER BY create_datetime DESC) TB";

	// Paging.
	$sLimit = "";
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
	{
		$sLimit = "LIMIT " . mysql_real_escape_string($_GET['iDisplayStart']) . ", " . mysql_real_escape_string($_GET['iDisplayLength']);
	}

	// Ordering.
	$sOrder = "";
	if (isset($_GET['iSortCol_0']))
	{
		$sOrder = "ORDER BY  ";
		for ($i=0 ; $i<intval($_GET['iSortingCols']) ; $i++)
		{
			if ($_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true")
			{
				$sOrder .= "`" . $aColumns[intval( $_GET['iSortCol_'.$i] )] . "` " . mysql_real_escape_string($_GET['sSortDir_'.$i]) . ", ";
			}
		}

		$sOrder = substr_replace($sOrder, "", -2);
		if ($sOrder == "ORDER BY")
		{
			$sOrder = "";
		}
	}

	// Filtering.
	$sWhere = "";
	if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
	{
		$sWhere = "WHERE (";
		for ($i=0 ; $i<count($aColumns) ; $i++)
		{
			$sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}

	// Individual column filtering.
	for ($i=0 ; $i<count($aColumns) ; $i++)
	{
		if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '')
		{
			if ($sWhere == "")
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_'.$i]) . "%' ";
		}
	}

	// SQL queries. Get data to display.
	$sQuery = "	SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "` 
				FROM   $sTable
				$sWhere
				$sOrder
				$sLimit
	";
	$rResult = mysql_query($sQuery, $ln) or die(mysql_error());
	// Data set length after filtering.
	$sQuery = "SELECT FOUND_ROWS()";
	$rResultFilterTotal = mysql_query($sQuery, $ln) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];

	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = mysql_query($sQuery, $ln) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];

	// Output.
	$output = array (
		"sEcho"					=> intval($_GET['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iFilteredTotal,
		"aaData"				=> array()
	);
	
	$row = array();
	
	while ($aRow = mysql_fetch_array($rResult))
	{
		// Initial Table Value
		$Name           = $aRow[$aColumns[0]];
		$StartDate		= ($aRow[$aColumns[1]] == "1000-01-01")?"None":$aRow[$aColumns[1]];
		$StopDate		= ($aRow[$aColumns[2]] == "9999-12-31")?"None":$aRow[$aColumns[2]];
		$TimeRange		= $aRow[$aColumns[3]] . " ~ " . $aRow[$aColumns[4]];
		$CreateTime		= $aRow[$aColumns[5]];
		$ID 			= $aRow[$aColumns[6]];
		
		$row[] = $Name;
		$row[] = $StartDate;
		$row[] = $StopDate;
		$row[] = $TimeRange;
		$row[] = $CreateTime;
		
		$VideoStopDateTime = strtotime($StopDate . " " . $aRow[$aColumns[4]]);
		$CurDateTime = strtotime($CurDate . " " . $CurTime);
		
		//echo $VideoStopDateTime . " " . $CurDateTime . "</br>";
		if($CurDateTime<= $VideoStopDateTime || $StopDate == "None"){
			$Del = "<center><a href=\"#\" onclick=\"if (confirm('Are you sure to delete ?')) {location.href='Del_viewer?ID=$ID'}; return false;\"><img class=\"TipRight\" src=\"" . $control_path . "../images/del-icon.gif\" style=\"border:none;\" title=\"<font style='font-size:13pt;'>Delete Viewer</font>\"></a></center>";
		} else{
			$Del = "<center><img class=\"TipRight\" src=\"../../images/del-icon-disable.png\" style=\"border:none;\" title=\"Delete $FormName (Don't have permission)<br>If need, Please contact the Confirm Member or Administrator.\"></center>";
		}
		$row[] = $Del;
		
		$output['aaData'][] = $row;
	}
	
	// 如果有全部授權，則再做一次查詢
	$sTable = "SELECT  V.start_date start_date,
						V.stop_date stop_date,
						V.start_time start_time,
						V.stop_time stop_time,
						V.create_datetime create_datetime,
						V.id	viewer_id
				FROM    e_learning_video_info F, e_learning_video_viewer V
				WHERE   F.video_id = $VideoID
				AND 	F.is_delete = 0
				AND 	F.video_id = V.video_id
				AND 	V.member_id = 0";
	
	$rs = mysql_query($sTable, $ln);
	
	$row = array();
	while($aRow = mysql_fetch_array($rs)){

		// Initial Table Value
		$Name           = "All";
		$StartDate		= ($aRow[$aColumns[1]] == "1000-01-01")?"None":$aRow['start_date'];
		$StopDate		= ($aRow[$aColumns[2]] == "9999-12-31")?"None":$aRow[$aColumns[2]];
		$TimeRange		= $aRow[$aColumns[3]] . " ~ " . $aRow[$aColumns[4]];
		$CreateTime		= $aRow[$aColumns[5]];
		$ID 			= $aRow[$aColumns[6]];
		
		$row[] = $Name;
		$row[] = $StartDate;
		$row[] = $StopDate;
		$row[] = $TimeRange;
		$row[] = $CreateTime;
		
		$VideoStopDateTime = strtotime($aRow[$aColumns[2]] . " " . $aRow[$aColumns[4]]);
		$CurDateTime = strtotime($CurDate . " " . $CurTime);
		if(($CurDateTime <= $VideoStopDateTime )|| $StopDate == "None"){
			$Del = "<center><a href=\"#\" onclick=\"if (confirm('Are you sure to delete ?')) {location.href='Del_viewer?ID=$ID'}; return false;\"><img class=\"TipRight\" src=\"" . $control_path . "../images/del-icon.gif\" style=\"border:none;\" title=\"<font style='font-size:13pt;'>Delete Viewer</font>\"></a></center>";
		} else{
			$Del = "<center><img class=\"TipRight\" src=\"../../images/del-icon-disable.png?$ID\" style=\"border:none;\" title=\"Delete $FormName (Don't have permission)<br>If need, Please contact the Confirm Member or Administrator.\"></center>";
		}
		$row[] = $Del;
		
		$output['aaData'][] = $row;
	}
	//unset($_SESSION['s_VideoID']);
	echo json_encode( $output );
?>