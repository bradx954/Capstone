$(document).ready(function () {
	$('#MoveFileWindow').click(function(e){e.stopPropagation();});
	$("#SelectMoveDirectory").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('.DirectorySelectPending').removeClass('DirectorySelectPending');
		$('#newMoveDirectory').addClass('DirectorySelectPending');
		$('#DirectoryBrowser').modal();
		updateDirectoryBrowserTable(0);
	});
	$("#SubmitMoveFile").click(function(e) {
		e.stopPropagation();
	});
});
function checkNewFileValid()
{
	$("#SubmitNewFile").prop('disabled', false);
}