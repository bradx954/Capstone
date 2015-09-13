<script src="Web/JS/NewFileWindow.js"></script>
<div id="NewFileWindow" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Type</h4>
      </div>
      <div class="modal-body">
	  <div id="FormMessage"></div>
		<a href="#"><div id="Folder" class="FileIcon" extension="">
			<img src="Web/Images/Folder.png" width="128"/></br>
			Folder
		</div></a>
		<a href="#"><div id="Text" class="FileIcon"  extension=".txt">
			<img src="Web/Images/Text.png" width="128"/></br>
			Text
		</div></a>
		<div class="clear"></div>
		<hr>
		<form class="form-inline">
			<table style="color: black;">
				<tr><td><b>File Name:</b></td> <td><input type="text" class="form-control" id="newFileName" name="FileName" placeholder="New File" style="width: 400px;"><span id="FileTypeExtension"></span></td></tr>
				<tr><td><b>Directory:</b></td> <td><input type="text" class="form-control" id="newDirectory" name="Directory" value="/" style="width: 400px;" disabled></td></tr>
			</table>
		</form>
      </div>
	  <div class="modal-footer">
	  <button class="btn btn-primary" id="SubmitNewFile" style="width:100%;" disabled>Confirm</button>
	  </div>
    </div>
  </div>
</div>