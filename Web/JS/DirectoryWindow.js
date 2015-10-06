$(document).ready(function () {
	refreshDirectoryWindow();
});
function showError(postError) {
    $.notify(
  postError,
  { position: "down" }
);
}
function showMessage(postMessage)
{
    $.notify(
  postMessage,
  { position: "down", className: "info" }
);
}
function refreshDirectoryWindow()
{
	$.ajax(
	{
		url: "index.php?c=files&m=getDirectoryContents",
		type: "POST",
		data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: $('#directory').attr('value')},
		success: function (data, textStatus, jqXHR) {
			if (data == "Access Denied.") {
				$("#DirectoryTable").html('<div class="alert alert-danger">' + data + '</div>');
			}
			else 
			{ 
				$('#DirectoryTable').html('<tr id="headrow">'+$('tr[id=headrow]').html()+'</tr>');
				$.ajax(
				{
					url: "index.php?c=files&m=getFolderPath",
					type: "POST",
					data: {ID: $('#directory').attr('value')},
					success: function (data, textStatus, jqXHR) {
						$('#newDirectory').attr('value', data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					var file_type = "Unknown";
					var file_size = "?";
					if(typeof rows[x]['filesize'] === 'undefined')
					{
						file_type = "Folder";
					}
					else{
						var extension = rows[x]['name'].split(".");
						extension = extension[extension.length-1];
						switch(extension)
						{
							case 'txt':
								file_type = "Text";
							break;
							case 'html':
								file_type = "HTML";
							break;
							case 'css':
								file_type = "CSS";
							break;
							case 'js':
								file_type = "Javascript";
							break;
							case 'php':
								file_type = "PHP";
							break;
						}
						file_size = getByteString(rows[x]['filesize']);
					}
					$('#DirectoryTable tr:last').after('<tr id="'+rows[x]['id']+'" class="'+file_type+'"><td><a href="#" id="'+rows[x]['id']+'" class="'+file_type+'"><img width="18" src="Web/Images/'+file_type+'.png"/>'+rows[x]['name']+'</a></td><td>'+file_type+'</td><td>'+file_size+'</td><td>'+rows[x]['reg_date']+'</td><td><a href="#" id="'+rows[x]['id']+'" class="delete-file-row"><img src="Web/Images/Delete-Icon.png"/></a></td></tr>');
				}
			}
			$('.delete-file-row').click(function () {
				var id = $(this).attr('id');
				var type = $('tr[id='+id+']').attr('class');
				bootbox.confirm("Are you sure you want to delete this "+type+"?", function(result) {
					if(result == true){
						if(type == "Folder")
						{
							$.ajax(
							{
								url: "index.php?c=files&m=deleteFolder",
								type: "POST",
								data: {ID: id},
								success: function (data, textStatus, jqXHR) {
									if(data == 'Folder deleted.'){showMessage(data); $('tr[id='+id+']').remove(); refreshSideBarFileTree();}
									else{showError(data);}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									showError(data);
								}
							});
						}
						else
						{
							$.ajax(
							{
								url: "index.php?c=files&m=deleteFile",
								type: "POST",
								data: {ID: id},
								success: function (data, textStatus, jqXHR) {
									if(data == 'File deleted.'){showMessage(data); $('tr[id='+id+']').remove();}
									else{showError(data);}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									showError(data);
								}
							});
						}
					}
				});
			});
			$('a[class=Folder]').click(function () {
				$('#previousDirectoy').attr('value', $('#directory').attr('value'));
				$('#directory').attr('value', $(this).attr('id'));
				$('#newDirectory').attr('actual', $(this).attr('id'));
				refreshDirectoryWindow();
			});
			$('a[class=Text]').click(function () {
				var id = $(this).attr('id');
				
				$('#DirectoryTable').css('display','none');
				$('#sideBarNewFile').css('display','none');
				$('#FilesBarFolderTree').css('display','none');
				$('#sideBarSaveFile').css('display','block');
				$('#sideBarCancelFile').css('display','block');
				$('.CodeMirror').css('display','block');
				$('.CodeMirror').data('fileid', id);
				
				editor.setOption('mode','simplemode');
				
				$.ajax(
				{
					url: "index.php?c=files&m=getFile",
					type: "POST",
					data: {ID: id},
					success: function (data, textStatus, jqXHR) {
						editor.setValue(data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
			$('a[class=HTML]').click(function () {
				var id = $(this).attr('id');
				
				$('#DirectoryTable').css('display','none');
				$('#sideBarNewFile').css('display','none');
				$('#FilesBarFolderTree').css('display','none');
				$('#sideBarSaveFile').css('display','block');
				$('#sideBarCancelFile').css('display','block');
				$('.CodeMirror').css('display','block');
				$('.CodeMirror').data('fileid', id);
				
				editor.setOption('mode','text/html');
				
				$.ajax(
				{
					url: "index.php?c=files&m=getFile",
					type: "POST",
					data: {ID: id},
					success: function (data, textStatus, jqXHR) {
						editor.setValue(data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
			$('a[class=Javascript]').click(function () {
				var id = $(this).attr('id');
				
				$('#DirectoryTable').css('display','none');
				$('#sideBarNewFile').css('display','none');
				$('#FilesBarFolderTree').css('display','none');
				$('#sideBarSaveFile').css('display','block');
				$('#sideBarCancelFile').css('display','block');
				$('.CodeMirror').css('display','block');
				$('.CodeMirror').data('fileid', id);
				
				editor.setOption('mode','text/javascript');
				
				$.ajax(
				{
					url: "index.php?c=files&m=getFile",
					type: "POST",
					data: {ID: id},
					success: function (data, textStatus, jqXHR) {
						editor.setValue(data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
			$('a[class=CSS]').click(function () {
				var id = $(this).attr('id');
				
				$('#DirectoryTable').css('display','none');
				$('#sideBarNewFile').css('display','none');
				$('#FilesBarFolderTree').css('display','none');
				$('#sideBarSaveFile').css('display','block');
				$('#sideBarCancelFile').css('display','block');
				$('.CodeMirror').css('display','block');
				$('.CodeMirror').data('fileid', id);
				
				editor.setOption('mode','text/css');
				
				$.ajax(
				{
					url: "index.php?c=files&m=getFile",
					type: "POST",
					data: {ID: id},
					success: function (data, textStatus, jqXHR) {
						editor.setValue(data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
			$('a[class=PHP]').click(function () {
				var id = $(this).attr('id');
				
				$('#DirectoryTable').css('display','none');
				$('#sideBarNewFile').css('display','none');
				$('#FilesBarFolderTree').css('display','none');
				$('#sideBarSaveFile').css('display','block');
				$('#sideBarCancelFile').css('display','block');
				$('.CodeMirror').css('display','block');
				$('.CodeMirror').data('fileid', id);
				
				editor.setOption('mode','application/x-httpd-php');
				
				$.ajax(
				{
					url: "index.php?c=files&m=getFile",
					type: "POST",
					data: {ID: id},
					success: function (data, textStatus, jqXHR) {
						editor.setValue(data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
			$('#previousDirectory').click(function () {
				var temp = $('#directory').attr('value');
				$('#directory').attr('value', $(this).attr('value'));
				$('#newDirectory').attr('actual', $(this).attr('value'));
				$(this).attr('value', temp);
				refreshDirectoryWindow();
			});
			$('#upDirectory').click(function () {
				$.ajax(
				{
					url: "index.php?c=files&m=getFolderParent",
					type: "POST",
					data: {ID: $('#directory').attr('value')},
					success: function (data, textStatus, jqXHR) {
						if(data >= 0){
							$('#directory').attr('value', data);
							$('#newDirectory').attr('actual', data);
							refreshDirectoryWindow();
						}
						else{showError(data);}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
				});
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#DirectoryTable").html('<div class="alert alert-danger">' + errorThrown + '</div>');
		}
	});
}
