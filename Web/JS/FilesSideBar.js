$(document).ready(function () {
	$('#New').click(function (e) {
		e.stopPropagation();
		$('#NewFileWindow').modal();
		$('#FormMessage').html('');
	});
	$('#DeleteFile').click(function (e) {
		e.stopPropagation();
		var rows = $('.RowSelect');
		if(rows.length == 1){$('#'+$('.RowSelect').attr('id')+'.delete-file-row').click();}
		else if(rows.length == 0){return;}
		else
		{
			bootbox.confirm("Are you sure you want to delete these "+rows.length+" items?", function(result) {
				if(result == true){
					$('.RowSelect').each(function (i, row) {
						if($(row).hasClass('Folder') == true)
						{
							$.ajax(
							{
								url: "index.php?c=files&m=deleteFolder",
								type: "POST",
								data: {ID: $(row).attr('id')},
								success: function (data, textStatus, jqXHR) {
									if(data == 'Folder deleted.'){showMessage(data); $('tr[id='+$(row).attr('id')+']').remove(); refreshSideBarFileTree();}
									else{showError(data);}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									showError(errorThrown);
								}
							});
						}
						else
						{
							$.ajax(
							{
								url: "index.php?c=files&m=deleteFile",
								type: "POST",
								data: {ID: $(row).attr('id')},
								success: function (data, textStatus, jqXHR) {
									if(data == 'File deleted.'){showMessage(data); $('tr[id='+$(row).attr('id')+']').remove();}
									else{showError(data);}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									showError(errorThrown);
								}
							});
						}
						displayNoneSelect();
					});
				}
			});
		}
	});
	$('#OpenFile').click(function (e) {
		e.stopPropagation();
		var rows = $('.RowSelect');
		if(rows.length == 1){$('a#'+$('.RowSelect').attr('id')+'.'+$('.RowSelect').attr('class').split(' ')[0]).click();}
		else{return;}
	});
	$('#DownloadFile').click(function (e) {
		e.stopPropagation();
		if($('.RowSelect').hasClass('Folder'))
		{
			post('index.php?c=files&m=getFolderDownload', {ID: $('.RowSelect').attr('id')});
		}
		else
		{
			bootbox.dialog({
			  message: "Compress as zip?",
			  title: "Compress?",
			  buttons: {
				yes: {
				  label: "Yes",
				  className: "btn-success",
				  callback: function() {
					post('index.php?c=files&m=getFileDownload', {ID: $('.RowSelect').attr('id'), COMPRESS: 'true'});
				  }
				},
				no: {
				  label: "No",
				  className: "btn-primary",
				  callback: function() {
					post('index.php?c=files&m=getFileDownload', {ID: $('.RowSelect').attr('id'), COMPRESS: 'false'});
				  }
				}
			  }
			});
			$(".bootbox").click(function(e) {
				e.stopPropagation();
			});
		}
	});
	$('#MoveFile').click(function (e) {
		e.stopPropagation();
		$('#MoveFileWindow').modal();
		$('#MoveFileFormMessage').html('');
	});
	$('#RenameFile').click(function (e) {
		e.stopPropagation();
		var Name = $('a#'+$('.RowSelect').attr('id')+'.'+$('.RowSelect').attr('class').split(' ')[0]).html();
		var Type = $('.RowSelect').attr('class').split(' ')[0];
		if(Type != 'Folder'){Type = 'File';}
		bootbox.prompt("Enter new "+Type+" name.", function(result) 
		{                
		  if (result === null) {
			  
		  } else {
			$.ajax(
			{
				url: "index.php?c=files&m=rename"+Type,
				type: "POST",
				data: {ID: $('.RowSelect').attr('id'), Contents: result},
				success: function (data, textStatus, jqXHR) {
					if(data == 'File Renamed.' || data == 'Folder Renamed.'){
							showMessage(data);
							refreshDirectoryWindow();
						}
					else{showError(data);}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					showError(errorThrown);
				}
			});
		  }
		});
		
	});
	$('#SaveFile').click(function (e) {
		e.stopPropagation();
		$.ajax(
		{
			url: "index.php?c=files&m=updateFile",
			type: "POST",
			data: {ID: $('.CodeMirror').data('fileid'), Contents: editor.getValue()},
			success: function (data, textStatus, jqXHR) {
				if(data == 'File Updated.'){
						showMessage(data);
						var rows = $('.RowSelect');
						if(rows.length == 0){displayNoneSelect();}
						else if(rows.length == 1){displaySingleSelect();}
						else{displayMultiSelect();}
						
						$('#DirectoryTable').css('display','table');
						$('.CodeMirror').css('display','none');
						refreshDirectoryWindow();
					}
				else{showError(data);}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				showError(errorThrown);
			}
		});
	});
	$('#CancelFile').click(function (e) {
		e.stopPropagation();
		bootbox.confirm("Are you sure you want to discard changes?", function(result) {
				if(result == true){
					var rows = $('.RowSelect');
					if(rows.length == 0){displayNoneSelect();}
					else if(rows.length == 1){displaySingleSelect();}
					else{displayMultiSelect();}
					
					$('#DirectoryTable').css('display','table');
					$('.CodeMirror').css('display','none');
				}
			});
	});
	$("#menu-hide").click(function(e) {
        e.preventDefault();
		e.stopPropagation();
        $("#wrapper").toggleClass("toggled");
		$("#menu-show").css('display','table');
    });
	refreshSideBarFileTree();
});
function displayEdit()
{
	$('#sideBarNewFile').css('display','none');
	$('#sideBarUploadFile').css('display','none');
	$('#sideBarMoveFile').css('display','none');
	$('#sideBarDownloadFile').css('display','none');
	$('#FilesBarFolderTree').css('display','none');
	$('#sideBarSaveFile').css('display','block');
	$('#sideBarCancelFile').css('display','block');
	$('#sideBarRenameFile').css('display','none');
	$('#sideBarOpenFile').css('display','none');
	$('#sideBarDeleteFile').css('display','none');
}
function displayNoneSelect()
{
	$('#sideBarNewFile').css('display','block');
	$('#sideBarUploadFile').css('display','block');
	$('#sideBarMoveFile').css('display','none');
	$('#sideBarDownloadFile').css('display','none');
	$('#FilesBarFolderTree').css('display','block');
	$('#sideBarSaveFile').css('display','none');
	$('#sideBarCancelFile').css('display','none');
	$('#sideBarRenameFile').css('display','none');
	$('#sideBarOpenFile').css('display','none');
	$('#sideBarDeleteFile').css('display','none');
}
function displaySingleSelect()
{
	$('#sideBarNewFile').css('display','none');
	$('#sideBarUploadFile').css('display','none');
	$('#sideBarMoveFile').css('display','block');
	$('#sideBarDownloadFile').css('display','block');
	$('#FilesBarFolderTree').css('display','block');
	$('#sideBarSaveFile').css('display','none');
	$('#sideBarCancelFile').css('display','none');
	$('#sideBarRenameFile').css('display','block');
	$('#sideBarOpenFile').css('display','block');
	$('#sideBarDeleteFile').css('display','block');
}
function displayMultiSelect()
{
	$('#sideBarNewFile').css('display','none');
	$('#sideBarUploadFile').css('display','none');
	$('#sideBarMoveFile').css('display','block');
	$('#sideBarDownloadFile').css('display','none');
	$('#FilesBarFolderTree').css('display','block');
	$('#sideBarSaveFile').css('display','none');
	$('#sideBarCancelFile').css('display','none');
	$('#sideBarRenameFile').css('display','none');
	$('#sideBarOpenFile').css('display','none');
	$('#sideBarDeleteFile').css('display','block');
}
function refreshSideBarFileTree()
{
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
				$('#FilesBarFolderTree').html('<ul><li id="0" class="FolderItem" data-open=1 data-name="/"><a href="#" class="FolderOpen" id="0">/</a></li><ul id="TreeFolders" style="color: black;"></ul></ul>');
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					$('#FilesBarFolderTree ul#TreeFolders').append('<li id="'+rows[x]['id']+'" class="FolderItem" data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">+ </a><img width="16" src="Web/Images/Folder.png"/><a href="#" class="FolderOpen" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a></li>');
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
							$('#'+id+' ul').append('<li id="'+rows[x]['id']+'" class="FolderItem"  data-open=0 data-name="'+rows[x]['name']+'"><a href="#" class="FolderBranch" id="'+rows[x]['id']+'">+ </a><img width="16" src="Web/Images/Folder.png"/><a href="#" class="FolderOpen" id="'+rows[x]['id']+'">'+rows[x]['name']+'</a>');
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
			$('#'+id+'.FolderItem').html('<a href="#" class="FolderBranch" id="'+id+'">+ </a><img width="16" src="Web/Images/Folder.png"/><a href="#" class="FolderOpen" id="'+id+'">'+$('#'+id+'.FolderItem').data('name')+'</a>');
			$('#'+id+'.FolderItem').data('open', 0);
			$( ".FolderBranch" ).unbind();
			setBranches();
		}
	});
}
//Source: http://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

	//window.open('', 'newWindow');
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
	//form.setAttribute("target", 'newWindow');

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
