/*
 * I Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.
 */
$(document).ready(function () {
    //Intial load for directory window.
    refreshDirectoryWindow();
    //Deselect on click any where that doesent have a click event handled.
    $("body").click(function (e) {
        if ($('#sideBarSaveFile').css('display') == 'none' && $('.context-menu-list').css('display') != "block")
        {
            $('.RowSelect').removeClass('RowSelect');
            displayNoneSelect();
        }
    });
    //Responsive side bar show button.
    $("#menu-show").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#wrapper").toggleClass("toggled");
        $("#menu-show").css('display', 'none');
    });
    //Right click menu for rows.
    $.contextMenu({
        selector: '.RowItem',
        build: function ($trigger, e) {
            var rows = $('.RowSelect');
            if (rows.length == 0) {
                return;
            }
            else if (rows.length == 1)
            {
                return {
                    callback: function (key, options) {
                        $('#' + key).click();
                    },
                    items: {
                        "OpenFile": {name: "Open", icon: "edit"},
                        "DownloadFile": {name: "Download", icon: "cut"},
                        "MoveFile": {name: "Copy/Move", icon: "copy"},
                        "RenameFile": {name: "Rename", icon: "paste"},
                        "DeleteFile": {name: "Delete", icon: "delete"},
                    }
                };
            }
            else
            {
                return {
                    callback: function (key, options) {
                        $('#' + key).click();
                    },
                    items: {
                        "MoveFile": {name: "Copy/Move", icon: "copy"},
                        "DeleteFile": {name: "Delete", icon: "delete"},
                    }
                };
            }

        }
    });
    //$("#DirectoryTable").tablesorter();
});
//Display Error to user.
function showError(postError) {
    $.notify(
            postError,
            {position: "down"}
    );
}
//Display message to user.
function showMessage(postMessage)
{
    $.notify(
            postMessage,
            {position: "down", className: "info"}
    );
}
//Refreshes the directory window with the chosen directory specified in the hidden form.
function refreshDirectoryWindow()
{
    $.ajax(
            {
                url: "index.php?c=files&m=getDirectoryContents",
                type: "POST",
                data: {UserID: $('#DirectoryWindowTarget').find('input[name="userid"]').val(), Directory: $('#directory').attr('value')},
                success: function (data, textStatus, jqXHR) {
                    displayNoneSelect();
                    if (data == "Access Denied.") {
                        $("#DirectoryTable").html('<div class="alert alert-danger">' + data + '</div>');
                    }
                    else
                    {
                        //Preserves/Regenerates the table header.
                        $('#DirectoryTable').html('<thead><tr id="headrow">' + $('tr[id=headrow]').html() + '</tr></thead><tbody></tbody>');
                        //Gets folder path from folder id.
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
                        //Retireves and loops through result rows.
                        var rows = JSON.parse(data);
                        for (var x in rows)
                        {
                            //Default type for files
                            var file_type = "Unknown";
                            var file_size;
                            //Determines if row is folder.
                            if (typeof rows[x]['filesize'] === 'undefined')
                            {
                                file_type = "Folder";
                                file_size = "";
                            }
                            else {
                                //Attempts to evaluate file type from extension.
                                var extension = rows[x]['name'].split(".");
                                extension = extension[extension.length - 1];
                                switch (extension.toLowerCase())
                                {
                                    case 'mp4':
                                    case 'avi':
                                    case 'mkv':
                                    case 'flv':
                                    case 'webm':
                                    case 'vob':
                                    case 'ogg':
                                    case 'ogv':
                                        file_type = "Video";
                                        break;
                                    case 'xml':
                                        file_type = "XML";
                                        break;
                                    case 'pdf':
                                        file_type = "PDF";
                                        break;
                                    case 'ppt':
                                    case 'pptx':
                                    case 'odp':
                                        file_type = "Presentation";
                                        break;
                                    case 'xlsx':
                                    case 'xls':
                                        file_type = "Spreadsheet";
                                        break;
                                    case 'doc':
                                    case 'docx':
                                    case 'odp':
                                        file_type = "Document";
                                        break;
                                    case 'zip':
                                    case 'rar':
                                    case 'gz':
                                    case '7zip':
                                        file_type = "Archive";
                                        break;
                                    case 'png':
                                    case 'gif':
                                    case 'jpg':
                                    case 'bmp':
                                        file_type = "Image";
                                        break;
                                    case 'bat':
                                    case 'sh':
                                        file_type = "Bash";
                                        break;
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
                            //Adds row to table.
                            $('#DirectoryTable > tbody:last-child').append('<tr id="' + rows[x]['id'] + '" class="' + file_type + ' RowItem"><td><a href="#" id="' + rows[x]['id'] + '" class="' + file_type + '"><img width="18" src="Web/Images/' + file_type + '.png"/>' + rows[x]['name'] + '</a></td><td>' + file_type + '</td><td>' + file_size + '</td><td>' + rows[x]['reg_date'] + '</td><td><a href="#" id="' + rows[x]['id'] + '" class="delete-file-row"><img src="Web/Images/Delete-Icon.png"  style="float: right;"/></a></td></tr>');
                        }
                    }
                    $("#DirectoryTable > tbody > tr").click(function (event) {
                        event.stopPropagation();
                    });
                    //Handles the selecting of rows.
                    $("#DirectoryTable > tbody > tr").bind('mousedown', function (e) {
                        e.stopPropagation();
                        switch (e.which) {
                            case 1:
                                if ($(this).attr('id') == 'headrow') {
                                    return;
                                }
                                if (e.ctrlKey) {
                                    if ($(this).hasClass("RowSelect")) {
                                        $(this).removeClass('RowSelect');
                                    }
                                    else {
                                        $(this).addClass('RowSelect');
                                    }
                                }
                                else
                                {
                                    $('.RowSelect').removeClass('RowSelect');
                                    if ($(this).hasClass("RowSelect")) {
                                    }
                                    else {
                                        $(this).addClass('RowSelect');
                                    }
                                }
                                var rows = $('.RowSelect');
                                if (rows.length == 0) {
                                    displayNoneSelect();
                                }
                                else if (rows.length == 1) {
                                    displaySingleSelect();
                                }
                                else {
                                    displayMultiSelect();
                                }
                                if ($('#menu-show').css('display') != 'none') {
                                    $('#menu-show').click();
                                }
                                break;
                            case 2:
                                break;
                            case 3:
                                if ($(this).attr('id') == 'headrow') {
                                    return;
                                }
                                if ($(this).hasClass("RowSelect")) {
                                }
                                else {
                                    $('.Rowselect').removeClass('RowSelect');
                                    $(this).addClass('RowSelect');
                                }
                                var rows = $('.RowSelect');
                                if (rows.length == 0) {
                                    displayNoneSelect();
                                }
                                else if (rows.length == 1) {
                                    displaySingleSelect();
                                }
                                else {
                                    displayMultiSelect();
                                }
                                break;
                            default:
                        }
                    });
                    //Enters folder or opens file on double click.
                    $("#DirectoryTable > tbody > tr").dblclick(function (e) {
                        e.stopPropagation();
                        if (e.ctrlKey) {
                            return;
                        }
                        else
                        {
                            $('a#' + $('.RowSelect').attr('id') + '.' + $('.RowSelect').attr('class').split(' ')[0]).click();
                        }
                    });
                    //Enters folder or opens file on double tap.
                    $("#DirectoryTable > tbody > tr").doubletap(function () {
                        $('a#' + $('.RowSelect').attr('id') + '.' + $('.RowSelect').attr('class').split(' ')[0]).click();
                    });
                    //Deletes row with confirmation prompt.
                    $('.delete-file-row').click(function (event) {
                        event.stopPropagation();
                        var id = $(this).attr('id');
                        var type = $('tr[id=' + id + ']').attr('class').replace(" RowSelect", "");
                        var type = type.replace(" RowItem", "");
                        var type = type.replace(" context-menu-active", "");
                        if (type != "Folder") {
                            type = type + ' file';
                        }
                        bootbox.confirm("Are you sure you want to delete this " + type + "?", function (result) {
                            if (result == true) {
                                if (type == "Folder")
                                {
                                    $.ajax(
                                            {
                                                url: "index.php?c=files&m=deleteFolder",
                                                type: "POST",
                                                data: {ID: id},
                                                success: function (data, textStatus, jqXHR) {
                                                    if (data == 'Folder deleted.') {
                                                        showMessage(data);
                                                        $('tr[id=' + id + ']').remove();
                                                        refreshSideBarFileTree();
                                                        refreshStorageUsed();
                                                    }
                                                    else {
                                                        showError(data);
                                                    }
                                                    if (rows.length == 0) {
                                                        displayNoneSelect();
                                                    }
                                                    else if (rows.length == 1) {
                                                        displaySingleSelect();
                                                    }
                                                    else {
                                                        displayNoneSelect();
                                                    }
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
                                                    if (data == 'File deleted.') {
                                                        showMessage(data);
                                                        $('tr[id=' + id + ']').remove();
                                                        refreshStorageUsed();
                                                    }
                                                    else {
                                                        showError(data);
                                                    }
                                                    if (rows.length == 0) {
                                                        displayNoneSelect();
                                                    }
                                                    else if (rows.length == 1) {
                                                        displaySingleSelect();
                                                    }
                                                    else {
                                                        displayNoneSelect();
                                                    }
                                                },
                                                error: function (jqXHR, textStatus, errorThrown) {
                                                    showError(data);
                                                }
                                            });
                                }
                            }
                        });
                    });
                    //Enters folder.
                    $('a[class=Folder]').click(function (event) {
                        event.stopPropagation();
                        $('#previousDirectoy').attr('value', $('#directory').attr('value'));
                        $('#directory').attr('value', $(this).attr('id'));
                        $('#newDirectory').data('actual', $(this).attr('id'));
                        refreshDirectoryWindow();
                    });
                    //Opens text file in editor.
                    $('a[class=Text]').click(function (event) {
                        event.stopPropagation();

                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'simplemode');

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
                    //Opens Bash file in editor.
                    $('a[class=Bash]').click(function (event) {
                        event.stopPropagation();

                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'text/x-sh');

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
                    //Opens HTML file in editor.
                    $('a[class=HTML]').click(function (event) {
                        event.stopPropagation();
                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'text/html');

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
                    //Opens javascript file in editor.
                    $('a[class=Javascript]').click(function (event) {
                        event.stopPropagation();
                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'text/javascript');

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
                    //Opens css file in editor.
                    $('a[class=CSS]').click(function (event) {
                        event.stopPropagation();
                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'text/css');

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
                    //Opens php file in editor.
                    $('a[class=PHP]').click(function (event) {
                        event.stopPropagation();
                        var id = $(this).attr('id');

                        $('#DirectoryTable').css('display', 'none');
                        displayEdit();
                        $('.CodeMirror').css('display', 'block');
                        $('.CodeMirror').data('fileid', id);

                        editor.setOption('mode', 'application/x-httpd-php');

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
                    //Goes to previous directory. Note: This button was removed in interface for design reasons.
                    $('#previousDirectory').click(function (e) {
                        e.stopPropagation();
                        var temp = $('#directory').attr('value');
                        $('#directory').attr('value', $(this).attr('value'));
                        $('#newDirectory').data('actual', $(this).attr('value'));
                        $(this).attr('value', temp);
                        refreshDirectoryWindow();
                    });
                    //Goes to parent directory.
                    $('#upDirectory').click(function (e) {
                        e.stopPropagation();
                        $.ajax(
                                {
                                    url: "index.php?c=files&m=getFolderParent",
                                    type: "POST",
                                    data: {ID: $('#directory').attr('value')},
                                    success: function (data, textStatus, jqXHR) {
                                        if (data >= 0) {
                                            $('#directory').attr('value', data);
                                            $('#newDirectory').data('actual', data);
                                            refreshDirectoryWindow();
                                        }
                                        else {
                                            showError(data);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        showError(data);
                                    }
                                });
                    });
                    //Overides the plugins sorter for the size colum to work with bytestring functions
                    $.tablesorter.addParser({
                        // set a unique id 
                        id: 'size',
                        is: function (s) {
                            // return false so this parser is not auto detected 
                            return false;
                        },
                        format: function (s) {
                            // format your data for normalization
                            if (s == "") {
                                return 0;
                            }
                            return getBytes(s) + 1;
                        },
                        // set type, either numeric or text 
                        type: 'numeric'
                    });
                    $("#DirectoryTable").tablesorter({
                        headers: {
                            2: {
                                sorter: 'size'
                            }
                        }
                    });
                    $('#DirectoryTable').filterTable({inputSelector: '#input-filter'});
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#DirectoryTable").html('<div class="alert alert-danger">' + errorThrown + '</div>');
                }
            });
}
