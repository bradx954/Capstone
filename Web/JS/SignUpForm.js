$(document).ready(function () {
	$('#answer').keypress(function(e){
		if(e.which == 13) {
			$("#SubmitForm").click();
		}
	});
    //borrowed heavely from http://css.dzone.com/articles/create-password-strength
    $('#password1, #password2').on('keyup', function (e) {
        if ($('#password1').val() != '' && $('#password2').val() != '' && $('#password1').val() != $('#password2').val()) {
            $('#passwordStrength').removeClass().addClass('alert alert-danger').html('Passwords do not match!');
            return false;
        }
        // Must have capital letter, numbers and lowercase letters
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");

        // Must have either capitals and lowercase letters or lowercase and numbers
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");

        // Must be at least 6 characters long
        var okRegex = new RegExp("(?=.{6,}).*", "g");

        if (okRegex.test($(this).val()) === false) {
            // If ok regex doesn't match the password
            $('#passwordStrength').removeClass().addClass('alert alert-danger').html('Password must be 6 characters long.');
            return false;
        } else if (strongRegex.test($(this).val())) {
            // If reg ex matches strong password
            $('#passwordStrength').removeClass().addClass('alert alert-success').html('Good Password!');
        } else if (mediumRegex.test($(this).val())) {
            // If medium password matches the reg ex
            $('#passwordStrength').removeClass().addClass('alert alert-info').html('Make your password stronger with more capital letters, more numbers and special characters!');
        } else {
            // If password is ok
            $('#passwordStrength').removeClass().addClass('alert alert-danger').html('Weak Password, try using numbers and capital letters.');
        }
        return true;
    });
    $('#email').on('keyup', function (e) {
        $('#emailValidation').removeClass().addClass('').html('');
        var emailRegex = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
        if (emailRegex.test($(this).val()) === false) {
            $('#emailValidation').removeClass().addClass('alert alert-danger').html('Email is invalid.');
            return false;
        }
        return true;
    });
    $("#SubmitForm").click(function () {
        document.getElementById('FormMessage').innerHTML = '';

        var valid = true;

        if ($('#email').keyup() == false) { valid = false; }
        if ($('#password1, #password2').keyup() == false) { valid = false; }

        Form = document.forms['SignUpForm'];
        if (Form.elements['email'].value == '') { valid = false; $("#emailGroup").attr("class", "form-group has-error"); }
        else { $("#emailGroup").attr("class", "form-group"); }
        if (Form.elements['fName'].value == '' || Form.elements['lName'].value == '') { valid = false; $("#nameGroup").attr("class", "form-group has-error"); }
        else { $("#nameGroup").attr("class", "form-group"); }
        if (Form.elements['password'].value == '') { valid = false; $("#passwordGroup").attr("class", "form-group has-error"); }
        else { $("#passwordGroup").attr("class", "form-group"); }
        if (Form.elements['answer'].value == '') { valid = false; $("#questionGroup").attr("class", "form-group has-error"); }
        else { $("#questionGroup").attr("class", "form-group"); }

        if (valid) {
            $("#SignUpForm").submit(function (e) {
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data, textStatus, jqXHR) {
                        if (data == '<div class="alert alert-success">Sign up complete!</div>') {
                            document.getElementById('FormMessage').innerHTML = '';
                            document.getElementById('SignUpForm').style.display = 'none';
                            document.getElementById('SubmitForm').style.display = 'none';
                            document.getElementById('divComplete').style.display = 'block';
                        }
                        else { document.getElementById('FormMessage').innerHTML = data; }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById('FormMessage').innerHTML = '<div class="alert alert-danger">' + errorThrown + '</div>';
                    }
                });
                e.preventDefault();	//STOP default action
                //e.unbind();
                $("#SignUpForm").unbind('submit');
            });
            $('#SignUpForm').submit();
        }
        else {
            document.getElementById('FormMessage').innerHTML = '<div class="alert alert-danger">Some fields are blank.</div>';
        }
    });
    $("#modalClose").click(function () {
        document.getElementById('FormMessage').innerHTML = '';
        document.getElementById('SignUpForm').style.display = 'block';
        document.getElementById('SubmitForm').style.display = 'block';
        document.getElementById('divComplete').style.display = 'none';
    });
});
