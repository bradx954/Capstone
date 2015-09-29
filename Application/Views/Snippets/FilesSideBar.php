<script src='Web/JS/FilesSideBar.js'></script>
<link href='Web/startbootstrap-simple-sidebar-1.0.4/css/simple-sidebar.css' rel='stylesheet'>
<div id="wrapper">
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                <?php echo $_SESSION['auth']['email'];?>
            </a>
        </li>
        <li><button class="btn btn-primary" id="New" data-toggle="modal" data-target="#NewFileWindow" style="width: 80%; margin: auto;">New</button></li>
	<li id="FilesBarFolderTree"></li>
    </ul>
</div>
