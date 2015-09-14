<script src="Web/JS/DirectoryWindow.js"></script>
<table class="table" id="DirectoryTable" style="background-color: white; color: black;">
	<tr>
		<th>Name</th>
		<th>File Type</th>
		<th>File Size</th>
		<th>Creation Date</th>
	</tr>
</table>
<form id="DirectoryWindowTarget" name="DirectoryWindowTarget">
<input type="hidden" name="userid" id="userid" value="<?php echo $TPL["UserID"]; ?>"/>
<input type="hidden" name="directory" id="directory" value="0"/>
</form>