function getByteString(bytes) {
    var divisible = true;
    var divided = 0;
    while (divisible) {
        if (bytes > 999) {
            bytes = bytes / 1000;
            divided++;
        }
        else { divisible = false; }
    }
    switch (divided) {
        case 0:
            return bytes + ' B';
            break;
        case 1:
            return bytes + ' KB';
            break;
        case 2:
            return bytes + ' MB';
            break;
        case 3:
            return bytes + ' GB';
            break;
        default:
            return bytes + ' GB';
    }
}
function getBytes(byteString) {
    var byteSplit = byteString.split(" ");
    switch (byteSplit[1]) {
        case 'B': return byteSplit[0];
        case 'KB': return byteSplit[0] * 1000;
        case 'MB': return byteSplit[0] * 1000 * 1000;
        case 'GB': return byteSplit[0] * 1000 * 1000 * 1000;
        default: return byteSplit[0];
    }
}
function makeChange(formURL, postData) {
    var postReturn;
    $.ajax(
    {
        url: formURL,
        type: "POST",
        data: postData,
        success: function (data, textStatus, jqXHR) {
            postReturn = Array(0, data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            postReturn = Array(1, errorThrown);
        }
    });
    return postReturn;
}
$(document).ready(function () {
    $('.active').click(function () {
        if ($(this).html() == 'True') {
            var postResponse = makeChange("index.php?c=admin&m=deactivateUser", { id: $(this).attr('id') });
            //$.post("index.php?c=admin&m=deactivateUser", { id: $(this).attr('id') });
            if (postResponse[0] == 0) {
                $(this).css('color', 'red');
                $(this).html("False");
            }
        }
        else {
            var postResponse = makeChange("index.php?c=admin&m=activateUser", { id: $(this).attr('id') });
            //$.post("index.php?c=admin&m=activateUser", { id: $(this).attr('id') });
            if (postResponse[0] == 0) {
                $(this).css('color', 'green');
                $(this).html("True");
            }
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
            $.post("index.php?c=admin&m=updateUserQuota", { id: $(this).attr('id'), bytes: getBytes($('#' + $(this).attr('id') + '.inputBytes').val() + ' ' + $('#' + $(this).attr('id') + '.byteString').val()) });
            $('#' + $(this).attr('id') + '.quota').html($('#' + $(this).attr('id') + '.inputBytes').val() + ' ' + $('#' + $(this).attr('id') + '.byteString').val());
            $(this).remove();
        });
    });
    $('.email').click(function () {
        var email = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateEmail" class="emailUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserEmail"><input type="text" name="email" id="' + $(this).attr('id') + '" class="form-control inputEmail" style="width: 300px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputEmail').val(email);
        $('#' + $(this).attr('id') + '.emailUpdate').submit(function (event) {
            event.preventDefault();
            $.post("index.php?c=admin&m=updateUserEmail", { id: $(this).attr('id'), email: $('#' + $(this).attr('id') + '.inputEmail').val() });
            $('#' + $(this).attr('id') + '.email').html($('#' + $(this).attr('id') + '.inputEmail').val());
            $(this).remove();
        });
    });
    $('.firstName').click(function () {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateFirstName" class="firstNameUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserFirstName"><input type="text" name="firstName" id="' + $(this).attr('id') + '" class="form-control inputFirstName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputFirstName').val(name);
        $('#' + $(this).attr('id') + '.firstNameUpdate').submit(function (event) {
            event.preventDefault();
            $.post("index.php?c=admin&m=updateUserFirstName", { id: $(this).attr('id'), firstName: $('#' + $(this).attr('id') + '.inputFirstName').val() });
            $('#' + $(this).attr('id') + '.firstName').html($('#' + $(this).attr('id') + '.inputFirstName').val());
            $(this).remove();
        });
    });
    $('.lastName').click(function () {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateLastName" class="lastNameUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=admin&m=updateUserLastName"><input type="text" name="lastName" id="' + $(this).attr('id') + '" class="form-control inputLastName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputLastName').val(name);
        $('#' + $(this).attr('id') + '.lastNameUpdate').submit(function (event) {
            event.preventDefault();
            $.post("index.php?c=admin&m=updateUserLastName", { id: $(this).attr('id'), lastName: $('#' + $(this).attr('id') + '.inputLastName').val() });
            $('#' + $(this).attr('id') + '.lastName').html($('#' + $(this).attr('id') + '.inputLastName').val());
            $(this).remove();
        });
    });
    $('.rank').change(function () {
        $.post("index.php?c=admin&m=updateUserRank", { id: $(this).attr('id'), rank: $(this).val() });
    });
    $('.delete').click(function () {
        $.post("index.php?c=admin&m=deleteUser", { id: $(this).attr('id') });
        $('tr#' + $(this).attr('id')).remove();
    });
});