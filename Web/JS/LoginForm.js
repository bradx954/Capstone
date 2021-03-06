/*
 * I Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.
 */
$(document).ready(function () {
    //Submits login request if enter is pressed.
    $('#password').keypress(function (e) {
        if (e.which == 13) {
            $("#SubmitLoginForm").click();
        }
    });
    $('#newpassword1, #newpassword2').on('keyup', function (e) {
        if ($('#newpassword1').val() != '' && $('#newpassword2').val() != '' && $('#newpassword1').val() != $('#newpassword2').val()) {
            $('#newpasswordStrength').removeClass().addClass('alert alert-danger').html('Passwords do not match!');
            return false;
        }
        // Must have capital letter, numbers and lowercase letters
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");

        // Must have either capitals and lowercase letters or lowercase and numbers
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");

        // Must be at least 9 characters long
        var okRegex = new RegExp("(?=.{9,}).*", "g");

        if (okRegex.test($(this).val()) === false) {
            // If ok regex doesn't match the password
            $('#newpasswordStrength').removeClass().addClass('alert alert-danger').html('Password must be 6 characters long.');
            return false;
        } else if (strongRegex.test($(this).val())) {
            // If reg ex matches strong password
            $('#newpasswordStrength').removeClass().addClass('alert alert-success').html('Good Password!');
        } else if (mediumRegex.test($(this).val())) {
            // If medium password matches the reg ex
            $('#newpasswordStrength').removeClass().addClass('alert alert-info').html('Make your password stronger with more capital letters, more numbers and special characters!');
        } else {
            // If password is ok
            $('#newpasswordStrength').removeClass().addClass('alert alert-danger').html('Weak Password, try using numbers and capital letters.');
        }
        return true;
    });
    //Submits login request. Redirects to files page on success.
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
                            if (data == "Login Success") {
                                window.location.assign("index.php?c=files");
                            }
                            else {
                                document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + data + '</div>';
                            }
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
    //Displays forgot password form.
    $("#loginForgotPassowrd").click(function () {
        $("#LoginFormHome").css('display', 'none');
        $("#LoginFormEmailEnter").css('display', 'block');
    });
    $("#SubmitLoginFormEmail").click(function () {
        $('#LoginFormEmail').submit();
    });
    //If email is valid moves to next recovery step.
    $("#LoginFormEmail").submit(function (e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data, textStatus, jqXHR) {
                        if (data != "Error retreiving user id." && data != "No user with specified email found.")
                        {
                            $("#LoginFormEmailEnter").css('display', 'none');
                            $('#LoginFormAnswerEnter').css('display', 'block');
                            $('#LoginFormQuestion').html(data);
                            $('#LoginFormAnswer input[id=email]').val($('#LoginFormEmail input[id=email]').val());
                            document.getElementById('LoginFormMessage').innerHTML = "";
                        }
                        else {
                            document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + data + '</div>';
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + errorThrown + '</div>';
                    }
                });
        e.preventDefault();	//STOP default action
    });
    //Submits answer to the question to the server.
    $("#LoginFormAnswer").submit(function (e) {
        e.preventDefault();
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data, textStatus, jqXHR) {
                        if (data == "Answer Correct.") {
                            $('#LoginFormAnswerEnter').css('display', 'none');
                            $('#LoginFormPasswordEnter').css('display', 'block');
                            $('#LoginFormPassword input[id=email]').val($('#LoginFormEmail input[id=email]').val());
                            $('#LoginFormPassword input[id=answer]').val($('#LoginFormAnswer input[id=answer]').val());
                            document.getElementById('LoginFormMessage').innerHTML = "";
                        }
                        else {
                            document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + data + '</div>';
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + errorThrown + '</div>';
                    }
                });
        e.preventDefault();	//STOP default action
        //e.unbind();
    });
    $("#SubmitLoginFormAnswer").click(function () {
        $('#LoginFormAnswer').submit();
    });
    $("#SubmitLoginFormPassword").click(function () {
        $('#newpassword1, #newpassword2').keyup();
        $('#LoginFormPassword').submit();
    });
    //Returns to home page after new password set.
    $("#LoginFormPassword").submit(function (e) {
        e.preventDefault();
        var valid = true;
        $('#newpassword1, #newpassword2').keyup();
        if (!$('#newpasswordStrength').hasClass('alert-success')) {
            valid = false;
            document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">Password not strong enough.</div>';
        }
        else {
            $("#passwordGroup").attr("class", "form-group");
        }
        if (valid)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
                    {
                        url: formURL,
                        type: "POST",
                        data: postData,
                        success: function (data, textStatus, jqXHR) {
                            if (data == "Password Updated.") {
                                document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-success">' + data + '</div>';
                                $('#LoginFormPasswordEnter').css('display', 'none');
                                $('#LoginFormHome').css('display', 'block');
                            }
                            else {
                                document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + data + '</div>';
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">' + errorThrown + '</div>';
                        }
                    });
        }
        
    });
    $('#newpassword1').keypress(function (e) {
        if (e.which == 13) {
            $("#LoginFormPassword").submit();
        }
    });
    $('#newpassword2').keypress(function (e) {
        if (e.which == 13) {
            $("#LoginFormPassword").submit();
        }
    });
    $("#LoginButton").click(function (e)
    {
        $('#email.focus-control').focus();
    }
    );
});
