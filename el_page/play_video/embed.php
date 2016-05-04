<?PHP session_start();?>
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
	
	include("../onetime_password.php");
	$random_str = onetime_passwd();
	
	$_SESSION['s_VideoID'] = $_GET['ID'];
	if($_SESSION['e_learning_video_password'] == 2){
		$_SESSION['e_learning_video_password'] = 3;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Flash/Strobe Media Playback</title>
        <style type="text/css">
            body {
                font: 12px Arial, sans-serif;
                background-color: #000000;
                color: #FFFFFF;
                height: 100%;
                width: 100%;
                margin: 0;
                overflow: hidden;
            }
        </style>
		<script src="dist/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
		<link type="text/css" href="jquery.strobemediaplayback.css" rel="stylesheet" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="lib/swfobject.js">
        </script>
		<script type="text/javascript" src="lib/jquery/jquery-1.4.2.js">
        </script>
        <script type="text/javascript" src="jquery.strobemediaplayback.js">
        </script>
		<script type="text/javascript">
            $(function(){
                // Get the page query string and retrieve page params
                var options={}, queryString = window.location.search;
                if (queryString) {
                    queryString = queryString.substring(1);
					options = $.fn.strobemediaplayback.parseQueryString(queryString);
                }
				// Use a sample video for geeks that look at the source code for samples
				if (!options.src)
				{
					options.src = <?php echo json_encode($random_str) ?>;
				}
				
                options = $.fn.adaptiveexperienceconfigurator.adapt(options);
                
				// Retrieve the window dimensions
                options.width = $(window).width();
                options.height = $(window).height();
                
				// Now we are ready to generate the video tags
                $("#strobemediaplayback").strobemediaplayback(options);
            });
        </script>
		<script type="text/javascript" src="strobePlayBack.js">
        </script>
    </head>
    <body onload="displayPage()">
        <div id="strobemediaplayback" >Alternative content</div> 
    </body>
</html>
<?PHP
	} else{
		echo "<script>parent.location.href='../';</script>";
	}
?>