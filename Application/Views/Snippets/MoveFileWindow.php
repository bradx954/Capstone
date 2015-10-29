<script src="Web/JS/MoveFileWindow.js"></script>
<div id="MoveFileWindow" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Move/Copy</h4>
      </div>
      <div class="modal-body">
	  <div id="MoveFileFormMessage"></div>
		<form class="form-inline">
			<table style="color: black; width: 100%;">
				<tr><td><b>Destination Directory:</b></td> <td><input type="text" class="form-control" id="newMoveDirectory" name="Directory" value="/" style="width: 100%;" data-actual="0" disabled><button class="btn btn-primary" id="SelectMoveDirectory" style="width: 100%;">Browse</button></td></tr>
				<tr><td><b>Operation:</b></td><td><input type="radio" name="operation" value="Copy" class="radio" checked>Copy<input type="radio" name="operation" value="Move" class="radio">Move</td></tr>
			</table>
		</form>
      </div>
	  <div class="modal-footer">
	  <button class="btn btn-primary" id="SubmitMoveFile" style="width:100%;">Confirm</button>
	  </div>
    </div>
  </div>
</div>