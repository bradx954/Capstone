$(document).ready(function () {
	$("#ConfirmDirectory").click(function(event) 
	{
		event.stopPropagation();
		$('.DirectorySelectPending').data('actual',$('#DirectoryBrowserTable > tbody > .Rowselect').attr('id'));
		$.ajax(
		{
					url: "index.php?c=files&m=getFolderPath",
					type: "POST",
					data: {ID: $('#DirectoryBrowserTable > tbody > .Rowselect').attr('id')},
					success: function (data, textStatus, jqXHR) {
						$('.DirectorySelectPending').attr('value', data);
						$('.DirectorySelectPending').removeClass('DirectorySelectPending');
						$('#DirectoryBrowser').modal('toggle');
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showError(data);
					}
		});
	});
});
function updateDirectoryBrowserTable(selectID)
{
	selectID = typeof selectID !== 'undefined' ? selectID : 0;
	if(selectID != 0)
	{
		$("#upBrowseDirectory").unbind( "click" );
		$('#upBrowseDirectory').click(function () {
			$('#ConfirmDirectory').prop('disabled', true);
			$.ajax(
			{
				url: "index.php?c=files&m=getFolderParent",
				type: "POST",
				data: {ID: selectID},
				success: function (data, textStatus, jqXHR) {
					if(data >= 0){
						updateDirectoryBrowserTable(data);
					}
					else{showError(data);}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					showError(data);
				}
			});
		});
	}
	var excludeDirectories = $('#excludeDirectories').attr('value').split(',');
	$.ajax(
	{
		url: "index.php?c=files&m=getDirectoryFolders",
		type: "POST",
		data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: selectID},
		success: function (data, textStatus, jqXHR) {
			displayNoneSelect();
			if (data == "Access Denied.") {
				$("#DirectoryBrowserFormMessage").html('<div class="alert alert-danger">' + data + '</div>');
			}
			else 
			{ 
				$('#DirectoryBrowserTable').html('<tr id="browserheadrow"></tr>');
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					$('#DirectoryBrowserTable tr:last').after('<tr id="'+rows[x]['id']+'"><td><img width="64" src="Web/Images/Folder.png"/>'+rows[x]['name']+'</td></tr>');
				}
			}
			$("#DirectoryBrowserTable > tbody > tr").click(function(event) {event.stopPropagation();});
			$("#DirectoryBrowserTable > tbody > tr").mousedown(function(event) {
				event.stopPropagation();
				switch (event.which) {
					case 1:
						if($(this).attr('id') == 'browserheadrow'){return;}
						$('#DirectoryBrowserTable > tbody > .Rowselect').removeClass('RowSelect');
						if($(this).hasClass( "RowSelect" )){}
						else{$(this).addClass('RowSelect');$('#ConfirmDirectory').prop('disabled', false);}
						break;
					case 2:
						break;
					case 3:
						if($(this).attr('id') == 'browserheadrow'){return;}
						if($(this).hasClass( "RowSelect" )){}
						else{$('#DirectoryBrowserTable > tbody > .Rowselect').removeClass('RowSelect');$(this).addClass('RowSelect');}
						break;
					default:
				}
			});
			$("#DirectoryBrowserTable > tbody > tr").dblclick(function(e) {
			  e.stopPropagation();
			  $('#ConfirmDirectory').prop('disabled', true);
			  updateDirectoryBrowserTable($(this).attr('id'));
			  return false;
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#DirectoryBrowserFormMessage").html('<div class="alert alert-danger">' + errorThrown + '</div>');
		}
	});
	
}