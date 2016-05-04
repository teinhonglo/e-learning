<?PHP session_start(); ?>
<?PHP
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();

	include("_DBTable.php");
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	// Columns List.
	$aColumns = array('Name', 'Mail','DepartmentName', 'BU','RegisterTime', 'member_id');

	// Index column.
	$sIndexColumn = "member_id";
	
	// Select List.
	if($memberType >= 3){
		$sTable = "(SELECT    concat(M.EnglishName, ' (', M.ChineseName, ')') Name,
							  M.DepartmentName,
							  M.Mail,
							  M.BU,
							  F.register_datetime RegisterTime,
							  F.member_id
					FROM      $DatabaseName F, Member M
					WHERE     F.member_id = M.MemberID) TB";
	} else{
		$sTable = "(SELECT    concat(M.EnglishName, ' (', M.ChineseName, ')') Name,
						  M.DepartmentName,
						  M.Mail,
						  M.BU,
						  F.register_datetime RegisterTime,
						  F.member_id
				FROM      $DatabaseName F, Member M
				WHERE     F.member_id = M.MemberID
						  AND M.level = 99
						  AND M.level = 98) TB";
	}
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

		$Name           = $aRow[$aColumns[0]];
		$eMail			= $aRow[$aColumns[1]];
		$DepartmentName = $aRow[$aColumns[2]];
		$BU				= $aRow[$aColumns[3]];
		$RegisterTime   = $aRow[$aColumns[4]];
		$ID				= $aRow[$aColumns[5]];

		$row[] = $Name;
		$row[] = $eMail;
		$row[] = $DepartmentName;
		$row[] = $BU;
		$row[] = $RegisterTime;


		// Delete Function(If is Recorder or Administrator).
		if($memberType >= 3){
			$Del = "<center><a href=\"#\" onclick=\"if (confirm('Are you sure to delete ?')) {location.href='Del?ID=$ID'}; return false;\"><img class=\"TipRight\" src=\"" . $control_path . "../images/del-icon.gif\" style=\"border:none;\" title=\"<font style='font-size:13pt;'>Delete Video</font>\"></a></center>";
		}else{
			$Del = "<center><img class=\"TipRight\" src=\"../../images/del-icon-disable.png\" style=\"border:none;\" title=\"Delete $FormName (Don't have permission)<br>If need, Please contact the Confirm Member or Administrator.\"></center>";
		}
		$row[] = $Del;

		$output['aaData'][] = $row;
	}

	echo json_encode( $output );
?>
