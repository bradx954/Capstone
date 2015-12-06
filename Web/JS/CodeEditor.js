//Handles the ctrl-s event to save code in the editor.
$(document).ready(function () {
  document.addEventListener("keydown", function(e) {
  if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
    e.preventDefault();
    $.ajax(
		{
			url: "index.php?c=files&m=updateFile",
			type: "POST",
			data: {ID: $('.CodeMirror').data('fileid'), Contents: editor.getValue()},
			success: function (data, textStatus, jqXHR) {
				if(data == 'File Updated.'){
						showMessage(data);
						refreshStorageUsed();
					}
				else{showError(data);}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				showError(data);
			}
		});
  }
}, false);
});
