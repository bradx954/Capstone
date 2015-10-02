$(document).ready(function () {
	$('#New').click(function () {
		$('#FormMessage').html('');
	});
	$('#SaveFile').click(function () {
		$.ajax(
		{
			url: "index.php?c=files&m=updateFile",
			type: "POST",
			data: {ID: $('.CodeMirror').data('fileid'), Contents: editor.getValue()},
			success: function (data, textStatus, jqXHR) {
				if(data == 'File Updated.'){
						showMessage(data);
						$('#DirectoryTable').css('display','block');
						$('#sideBarNewFile').css('display','block');
						$('#FilesBarFolderTree').css('display','block');
						$('#sideBarSaveFile').css('display','none');
						$('#sideBarCancelFile').css('display','none');
						$('.CodeMirror').css('display','none');
						refreshDirectoryWindow();
					}
				else{showError(data);}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				showError(data);
			}
		});
	});
	$('#CancelFile').click(function () {
		bootbox.confirm("Are you sure you want to discard changes?", function(result) {
				if(result == true){
					$('#DirectoryTable').css('display','block');
					$('#sideBarNewFile').css('display','block');
					$('#FilesBarFolderTree').css('display','block');
					$('#sideBarSaveFile').css('display','none');
					$('#sideBarCancelFile').css('display','none');
					$('.CodeMirror').css('display','none');
				}
			});
	});
	refreshSideBarFileTree();
});
function refreshSideBarFileTree()
{
	$('#FilesBarFolderTree').html('<ul><li id="0" class="FolderItem" data-open=1 data-name="/"><a href="#" class="FolderOpen" id="0">/</a></li><ul id="TreeFolders" style="color: black;"></ul></ul>');
	$.ajax(
	{
		url: "index.php?c=files&m=getDirectoryFolders",
		type: "POST",
		data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: 0},
		success: function (data, textStatus, jqXHR) {
			if (data == "Access Denied.") {
				$("#FilesBarFolderTree").html('<div class="alert alert-danger">' + data + '</div>');
			}
			else 
			{ 
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					$('#FilesBarFolderTree ul#TreeFolders').append('<li id="'+rows[x]['id']+'" class="FolderItem" data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">+ </a><a href="#" class="FolderOpen" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a></li>');
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
	$('.FolderOpen').click(function () {
		var id=$(this).attr('id');
		$('#directory').attr('value', id);
		$('#newDirectory').attr('actual', id);
		refreshDirectoryWindow();
	});
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
							$('#'+id+' ul').append('<li id="'+rows[x]['id']+'" class="FolderItem"  data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">+ </a><a href="#" class="FolderOpen" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a>');
						}
						$('#'+id+".FolderBranch" ).html('- ');
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
			$('#'+id+'.FolderItem').html('<a href="#" class="FolderBranch" id="'+id+'">+ </a><a href="#" class="FolderOpen" id="'+id+'">'+$('#'+id+'.FolderItem').data('name')+'</a>');
			$('#'+id+'.FolderItem').data('open', 0);
			$( ".FolderBranch" ).unbind();
			setBranches();
		}
	});
}
