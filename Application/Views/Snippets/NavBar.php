<nav class='navbar navbar-default'>
	<div class='container-fluid'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#links' aria-expanded='false'>
			<span class='sr-only'>Toggle navigation</span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
			</button>
			<a class='navbar-brand' href='index.php'>Storacloud</a>
		</div>
        <div class="collapse navbar-collapse" id="links">
            <div class='nav navbar-nav'>
                <li <?php if($TPL['page'] == 'home'){echo "class='active'";}?>><a href='index.php?c=home'>Home</a></li>
                <li <?php if($TPL['page'] == 'files'){echo "class='active'";}?>><a href='#'>Files</a></li>
                <?php if($GLOBALS['config']['acl']['users'][$_SESSION['auth']['accesslevel']] == true){echo "<li "; if($TPL['page'] == 'users'){echo "class='active'";}echo"><a href='index.php?c=users'>Users</a></li>";} ?>
            </div>
            <div class='nav navbar-nav navbar-right'>
                <li><a><img height='32' width='32' style='padding: 0px;' src='data:image/png;base64, <?php echo $_SESSION['auth']['avatar'];?>' /></a></li>
                <li><a><?php echo $_SESSION['auth']['email']; ?></a></li>
                <li><a href='index.php?c=settings&m=index'>Settings</a></li>
                <li><a href='index.php?c=home&m=logout'>Logout</a></li>
		    </div>
        </div>
	</div>
</nav>