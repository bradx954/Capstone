<script src='Web/JS/FilesSideBar.js'></script>
<link href='Web/startbootstrap-simple-sidebar-1.0.4/css/simple-sidebar.css' rel='stylesheet'>
<div id="wrapper">
<div id="sidebar-wrapper">
    <ul class="sidebar-nav" style="height: 100%;">
        <li>
		<a href="#menu-hide" class="btn btn-primary" id="menu-hide" style="color: grey; background-color: white; text-align: center;border: none; float: right;"><<</a>
		</li>
		<li>
		<select class="form-control" id="UserIDDropDown" style="width: 90%; margin-top: 5px; margin-bottom: 5px; margin-left: auto; margin-right: auto;">
			<?php echo $TPL['Users'];?>
		 </select>
        </li>
        <li id="sideBarNewFile">
			<button class="btn btn-primary" id="New" data-toggle="modal" data-target="#NewFileWindow" style="width: 80%; margin: auto;">New</button>
		</li>
		<li id="sideBarUploadFile">
			<button class="btn btn-primary" id="UploadFile" data-toggle="modal" data-target="#UploadFileWindow" style="width: 80%; margin-top: 5px;">Upload</button>
			<form id="uploadFileForm" method="post" enctype="multipart/form-data"><input type="file" id="uploadFile" name="uploadFile[]" style="display:none"></form>
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
		<li style="position:absolute;left:10;right:10;bottom: 50;color: black">
			<span id="bytesUsed" style=""></span>
			<div class="progress">
				
				<div class="progress-bar" role="progressbar" id="storageUsed" aria-valuenow="0"
				aria-valuemin="0" aria-valuemax="100" style="width:0%; color: black;">
				
				</div>
			</div>
		</li>
    </ul>
</div>