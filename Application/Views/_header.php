<html>
<head>
	<link href="Web/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Web/CSS/theme.css">
	<title>Storacloud</title>
</head>
<body>
<?php 
	if(isset($_SESSION['auth']['email']))
	{
		require_once 'Application/Views/Snippets/NavBar.php';
	}
?>