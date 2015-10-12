<script src='Web/JS/FilesSideBar.js'></script>
<link href='Web/startbootstrap-simple-sidebar-1.0.4/css/simple-sidebar.css' rel='stylesheet'>
<div id="wrapper">
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                <?php echo $_SESSION['auth']['email'];?>
            </a>
			<a href="#menu-hide" class="btn btn-primary" id="menu-hide" style="color: white;"><<</a>
        </li>
        <li id="sideBarNewFile">
			<button class="btn btn-primary" id="New" data-toggle="modal" data-target="#NewFileWindow" style="width: 80%; margin: auto;">New</button>
		</li>
		<li id="FilesBarFolderTree">
		</li>
		<li id="sideBarSaveFile" style="display: none; margin-bottom: 5px;">
			<button class="btn btn-primary" id="SaveFile" style="width: 80%; margin: auto;">Save & Close</button>
		</li>
		<li id="sideBarCancelFile" style="display: none;">
			<button class="btn btn-primary" id="CancelFile" style="width: 80%; margin: auto;">Cancel</button>
		</li>
    </ul>
</div>