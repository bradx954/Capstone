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
		<a href="#"><div id="HTML" class="FileIcon"  extension=".html">
			<img src="Web/Images/HTML.png" width="128"/></br>
			HTML
		</div></a>
		<a href="#"><div id="CSS" class="FileIcon"  extension=".css">
			<img src="Web/Images/CSS.png" width="128"/></br>
			CSS
		</div></a>
		<a href="#"><div id="Javascript" class="FileIcon"  extension=".js">
			<img src="Web/Images/Javascript.png" width="128"/></br>
			Javascript
		</div></a>
		<a href="#"><div id="PHP" class="FileIcon"  extension=".php">
			<img src="Web/Images/PHP.png" width="128"/></br>
			PHP
		</div></a>
		<a href="#"><div id="LINUX_BASH" class="FileIcon"  extension=".sh">
			<img src="Web/Images/Bash.png" width="128"/></br>
			Linux Shell
		</div></a>
		<a href="#"><div id="DOS_BASH" class="FileIcon"  extension=".bat">
			<img src="Web/Images/Bash.png" width="128"/></br>
			DOS Shell
		</div></a>
		<div class="clear"></div>
		<hr>
		<form class="form-inline">
			<table style="color: black; width: 100%;">
				<tr><td style="padding-bottom: 1em;"><b>File Name:</b></td> <td  style="padding-bottom: 1em;"><input type="text" class="form-control" id="newFileName" name="FileName" placeholder="New File" style="width: 100%;"><span id="FileTypeExtension"></span></td></tr>
				<tr><td><b>Directory:</b></td> <td><input type="text" class="form-control" id="newDirectory" name="Directory" value="/" style="width: 100%;" data-actual="0" disabled><a class="btn btn-primary" id="SelectDirectory" style="width: 100%;">Browse</a></td></tr>
			</table>
		</form>
      </div>
	  <div class="modal-footer">
	  <button class="btn btn-primary" id="SubmitNewFile" style="width:100%;" disabled>Confirm</button>
	  </div>
    </div>
  </div>
</div>