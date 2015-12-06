/*
 * I Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.
 */
$(document).ready(function () {
    //Resets the users table.
    $('#ServerDatabaseResetUsers').click(function () {
        $.ajax(
                {
                    url: "index.php?c=server&m=resetUsers",
                    type: "POST",
                    data: {},
                    success: function (data, textStatus, jqXHR) {
                        if (data == "Reset Success.") {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>');
                        }
                        else {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
                    }
                });
    });
    //Resets the avatars table.
    $('#ServerDatabaseResetAvatars').click(function () {
        $.ajax(
                {
                    url: "index.php?c=server&m=resetAvatars",
                    type: "POST",
                    data: {},
                    success: function (data, textStatus, jqXHR) {
                        if (data == "Reset Success.") {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>');
                        }
                        else {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
                    }
                });
    });
    //Resets the files table.
    $('#ServerDatabaseResetFiles').click(function () {
        $.ajax(
                {
                    url: "index.php?c=server&m=resetFiles",
                    type: "POST",
                    data: {},
                    success: function (data, textStatus, jqXHR) {
                        if (data == "Reset Success.") {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>');
                        }
                        else {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
                    }
                });
    });
    //Resets folder table
    $('#ServerDatabaseResetFolders').click(function () {
        $.ajax(
                {
                    url: "index.php?c=server&m=resetFolders",
                    type: "POST",
                    data: {},
                    success: function (data, textStatus, jqXHR) {
                        if (data == "Reset Success.") {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-success">' + data + '</div>');
                        }
                        else {
                            $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + data + '</div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#ServerDatabaseMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
                    }
                });
    });
});
