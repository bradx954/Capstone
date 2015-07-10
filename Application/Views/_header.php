<html>
<head>
	<link href="Web/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Web/CSS/theme.css">
    <script src='Web/JS/jquery-1.11.3.min.js'></script>
    <script src='Web/bootstrap-3.3.5-dist/js/bootstrap.js'></script>
	<title>Storacloud</title>
</head>
<body>
<?php 
	if(isset($_SESSION['auth']['email']))
	{
		require_once 'Application/Views/Snippets/NavBar.php';
	}
?>