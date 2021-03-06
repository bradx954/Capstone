<!-- Directory window. -->
<script src='Web/JS/notify.min.js'></script>
<script src="Web/JS/BootBox.js"></script>
<script src="Web/JS/ByteStringFunctions.js"></script>
<script src="Web/JS/jquery.filtertable.min.js"></script>
<script src="Web/JS/jquery.tablesorter.min.js"></script>
<script src="Web/JS/DirectoryWindow.js"></script>
<script src="Web/JS/doubleTap.js"></script>
<link rel="stylesheet" href="Web/jQuery-contextMenu-master/dist/jquery.contextMenu.min.css" type='text/css'/>
<script src="Web/jQuery-contextMenu-master/dist/jquery.contextMenu.min.js"></script>
<script src="Web/jQuery-contextMenu-master/dist/jquery.ui.position.min.js"></script>
<input id="input-filter" class="form-control" placeholder="Filter" style="width: 100%; color: black; border-radius: 0 !important;"/>
<!-- Table for directory items. -->
<table class="table table-hover table-condensed table-responsive tablesorter" id="DirectoryTable" style="background-color: white; color: black;">
	<thead>
		<tr id="headrow">
			<th>Name</th>
			<th>File Type</th>
			<th>File Size</th>
			<th>Creation Date</th>
			<th><a id="upDirectory" href="#"><img width="24" src="Web/Images/FolderUp.png" style="float: right;"/></a></th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<form id="DirectoryWindowTarget" name="DirectoryWindowTarget">
<!-- User ID for retrieving directory. -->
<input type="hidden" name="userid" id="userid" value="<?php echo $TPL["UserID"]; ?>"/>
<!-- Directory ID to show. 0=User home directory. -->
<input type="hidden" name="directory" id="directory" value="0"/>
</form>
