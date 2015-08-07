//Requires byte string functions.
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
$(document).ready(function () {
    $('.active').click(function () {
        if ($(this).html() == 'True') {
            $.ajax(
            {
                url: "index.php?c=users&m=deactivateUser",
                type: "POST",
                data: { id: $(this).attr('id') },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'User Deactivated.') {
                        showMessage(data);
                        $(this).css('color', 'red');
                        $(this).html("False");
                    }
                    else if (data == 'Record no longer exists.') {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        }
        else {
            $.ajax(
            {
                url: "index.php?c=users&m=activateUser",
                type: "POST",
                data: { id: $(this).attr('id') },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'User Activated.') {
                        showMessage(data);
                        $(this).css('color', 'green');
                        $(this).html("True");
                    }
                    else if (data == 'Record no longer exists.')
                    {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        }
    });
    $('.quota').click(function () {
        var byteSplit = $(this).html().split(' ');
        $(this).html('');
        $(this).after('<form name="updateQuota" class="quotaUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserQuota"><input type="number" name="bytes" id="' + $(this).attr('id') + '" class="form-control inputBytes" style="width: 100px; display: inline;"><select name="byteString" id="' + $(this).attr('id') + '" class="form-control byteString" style="width: 75px; display: inline;"><option value="B">B</option><option value="KB">KB</option><option value="MB">MB</option><option value="GB">GB</option></select><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputBytes').val(byteSplit[0]);
        $('#' + $(this).attr('id') + '.byteString').val(byteSplit[1]);
        $('#' + $(this).attr('id') + '.quotaUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=users&m=updateUserQuota",
                type: "POST",
                data: { id: $(this).attr('id'), bytes: getBytes($('#' + $(this).attr('id') + '.inputBytes').val() + ' ' + $('#' + $(this).attr('id') + '.byteString').val()) },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'Quota Updated.') {
                        showMessage(data);
                        $('#' + $(this).attr('id') + '.quota').html($('#' + $(this).attr('id') + '.inputBytes').val() + ' ' + $('#' + $(this).attr('id') + '.byteString').val());
                        $(this).remove();
                    }
                    else if (data == 'Record no longer exists.') {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
    $('.email').click(function () {
        var email = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateEmail" class="emailUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserEmail"><input type="text" name="email" id="' + $(this).attr('id') + '" class="form-control inputEmail" style="width: 300px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputEmail').val(email);
        $('#' + $(this).attr('id') + '.emailUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=users&m=updateUserEmail",
                type: "POST",
                data: { id: $(this).attr('id'), email: $('#' + $(this).attr('id') + '.inputEmail').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'Email Updated.') {
                        showMessage(data);
                        $('#' + $(this).attr('id') + '.email').html($('#' + $(this).attr('id') + '.inputEmail').val());
                        $(this).remove();
                    }
                    else if (data == 'Record no longer exists.') {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
    $('.firstName').click(function () {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateFirstName" class="firstNameUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserFirstName"><input type="text" name="firstName" id="' + $(this).attr('id') + '" class="form-control inputFirstName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputFirstName').val(name);
        $('#' + $(this).attr('id') + '.firstNameUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=users&m=updateUserFirstName",
                type: "POST",
                data: { id: $(this).attr('id'), firstName: $('#' + $(this).attr('id') + '.inputFirstName').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'First Name Updated.') {
                        showMessage(data);
                        $('#' + $(this).attr('id') + '.firstName').html($('#' + $(this).attr('id') + '.inputFirstName').val());
                        $(this).remove();
                    }
                    else if (data == 'Record no longer exists.') {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
            event.preventDefault();
            $.post("index.php?c=users&m=updateUserFirstName", { id: $(this).attr('id'), firstName: $('#' + $(this).attr('id') + '.inputFirstName').val() });
        });
    });
    $('.lastName').click(function () {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateLastName" class="lastNameUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserLastName"><input type="text" name="lastName" id="' + $(this).attr('id') + '" class="form-control inputLastName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputLastName').val(name);
        $('#' + $(this).attr('id') + '.lastNameUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=users&m=updateUserLastName",
                type: "POST",
                data: { id: $(this).attr('id'), lastName: $('#' + $(this).attr('id') + '.inputLastName').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'Last Name Updated.') {
                        showMessage(data);
                        $('#' + $(this).attr('id') + '.lastName').html($('#' + $(this).attr('id') + '.inputLastName').val());
                        $(this).remove();
                    }
                    else if (data == 'Record no longer exists.') {
                        $('tr#' + $(this).attr('id')).remove();
                        showError(data);
                    }
                    else {
                        showError(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
    $('.rank').change(function () {
        $.ajax(
        {
            url: "index.php?c=users&m=updateUserRank",
            type: "POST",
            data: { id: $(this).attr('id'), rank: $(this).val() },
            context: this,
            success: function (data, textStatus, jqXHR) {
                if (data == 'Rank Updated.') {
                    showMessage(data);
                }
                else if (data == 'Record no longer exists.') {
                    $('tr#' + $(this).attr('id')).remove();
                    showError(data);
                }
                else {
                    showError(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showError(errorThrown);
            }
        });
    });
    $('.delete').click(function () {
        $.ajax(
        {
            url: "index.php?c=users&m=deleteUser",
            type: "POST",
            data: { id: $(this).attr('id') },
            context: this,
            success: function (data, textStatus, jqXHR) {
                if (data == 'User ' + $(this).attr('id') + ' deleted.') {
                    showMessage(data);
                    $('tr#' + $(this).attr('id')).remove();
                }
                else if (data == 'Record no longer exists.') {
                    $('tr#' + $(this).attr('id')).remove();
                    showError(data);
                }
                else {
                    showError(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showError(errorThrown);
            }
        });
    });
});