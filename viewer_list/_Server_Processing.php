<?PHP session_start(); ?>
<?PHP
	date_default_timezone_set('Asia/Taipei');
	
	$CurDate = date("Y-m-d");
	$CurTime = date("H:i:s");
	
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();

	include("_DBTable.php");
	
	// Columns List.
	$aColumns = array('VideoTitle', 'UploaderName', 'StartDate', 'StopDate', 'TimeRange', 'VideoID');
	
	// Login User ID
	$MemberID = $_SESSION['s_MemberID'];
	
	// Index column.
	$sIndexColumn = "VideoID";

	// Select List.
	$sTable = "(SELECT  V.video_title VideoTitle,
						CONCAT(M.ChineseName,'(', M.EnglishName, ')') UploaderName,
						F.start_date StartDate,
						F.stop_date StopDate,
						CONCAT(F.start_time, ' ~ ', F.stop_time ) TimeRange,
						V.video_id VideoID
				FROM    $DatabaseName F, e_learning_video_info V, Member M
				WHERE   (F.member_id = $MemberID 
						OR F.member_id = 0)
						AND F.create_member_id = M.MemberID 
						AND F.video_id = V.video_id
						AND V.is_delete = 0
						AND F.start_date <= '$CurDate'
						AND F.stop_date >= '$CurDate'
						AND F.start_time <= '$CurTime'
						AND F.stop_time >= '$CurTime'
				ORDER BY create_datetime DESC) TB ";
	
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

	while ($aRow = mysql_fetch_array($rResult))
	{
		$row = array();
		
		$VideoTitle     = $aRow[$aColumns[0]];
		$UploaderName	= $aRow[$aColumns[1]];
		$StartTime		= ($aRow[$aColumns[2]] == "1000-01-01")?"None":$aRow[$aColumns[2]];
		$StopTime		= ($aRow[$aColumns[3]] == "9999-12-31")?"None":$aRow[$aColumns[3]];
		$TimeRange		= $aRow[$aColumns[4]];
		$VideoID		= $aRow[$aColumns[5]];
		
		$row[] = "<a href='password_content?ID=$VideoID&VideoTitle=$VideoTitle' class=\"various\">" . $VideoTitle . "</a>";
		$row[] = $UploaderName;
		$row[] = $StartTime;
		$row[] = $StopTime;
		$row[] = $TimeRange;
		
		$output['aaData'][] = $row;
	}

	echo json_encode( $output );
?>