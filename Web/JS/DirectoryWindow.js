var test = "No Work.";
$(document).ready(function () {
	refreshDirectoryWindow();
});
function refreshDirectoryWindow()
{
	$.ajax(
	{
		url: "index.php?c=files&m=getDirectoryContents",
		type: "POST",
		data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: $('#DirectoryWindowTarget').find('input[name="directory"]').val()},
		success: function (data, textStatus, jqXHR) {
			if (data == "Access Denied.") {
				$("#DirectoryTable").html('<div class="alert alert-danger">' + data + '</div>');
			}
			else 
			{ 
				$('#DirectoryTable').html('<tr><th>Name</th><th>File Type</th><th>File Size</th><th>Creation Date</th></tr>');
				var rows = JSON.parse(data);
				for(var x in rows)
				{
					var file_type = "Unknown";
					var file_size = "?";
					if(typeof rows[x]['filelocation'] === 'undefined'){file_type = "Folder";}
					else{
						var extension = rows[x]['name'].split(".");
						extension = extension[extension.length-1];
						switch(extension)
						{
							case 'txt': file_type = "Text";
						}
						file_size = rows[x]['filesize'];
					}
					$('#DirectoryTable tr:last').after('<tr><td>'+rows[x]['name']+'</td><td>'+file_type+'</td><td>'+file_size+'</td><td>'+rows[x]['reg_date']+'</td></tr>');
				}
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#DirectoryTable").html('<div class="alert alert-danger">' + errorThrown + '</div>');
		}
	});
}