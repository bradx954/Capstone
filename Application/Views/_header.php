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
		echo 
		"
			<nav class='navbar navbar-default navbar-right'>
				<div class='container-fluid'>
					<div class='navbar-header'>
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><button class='btn btn-primary navbar-btn'>".$_SESSION['auth']['email']."</button></a>
						<ul class='dropdown-menu'>
						<li><a href='#'>Files</a></li>
						<li><a href='#'>Settings</a></li>
			            <li><a href='index.php?c=home&m=logout'>Logout</a></li>
			          </ul>
					</li>
					</div>
				</div>
			</nav>
		";
	}
?>