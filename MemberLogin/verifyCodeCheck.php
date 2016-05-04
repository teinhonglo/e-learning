<?PHP
	$data['success'] = 0;

	// Include Verify Code package.
	include '../verify/securimage_4char.php';

	// New verify code object.
	$securimage = new Securimage();

	// Check verify code.
	if ($securimage -> check($_POST['captcha_code']) == false) 
	{
  		// the code was incorrect
  		// handle the error accordingly with your other error checking
  		// or you can do something really basic like this
		$data['success'] = 0;
	}
	else 
	{
		$data['success'] = 1;
	}

	echo json_encode($data);
?>