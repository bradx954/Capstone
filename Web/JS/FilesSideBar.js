$(document).ready(function () {
	$('#New').click(function () {
		$('#FormMessage').html('');
	});
	refreshSideBarFileTree();
});
function refreshSideBarFileTree()
{
	$('#FilesBarFolderTree').html('<ul id="TreeFolders" style="color: black;"></ul>');
	$.ajax(
	{
		url: "index.php?c=files&m=getDirectoryFolders",
		type: "POST",
		data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: $('#directory').attr('value')},
		success: function (data, textStatus, jqXHR) {
			if (data == "Access Denied.") {
				$("#FilesBarFolderTree").html('<div class="alert alert-danger">' + data + '</div>');
			}
			else 
			{ 
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					$('#FilesBarFolderTree ul').append('<li id="'+rows[x]['id']+'" class="FolderItem" data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a></li>');
				}
				setBranches();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#FilesBarFolderTree").html('<div class="alert alert-danger">' + errorThrown + '</div>');
		}
	});
}
function setBranches()
{
	$('.FolderBranch').click(function () {
		var id=$(this).attr('id');
		var open = $('#'+id+'.FolderItem').data('open');
		if(open == '0')
		{
			$.ajax(
			{
				url: "index.php?c=files&m=getDirectoryFolders",
				type: "POST",
				data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: $(this).attr('id')},
				success: function (data, textStatus, jqXHR) {
					if (data == "Access Denied.") {
						$('#'+id+'.FolderItem').html('<div class="alert alert-danger">' + data + '</div>');
					}
					else 
					{ 
						$('#'+id+'.FolderItem').html($('#'+id+'.FolderItem').html()+'<ul style="color: black;" id="'+id+'"></ul>');
						$('#'+id+'.FolderItem').data('open', 1);
						var rows = JSON.parse(data);
						for(var x in rows)
						{
							$('#'+id+' ul').append('<li id="'+rows[x]['id']+'" class="FolderItem"  data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a></li>');
						}
						$( ".FolderBranch" ).unbind();
						setBranches();
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('#'+id+'.FolderItem').html('<div class="alert alert-danger">' + errorThrown + '</div>');
				}
			});
		}
		else
		{
			$('#'+id+'.FolderItem').html('<a href="#" class="FolderBranch" id="'+id+'">'+$('#'+id+'.FolderItem').data('name')+'</a>');
			$('#'+id+'.FolderItem').data('open', 0);
			$( ".FolderBranch" ).unbind();
			setBranches();
		}
		$('#directory').attr('value', id);
		refreshDirectoryWindow();
	});
}
