$(document).ready(function () {
    $('#ServerDatabaseResetUsers').click(function () {
        $.ajax(
        {
            url: "index.php?c=server&m=resetUsers",
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                if (data == "Reset Success.") { $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>'); }
                else { $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>'); }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
    });
    $('#ServerDatabaseResetAvatars').click(function () {
        $.ajax(
        {
            url: "index.php?c=server&m=resetAvatars",
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                if (data == "Reset Success.") { $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>'); }
                else { $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>'); }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
    });
    $('#ServerDatabaseResetFiles').click(function () {
        $.ajax(
        {
            url: "index.php?c=server&m=resetFiles",
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                if (data == "Reset Success.") { $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>'); }
                else { $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>'); }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
    });
    $('#ServerDatabaseResetFolders').click(function () {
        $.ajax(
        {
            url: "index.php?c=server&m=resetFolders",
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                if (data == "Reset Success.") { $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>'); }
                else { $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>'); }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
    });
});