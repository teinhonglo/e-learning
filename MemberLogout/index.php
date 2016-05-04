<?PHP session_start(); ?>
<?PHP
	// Clear PHP Session variable.
	session_destroy();

	// Redirect to index webpage.
	header('Location: ../index.html');
?>