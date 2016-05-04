<?PHP session_start(); ?>
<?PHP
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();

	include("_DBTable.php");

	// Columns List.
	$aColumns = array('VideoName', 'UploaderName', 'ViewDatetime', 'VideoID');
	
	// Login User ID
	$MemberID = $_SESSION['s_MemberID'];
	
	// Index column.
	$sIndexColumn = "VideoID";

	// Select List.
	$sTable = "(SELECT  V.video_title VideoName,
						CONCAT(M.ChineseName,'(', M.EnglishName, ')') UploaderName,
						F.view_datetime ViewDatetime,
						V.video_id VideoID
				FROM    $DatabaseName F, e_learning_video_info V, member M
				WHERE   V.upload_member_id = M.MemberID
						AND F.member_id = $MemberID
						AND F.video_id = V.video_id
				GROUP BY ViewDatetime
				ORDER BY ViewDatetime DESC) TB ";
	//echo $sTable . "</br>";
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
		
		$VideoName      = $aRow[$aColumns[0]];
		$UploaderName	= $aRow[$aColumns[1]];
		$ViewDatetime	= $aRow[$aColumns[2]];

		$row[] = $VideoName;
		$row[] = $UploaderName;
		$row[] = $ViewDatetime;

		$output['aaData'][] = $row;
	}

	echo json_encode( $output );
?>