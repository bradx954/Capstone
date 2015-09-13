$(document).ready(function () {
	$(".FileIcon").click(function () {
		$(".FileIconSelect").removeClass("FileIconSelect");
		$(this).addClass( "FileIconSelect" );
		$("#FileTypeExtension").html($(this).attr("extension"));
		checkNewFileValid();
	});
	$("#SubmitNewFile").click(function() {
		if($(".FileIconSelect").attr('id') == "Folder")
		{
			$.ajax(
			{
				url: "index.php?c=files&m=newFolder",
				type: "POST",
				data: {filename: $("#newFileName").val(), directory: $("#newDirectory").val()},
				success: function (data, textStatus, jqXHR) {
					if (data == "Folder Created.") {
						$("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
					}
					else { $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>'); }
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
				data: {filename: $("#newFileName").val()+$("#FileTypeExtension").html(), directory: $("#newDirectory").val()},
				success: function (data, textStatus, jqXHR) {
					if (data == "File Created.") {
						$("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
					}
					else { $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>'); }
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