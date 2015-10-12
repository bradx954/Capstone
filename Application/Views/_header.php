<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="Web/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Web/CSS/theme.css">
	<link rel="shortcut icon" href="Web/Images/LogoIcon.ico" />
    <script src='Web/JS/jquery-1.11.3.min.js'></script>
    <script src='Web/bootstrap-3.3.5-dist/js/bootstrap.js'></script>
	<title>Storacloud</title>
</head>
<body style='padding-top: 50px;'>
<?php 
	if(isset($_SESSION['auth']['email']))
	{
		require_once 'Application/Views/Snippets/NavBar.php';
	}
?>