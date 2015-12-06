$(document).ready(function ()
{
    //Editor for email.
    $('.EmailUserField').click(function ()
    {
        $('#UserEditFieldsMessage').html("<div class='alert alert-warning'>Warning: Editing email will effect your login credentials.</div>");
        var email = $(this).html();
        $(this).html('');
	//Generate input form.
        $(this).after('<form name="updateEmailUserField" class="emailUserFieldUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=settings&m=updateUserEmail"><input type="text" name="emailUserField" id="' + $(this).attr('id') + '" class="form-control inputEmailUserField" style="width: 200px; display: inline;"><button type="submit" id="emailUserFieldSubmit" class="btn btn-primary" style="width:100px;">Save</button><button type="reset" class="btn btn-default" style="width:100px;" id="emailUserFieldCancel">Cancel</button></form>');
        $('#' + $(this).attr('id') + '.inputEmailUserField').val(email);
        $('#emailUserFieldCancel').click(function () {
            $('#0.EmailUserField').html(email);
            $('.emailUserFieldUpdate').remove();
        });
        $('.inputEmailUserField').on('keyup', function (e) {
            $('#UserEditFieldsMessage').html('');
            var emailRegex = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
            if (emailRegex.test($(this).val()) === false) {
                $('#UserEditFieldsMessage').html('<div class="alert alert-danger">Email is invalid.<div>');
                $('#emailUserFieldSubmit').prop('disabled', true);
                return false;
            }
            $('#emailUserFieldSubmit').prop('disabled', false);
            return true;
        });
	//Generate form submit function.
        $('#' + $(this).attr('id') + '.emailUserFieldUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=settings&m=updateUserEmail",
                type: "POST",
                data: { email: $('#' + $(this).attr('id') + '.inputEmailUserField').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'Email Updated.') {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-success'>Email Updated.</div>");
                        $('#' + $(this).attr('id') + '.EmailUserField').html($('#' + $(this).attr('id') + '.inputEmailUserField').val());
                        $(this).remove();
                    }
                    else {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-danger'>"+data+"</div>");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
    //Editor for first name.
    $('.FirstNameUserField').click(function () {
        var fname = $(this).html();
        $(this).html('');
	//Generate input form.
        $(this).after('<form name="updateFirstNameUserField" class="fnameUserFieldUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=settings&m=updateUserFirstName"><input type="text" name="fnameUserField" id="' + $(this).attr('id') + '" class="form-control inputFirstNameUserField" style="width: 200px; display: inline;"><button type="submit" class="btn btn-primary" style="width:100px;">Save</button><button type="reset" class="btn btn-default" style="width:100px;" id="fnameUserFieldCancel">Cancel</button></form>');
        $('#' + $(this).attr('id') + '.inputFirstNameUserField').val(fname);
        $('#fnameUserFieldCancel').click(function () {
            $('#0.FirstNameUserField').html(fname);
            $('.fnameUserFieldUpdate').remove();
        });
	//Generate form submit function.
        $('#' + $(this).attr('id') + '.fnameUserFieldUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=settings&m=updateUserFirstName",
                type: "POST",
                data: { firstName: $('#' + $(this).attr('id') + '.inputFirstNameUserField').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'First Name Updated.') {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-success'>"+data+"</div>");
                        $('#' + $(this).attr('id') + '.FirstNameUserField').html($('#' + $(this).attr('id') + '.inputFirstNameUserField').val());
                        $(this).remove();
                    }
                    else {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-danger'>" + data + "</div>");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
    //Editor for last name.
    $('.LastNameUserField').click(function () {
        var lname = $(this).html();
        $(this).html('');
	//Generate input form.
        $(this).after('<form name="updateLastNameUserField" class="lnameUserFieldUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=settings&m=updateUserLastName"><input type="text" name="lnameUserField" id="' + $(this).attr('id') + '" class="form-control inputLastNameUserField" style="width: 200px; display: inline;"><button type="submit" class="btn btn-primary" style="width:100px;">Save</button><button type="reset" class="btn btn-default" style="width:100px;" id="lnameUserFieldCancel">Cancel</button></form>');
        $('#' + $(this).attr('id') + '.inputLastNameUserField').val(lname);
        $('#lnameUserFieldCancel').click(function () {
            $('#0.LastNameUserField').html(lname);
            $('.lnameUserFieldUpdate').remove();
        });
	//Generate form submit function.
        $('#' + $(this).attr('id') + '.lnameUserFieldUpdate').submit(function (event) {
            event.preventDefault();
            $.ajax(
            {
                url: "index.php?c=settings&m=updateUserLastName",
                type: "POST",
                data: { lastName: $('#' + $(this).attr('id') + '.inputLastNameUserField').val() },
                context: this,
                success: function (data, textStatus, jqXHR) {
                    if (data == 'Last Name Updated.') {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-success'>" + data + "</div>");
                        $('#' + $(this).attr('id') + '.LastNameUserField').html($('#' + $(this).attr('id') + '.inputLastNameUserField').val());
                        $(this).remove();
                    }
                    else {
                        $('#UserEditFieldsMessage').html("<div class='alert alert-danger'>" + data + "</div>");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(errorThrown);
                }
            });
        });
    });
});
