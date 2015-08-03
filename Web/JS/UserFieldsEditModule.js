$(document).ready(function ()
{
    $('.EmailUserField').click(function ()
    {
        var email = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateEmailUserField" class="emailUserFieldUpdate" id="' + $(this).attr('id') + '" method="post" action="index.php?c=settings&m=updateUserEmail"><input type="text" name="emailUserField" id="' + $(this).attr('id') + '" class="form-control inputEmailUserField" style="width: 300px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#' + $(this).attr('id') + '.inputEmailUserField').val(email);
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
});