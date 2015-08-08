$(document).ready(function () {
    $("#SubmitLoginForm").click(function () {
        document.getElementById('LoginFormMessage').innerHTML = '';
        $("#LoginForm").submit(function (e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
            {
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    if (data == "Login Success") { window.location.assign("index.php"); }
                    else { document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + data + '</div>'; }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + errorThrown + '</div>';
                }
            });
            e.preventDefault();	//STOP default action
            //e.unbind();
            $("#LoginForm").unbind('submit');
        });
        $('#LoginForm').submit();
    });
    $("#loginForgotPassowrd").click(function () {
        $("#LoginFormHome").css('display', 'none');
        $("#LoginFormHomeEmail").css('display', 'block');
    });
});
