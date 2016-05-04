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
	
	$_SESSION['e_learning_video_password'] = 0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Viewer Control Panel</title>
<!--index css-->
<link rel="icon" type="image/ico" href="../images/title_icon.png" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<!--end-->
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
<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/ >  
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
		"sAjaxSource": "_Server_Processing", 
		"aoColumns": [ { "bSortable": true },{ "bSortable": true }, { "bSortable": true }, { "bSortable": true }, {"bSortable": true} ], 
		"fnDrawCallback": function () { 
			$(".various").fancybox( {
				'openEffect'	: 'fade',
				'closeEffect'	: 'elastic', 
				'type'			: 'iframe', 
				'overlayColor'  : '#000', 
				'autoSize'      : 'false', 
				'width'			: '100%', 
				'height'		: '100%', 
				iframe : {
					preload: false
				},
				'afterClose' : function() {
					parent.location.reload(true);
				}
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
<!-- control page -->
<div id="header-wrapper">
	<div id="header" class="container">
		<div id="hello_slide"><?echo $_SESSION['s_EnglishName'] . " ";?> 你好，歡迎登入! <a href="../../">回到KM</a>&nbsp;&nbsp;&nbsp;<a href="../../MemberLogout">登出&nbsp;&nbsp;</a></div>
		<div id="logo">
			<span class="icon icon-group"></span>
			<h1><a href="../">E-Learning</a></h1>
		</div>
		<div id="triangle-up"></div>
	</div>
</div>
<div id="menu-wrapper">
		<div id="menu">
			<ul>
				<li><a href="../" accesskey="1" title="回首頁">首頁</a></li>
<?
	if($memberType >= 2)
	{
		echo	"<li><a href=\"../add_video\" accesskey=\"2\" title=\"新增你的影片\">新增上傳影片</a></li>";
	}
?>
				<li  class="current_page_item"><a href="#" accesskey="3" title="目前可看的影片清單">我的影片清單</a></li>
				<li><a href="../log_list" accesskey="4" title="影片歷程記錄">我的觀看歷程記錄</a></li>
<?
	if($memberType >= 3)
	{
		echo "<li><a href=\"../add_uploader\" accesskey=\"5\" title=\"新增上傳者\">新增上傳者</a></li>";
	}
?>
				<li><a href="../tutorial/E-Learning使用教學.pdf" accesskey="6" title="使用教學" target="_blank">使用教學</a></li>
			</ul>
		</div>
</div
<!--end-->
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<div style="margin-left:auto; margin-right:auto; white-space:nowrap;">
			<br>
			<center><label id="my_sub_module_title">您的影片清單<? echo "(" . $_SESSION['s_EnglishName'] . ")"; ?></label></center>
			<br>
			<br>
				<table cellpadding="0" cellspacing="0" border="0" id="example" width="100%" >
					<thead>
						<tr>
							<th style="font-size:14pt;">影片名稱</th>
							<th style="font-size:14pt;">上傳者</th>
							<th style="font-size:14pt;">開始日期</th>
							<th style="font-size:14pt;">結束日期</th>
							<th style="font-size:14pt">時間區段</th>
						</tr>
					</thead>
					<tbody>
						<tr height="60">
							<td colspan="5">Loading ...</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style="font-size:14pt;">影片名稱</th>
							<th style="font-size:14pt;">上傳者</th>
							<th style="font-size:14pt;">開始日期</th>
							<th style="font-size:14pt;">結束日期</th>
							<th style="font-size:14pt">時間區段</th>
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
<div id="stamp" class="container">
<div class="hexagon"><span class="icon icon-wrench"></span></div>
</div>
<p align="center" id="bottom_text_style"><b>Contact me：Tien-Hong Lo</b></p>
<div id="copyright" class="container"></div>
</body>
</html>