$(document).ready(function () {
	$('#DirectoryBrowser').click(function(e){e.stopPropagation();});
	$("#ConfirmDirectory").click(function(event) 
	{
		event.stopPropagation();
		
		if($('#DirectoryBrowserTable > tbody > .RowSelect').length != 0)
		{
			$('.DirectorySelectPending').data('actual',$('#DirectoryBrowserTable > tbody > .RowSelect').attr('id'));
			$.ajax(
			{
						url: "index.php?c=files&m=getFolderPath",
						type: "POST",
						data: {ID: $('#DirectoryBrowserTable > tbody > .RowSelect').attr('id')},
						success: function (data, textStatus, jqXHR) {
							$('.DirectorySelectPending').attr('value', data);
							$('.DirectorySelectPending').removeClass('DirectorySelectPending');
							$('#DirectoryBrowser').modal('toggle');
						},
						error: function (jqXHR, textStatus, errorThrown) {
							showError(data);
						}
			});
		}
		else
		{
		$('.DirectorySelectPending').data('actual',0);
		$('.DirectorySelectPending').attr('value', '/');
		$('.DirectorySelectPending').removeClass('DirectorySelectPending');
		$('#DirectoryBrowser').modal('toggle');
		}
		$('#excludeDirectories').attr('value','');
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
					if(jQuery.inArray(rows[x]['id'],excludeDirectories) == -1){$('#DirectoryBrowserTable tr:last').after('<tr id="'+rows[x]['id']+'"><td><img width="64" src="Web/Images/Folder.png"/>'+rows[x]['name']+'</td></tr>');}
				}
			}
			$("#DirectoryBrowserTable > tbody > tr").click(function(event) {
				event.stopPropagation();
				});
			$("#DirectoryBrowserTable > tbody > tr").bind('mousedown',function(event) {
				event.stopPropagation();
				switch (event.which) {
					case 1:
						if($(this).attr('id') == 'browserheadrow'){return;}
						if($(this).hasClass( "RowSelect" )){}
						else{$('#DirectoryBrowserTable > tbody > .RowSelect').removeClass('RowSelect');$(this).addClass('RowSelect');$('#ConfirmDirectory').prop('disabled', false);}
						break;
					case 2:
						break;
					case 3:
						break;
					default:
				}
			});
			$("#DirectoryBrowserTable > tbody > tr").doubletap(function() {
			  $('#ConfirmDirectory').prop('disabled', true);
			  updateDirectoryBrowserTable($('.RowSelect').attr('id'));
			  return false;
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