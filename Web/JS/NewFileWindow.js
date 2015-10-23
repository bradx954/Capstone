$(document).ready(function () {
	$("#SelectDirectory").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('.DirectorySelectPending').removeClass('DirectorySelectPending');
		$('#newDirectory').addClass('DirectorySelectPending');
		$('#DirectoryBrowser').modal();
		updateDirectoryBrowserTable(0);
	});
	$('#newFileName').keypress(function(e){
		if(e.which == 13) {
			$("#SubmitNewFile").click();
		}
	});
	$(".FileIcon").click(function (e) {
		e.stopPropagation();
		$(".FileIconSelect").removeClass("FileIconSelect");
		$(this).addClass( "FileIconSelect" );
		$("#FileTypeExtension").html($(this).attr("extension"));
		checkNewFileValid();
	});
	$("#SubmitNewFile").click(function(e) {
		e.stopPropagation();
		if($(".FileIconSelect").attr('id') == "Folder")
		{
			$.ajax(
			{
				url: "index.php?c=files&m=newFolder",
				type: "POST",
				data: {filename: $("#newFileName").val(), directory: $("#newDirectory").data('actual')},
				success: function (data, textStatus, jqXHR) {
					if (data == "Folder Created.") {
						$("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
						refreshDirectoryWindow();
						refreshSideBarFileTree();
						showMessage(data);
						$('#NewFileWindow').modal('toggle');
					}
					else { $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>');}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$("#FormMessage").html('<div class="alert alert-danger">' + errorThrown + '</div>');
				}
			});
		}
		else
		{
			$.ajax(
			{
				url: "index.php?c=files&m=newFile",
				type: "POST",
				data: {filename: $("#newFileName").val()+$("#FileTypeExtension").html(), directory: $("#newDirectory").data('actual')},
				success: function (data, textStatus, jqXHR) {
					if (data == "File Created.") {
						$("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
						refreshDirectoryWindow();
						showMessage(data);
						$('#NewFileWindow').modal('toggle');
					}
					else { $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>');}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$("#FormMessage").html('<div class="alert alert-danger">' + errorThrown + '</div>');
				}
			});
		}
	});
});
function checkNewFileValid()
{
	$("#SubmitNewFile").prop('disabled', false);
}