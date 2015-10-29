$(document).ready(function () {
	$('#MoveFileWindow').click(function(e){e.stopPropagation();});
	$("#SelectMoveDirectory").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('.DirectorySelectPending').removeClass('DirectorySelectPending');
		$('#newMoveDirectory').addClass('DirectorySelectPending');
		$('#excludeDirectories').attr('value',$('.RowSelect').map(function() {if($(this).hasClass("Folder")){return this.id;}}).get().join(','));
		$('#DirectoryBrowser').modal();
		updateDirectoryBrowserTable(0);
	});
	$("#SubmitMoveFile").click(function(e) {
		e.stopPropagation();
		var operation = $('input:radio[name=operation]:checked').val();
		var folders = $('#DirectoryTable > tbody > .RowSelect.Folder').map(function(){return this.id;}).get();
		var files = $('#DirectoryTable > tbody > .RowSelect').not('.Folder').map(function(){return this.id;}).get();
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
function checkNewFileValid()
{
	$("#SubmitNewFile").prop('disabled', false);
}