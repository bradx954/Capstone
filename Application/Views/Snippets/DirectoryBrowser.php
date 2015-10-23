<script src='Web/JS/DirectoryBrowser.js'></script>
<div id="DirectoryBrowser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="width: 300px; margin-left: 150px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Directory</h4>
      </div>
      <div class="modal-body">
	  <div id="DirectoryBrowserFormMessage"></div>
	  <a id="upBrowseDirectory" href="#"><img width="24" src="Web/Images/FolderUp.png" style="float: right;"/></a>
		<table id="DirectoryBrowserTable" class="table-hover" style="background-color: white; color: black; width: 100%;">
		</table>
		<div class="clear"></div>
      </div>
	  <div class="modal-footer">
	  <input type="hidden" id="excludeDirectories" name="excludeDirectories" value="">
	  <button class="btn btn-primary" id="ConfirmDirectory" style="width:100%;" disabled>Confirm</button>
	  </div>
    </div>
  </div>
</div>