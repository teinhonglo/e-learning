<?PHP session_start(); ?>
<?PHP
	$control_path = "../";

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();

	include("_DBTable.php");
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	// Columns List.
	$aColumns = array('Name', 'Size', 'UploadTime', 'video_id');
	
	// Login User ID
	$MemberID = $_SESSION['s_MemberID'];
	
	// Index column.
	$sIndexColumn = "video_id";

	// Select List.
	$sTable = "(SELECT  video_title Name,
						size Size,
						upload_datetime UploadTime,
						video_id
				FROM    $DatabaseName
				WHERE   upload_member_id = $MemberID AND is_delete = 0
				ORDER BY upload_datetime DESC) TB";
	
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
		// Initial Table Value
		$Name           = $aRow[$aColumns[0]];
		$Size			= $aRow[$aColumns[1]];
		$UploadTime		= $aRow[$aColumns[2]];
		$ID 			= $aRow[$aColumns[3]];
		
		$Size = formatBytes($Size, 2);
		
		// If Video Information not delete
		$row[] = "<a href='show_video_viewer?ID=$ID' class=\"various\">" . $Name . "</a>";
		$row[] = $Size;
		$row[] = $UploadTime;
		
		// Check Uploader
		if($memberType >= 2){
			$Edit = "<center><a href=\"Edit?ID=$ID\" class=\"various\"><img class=\"TipRight\" src=\"" . $control_path . "../images/edit-icon.gif\" style=\"border:none;\" title=\"<font style='font-size:13pt;'>Edit Video Info</font>\"></a></center>";
			$Del = "<center><a href=\"#\" onclick=\"if (confirm('Are you sure to delete ?')) {location.href='Del?ID=$ID'}; return false;\"><img class=\"TipRight\" src=\"" . $control_path . "../images/del-icon.gif\" style=\"border:none;\" title=\"<font style='font-size:13pt;'>Delete Video</font>\"></a></center>";
		}else{
			$Edit = "<center><img class=\"TipRight\" src=\"../../images/edit-icon-disable.png\" style=\"border:none;\" title=\"Edit $FormName (Don't have permission)<br>If need, Please contact the Confirm Member or Administrator.\"></center>";
			$Del = "<center><img class=\"TipRight\" src=\"../../images/del-icon-disable.png\" style=\"border:none;\" title=\"Delete $FormName (Don't have permission)<br>If need, Please contact the Confirm Member or Administrator.\"></center>";
		}
		//
		$row[] = $Edit . $Del;
		
		$output['aaData'][] = $row;
	}

	echo json_encode( $output );
	
	function formatBytes($size, $precision)
	{
		$base = log($size) / log(1024);
		$suffixes = array('KB', 'MB', 'GB', 'TB');
		return round( pow(1024, $base - floor($base)), $precision ) . $suffixes[floor($base)];
	} 
?>