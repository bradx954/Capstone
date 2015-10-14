<script src='Web/JS/FilesSideBar.js'></script>
<link href='Web/startbootstrap-simple-sidebar-1.0.4/css/simple-sidebar.css' rel='stylesheet'>
<div id="wrapper">
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                <?php echo $_SESSION['auth']['email'];?>
            </a>
			<a href="#menu-hide" class="btn btn-primary" id="menu-hide" style="color: grey; background-color: white; text-align: center;border: none;"><<</a>
        </li>
        <li id="sideBarNewFile">
			<button class="btn btn-primary" id="New" data-toggle="modal" data-target="#NewFileWindow" style="width: 80%; margin: auto;">New</button>
		</li>
		<li id="sideBarUploadFile">
			<button class="btn btn-primary" id="UploadFile" data-toggle="modal" data-target="#UploadFileWindow" style="width: 80%; margin-top: 5px;">Upload</button>
		</li>
		<li id="sideBarOpenFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="OpenFile" style="width: 80%; margin: auto;">Open</button>
		</li>
		<li id="sideBarRenameFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="RenameFile" style="width: 80%; margin: auto;">Rename</button>
		</li>
		<li id="sideBarMoveFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="MoveFile" style="width: 80%; margin: auto;">Copy/Move</button>
		</li>
		<li id="sideBarDownloadFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="DownloadFile" style="width: 80%; margin: auto;">Download</button>
		</li>
		<li id="sideBarDeleteFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="DeleteFile" style="width: 80%; margin: auto;">Delete</button>
		</li>
		<li id="FilesBarFolderTree">
		</li>
		<li id="sideBarSaveFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="SaveFile" style="width: 80%; margin: auto;">Save & Close</button>
		</li>
		<li id="sideBarCancelFile" style="display: none; margin-top: 5px;">
			<button class="btn btn-primary" id="CancelFile" style="width: 80%; margin: auto;">Cancel</button>
		</li>
    </ul>
</div>