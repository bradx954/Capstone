$(document).ready(function () {
	//Stops deselecting on file when clicking within the window.
	$('#MoveFileWindow').click(function(e){e.stopPropagation();});
	//Brings up directory browser to select destination.
	$("#SelectMoveDirectory").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('.DirectorySelectPending').removeClass('DirectorySelectPending');
		$('#newMoveDirectory').addClass('DirectorySelectPending');
		$('#excludeDirectories').attr('value',$('.RowSelect').map(function() {if($(this).hasClass("Folder")){return this.id;}}).get().join(','));
		$('#DirectoryBrowser').modal();
		updateDirectoryBrowserTable(0);
	});
	//Submits the directory change to server.
	$("#SubmitMoveFile").click(function(e) {
		e.stopPropagation();
		var operation = $('input:radio[name=operation]:checked').val();
		var folders = $('#DirectoryTable > tbody > .RowSelect.Folder').map(function(){return this.id;}).get();
		var files = $('#DirectoryTable > tbody > .RowSelect').not('.Folder').map(function(){return this.id;}).get();
		//Moves all the folders		
		if(folders.length != 0)
		{
			folders.forEach(function(entry) {
				$.ajax(
				{
					url: "index.php?c=files&m="+operation+"Folder",
					type: "POST",
					data: {ID: entry, Destination: $('#newMoveDirectory').data('actual'), UserID: $('#userid').attr('value')},
					success: function (data, textStatus, jqXHR) {
						if(data == "Folder "+operation+" completed."){
							showMessage(data);
							//Refresh data to reflect changes.
							refreshDirectoryWindow();
							refreshSideBarFileTree();
							refreshStorageUsed();
						}
						else{showError(data);}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
		}
		//Moves all the files.
		if(files.length != 0)
		{
			files.forEach(function(entry) {
				$.ajax(
				{
					url: "index.php?c=files&m="+operation+"File",
					type: "POST",
					data: {ID: entry, Destination: $('#newMoveDirectory').data('actual'), UserID: $('#userid').attr('value')},
					success: function (data, textStatus, jqXHR) {
						if(data == "File "+operation+" completed."){
							showMessage(data+' '+entry);
							refreshDirectoryWindow();
							refreshSideBarFileTree();
						}
						else{showError(data);}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
		}
	});
});
//enables submit button.
function checkNewFileValid()
{
	$("#SubmitNewFile").prop('disabled', false);
}
