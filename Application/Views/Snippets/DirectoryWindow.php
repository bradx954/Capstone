<script src='Web/JS/notify.min.js'></script>
<script src="Web/JS/BootBox.js"></script>
<script src="Web/JS/ByteStringFunctions.js"></script>
<script src="Web/JS/DirectoryWindow.js"></script>
<table class="table table-hover table-condensed table-responsive" id="DirectoryTable" style="background-color: white; color: black;">
	<tr id="headrow">
		<th>Name</th>
		<th>File Type</th>
		<th>File Size</th>
		<th>Creation Date</th>
		<th><a id="upDirectory" href="#"><img width="24" src="Web/Images/FolderUp.png" style="float: right;"/></a></th>
	</tr>
</table>
<form id="DirectoryWindowTarget" name="DirectoryWindowTarget">
<input type="hidden" name="userid" id="userid" value="<?php echo $TPL["UserID"]; ?>"/>
<input type="hidden" name="directory" id="directory" value="0"/>
</form>
