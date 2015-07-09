<nav class='navbar navbar-default'>
	<div class='container-fluid'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>
			<span class='sr-only'>Toggle navigation</span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
			</button>
			<a class='navbar-brand' href='index.php'>Storacloud</a>
		</div>
		<div class='nav navbar-nav navbar-right' id='bs-example-navbar-collapse-1'>
			<ul class='nav navbar-nav'>
            <li class='active'><a href='index.php?c=home'>Home</a></li>
			<li class='dropdown' id='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><?php echo $_SESSION['auth']['email']; ?></a>
				<ul class='dropdown-menu'>
				<li><a href='#'>Files</a></li>
				<li><a href='#'>Settings</a></li>
				<li><a href='index.php?c=home&m=logout'>Logout</a></li>
				</ul>
			</li>
			</ul>
		</div>
	</div>
</nav>