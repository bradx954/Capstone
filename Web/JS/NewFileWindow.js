/*
 * I Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.
 */
$(document).ready(function () {
    //Opens directory selector.
    $("#SelectDirectory").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.DirectorySelectPending').removeClass('DirectorySelectPending');
        $('#newDirectory').addClass('DirectorySelectPending');
        $('#excludeDirectories').attr('value', '');
        $('#DirectoryBrowser').modal();
        updateDirectoryBrowserTable(0);
    });
    //Submits new file on enter.
    $('#newFileName').keypress(function (e) {
        if (e.which == 13) {
            $("#SubmitNewFile").click();
        }
    });
    //Sets new file type to selected type.
    $(".FileIcon").click(function (e) {
        e.stopPropagation();
        $(".FileIconSelect").removeClass("FileIconSelect");
        $(this).addClass("FileIconSelect");
        $("#FileTypeExtension").html($(this).attr("extension"));
        checkNewFileValid();
    });
    //Submit file creation to server.		
    $("#SubmitNewFile").click(function (e) {
        e.stopPropagation();
        if ($(".FileIconSelect").attr('id') == "Folder")
        {
            $.ajax(
                    {
                        url: "index.php?c=files&m=newFolder",
                        type: "POST",
                        data: {filename: $("#newFileName").val(), directory: $("#newDirectory").data('actual'), UserID: $("#userid").attr("value")},
                        success: function (data, textStatus, jqXHR) {
                            if (data == "Folder Created.") {
                                $("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
                                refreshDirectoryWindow();
                                refreshSideBarFileTree();
                                showMessage(data);
                                $('#NewFileWindow').modal('toggle');
                            }
                            else {
                                $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>');
                            }
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
                        data: {filename: $("#newFileName").val() + $("#FileTypeExtension").html(), directory: $("#newDirectory").data('actual'), UserID: $("#userid").attr("value")},
                        success: function (data, textStatus, jqXHR) {
                            if (data == "File Created.") {
                                $("#FormMessage").html('<div class="alert alert-success">' + data + '</div>');
                                refreshDirectoryWindow();
                                showMessage(data);
                                $('#NewFileWindow').modal('toggle');
                            }
                            else {
                                $("#FormMessage").html('<div class="alert alert-danger">' + data + '</div>');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#FormMessage").html('<div class="alert alert-danger">' + errorThrown + '</div>');
                        }
                    });
        }
    });
});
//Enables submit button.
function checkNewFileValid()
{
    $("#SubmitNewFile").prop('disabled', false);
}
