<?PHP session_start(); ?>
<?PHP
	// Page start time.
	$pagestartime = microtime();
	
	$control_path = "../";
	// Include Permission Control file.
	include($control_path . "../PermissionControl.php");
	Check_Login();

	// Include database connection file.
	include($control_path . "../db_Con.php");
	$ln = connectdb();
	
	include("../check_e_learning_permission.php");
	$memberType = check_member();
	
	if($memberType >= 2){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Uploader Control Panel</title>
<!--contorl path-->
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<link type="text/css" media="screen" rel="stylesheet" href="../../DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css">
<link type="text/css" media="screen" rel="stylesheet" href="../../DataTables-1.9.0/examples/examples_support/themes/custom-theme/jquery-ui-1.8.8.custom.css">
<link type="text/css" media="screen" rel="stylesheet" href="../../css/css_show.css">
<link type="text/css" media="screen" rel="stylesheet" href="../../tipsy/tipsy.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../DataTables-1.9.0/media/css/demo_page.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../DataTables-1.9.0/media/css/demo_table.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../fancyapps-fancyBox-18d1712/source/jquery.fancybox.css" />
<link type="text/css" media="screen" rel="stylesheet" href="../../js/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" language="javascript" src="../../DataTables-1.9.0/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../DataTables-1.9.0/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../fancyapps-fancyBox-18d1712/source/jquery.fancybox.js"></script>
<script type="text/javascript" language="javascript" src="../../tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" language="javascript" src="../../DataTables-1.9.0/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="../../DataTables-1.9.0/extras/TableTools/media/js/TableTools.js"></script> 
<script src="../js/jquery.js"></script>  
<script src="../js/jquery.datetimepicker.js"></script>  
<!--contorl path-->
<script type="text/javascript" charset="utf-8">
$(document).ready( function() {
	$('.TipRight').tipsy({gravity: 'e', html: true, fade: true});
	$('.TipLeft').tipsy({gravity: 'w', html: true, fade: true});
	$('.TipTop').tipsy({gravity: 's', html: true, fade: true});

	$('#example').dataTable( {
		"iDisplayLength": 5, 
		"oLanguage": { 
		"sLengthMenu": 'Display <select>'+ 
				'<option value="5">5</option>'+
				'<option value="10">10</option>'+ 
				'<option value="20">20</option>'+ 
				'<option value="40">40</option>'+ 
				'<option value="60">60</option>'+ 
				'<option value="80">80</option>'+ 
				'<option value="100">100</option>'+ 
				'<option value="-1">All</option>'+ 
				'</select> records' 
		},
		"bJQueryUI": true, 
		"sScrollY": "100%",
		"sScrollX": "100%", 
		"sPaginationType": "full_numbers", 
		"aaSorting": [], 
		"bProcessing": true, 
		"bServerSide": true, 
		"sAjaxSource": "_Server_Processing_show_viewer", 
		"aoColumns": [ { "bSortable": true}, { "bSortable": true}, { "bSortable": true}, { "bSortable": true}, { "bSortable": true}, { "bSortable": true} ], 
		"fnDrawCallback": function () { 
			$(".various").fancybox( {
				'openEffect'	: 'elastic', 
				'closeEffect'	: 'fade', 
				'type'			: 'iframe', 
				'overlayColor'  : '#000', 
				'width'			: '100%', 
				'height'		: '100%', 
				'autoSize'      : false 
			});
			$('.TipRight').tipsy({gravity: 'e', html: true, fade: true});
			$('.TipLeft').tipsy({gravity: 'w', html: true, fade: true});
			$('.TipTop').tipsy({gravity: 's', html: true, fade: true});
		}
	});
<?PHP
	if (isset($_GET['Keyword']))
	{
?>
	$('.dataTables_filter :input').val("<?=$_GET['Keyword'];?>").keyup();
<?PHP
	}
	// Get Video title
	$VideoID = $_GET['ID'];
	$_SESSION['s_VideoID'] = $VideoID;
	
	$sql = "SELECT  video_title
			FROM    e_learning_video_info
			WHERE   video_id = $VideoID";
				 
	$rs = mysql_query($sql, $ln);
	$row = mysql_fetch_row($rs);
	$VideoName = $row[0];
	
	mysql_close($ln);
?>
});
</script>
<style type="text/css"> 
body
{
	font-family: Calibri, "標楷體";
	color: #000;
}
#example tbody tr.odd td
{ 
	font-size: 14pt;
}	
#example tbody tr.even td
{ 
	font-size: 14pt;
}
</style>
</head>
<body>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<br>
			<center><label style="font-size:20pt; font-weight:bold;"><? echo $VideoName; ?></label></center>
			<br>
			<br>
			<div style="margin-left:auto; margin-right:auto; white-space:nowrap;">
				<table cellpadding="0" cellspacing="0" border="0" id="example" width="100%" >
					<thead>
						<tr>
							<th style="font-size:14pt;">授權觀看者</th>
							<th style="font-size:14pt;">開始日期</th>
							<th style="font-size:14pt;">結束日期</th>
							<th style="font-size:14pt;">時間區段</th>
							<th style="font-size:14pt;">授權日期</th>
							<th style="font-size:14pt;">刪除</th>
						</tr>
					</thead>
					<tbody>
						<tr height="60">
							<td colspan="5">Loading ...</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style="font-size:14pt;">授權觀看者</th>
							<th style="font-size:14pt;">開始日期</th>
							<th style="font-size:14pt;">結束日期</th>
							<th style="font-size:14pt;">時間區段</th>
							<th style="font-size:14pt;">授權日期</th>
							<th style="font-size:14pt;">刪除</th>
						</tr>
					</tfoot>
				</table>
			<?PHP
				$pageendtime = microtime();
				$starttime   = explode(" ", $pagestartime);
				$endtime     = explode(" ", $pageendtime);
				$totaltime   = $endtime[0] + $endtime[1] - $starttime[0] - $starttime[1];
				$timecost    = sprintf("%.6f", $totaltime);
			?>
				<p align="right" style="margin-top:6px; margin-right:14px; font-weight:bold; font-size:13pt;">Run time : <?=$timecost;?> Seconds.</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?
	}else{
		echo "<script>parent.location.href='../';</script>";
	}
?>