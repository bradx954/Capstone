$(document).ready(function () {
    //Submit new avatar to server.
    $("#avatar-form").submit(function (e) {
	//Reset error messages
        $('#createAvatarFormMessage').html('');
	//Retrieve form.
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
	//Submit request.
        $.ajax(
        {
            url: formURL,
            type: "POST",
            data: { image: $("#imagePreviewLarge").attr('src') },
            success: function (data, textStatus, jqXHR) {
                if (data == 'Avatar Updated.') {
		    //Show success mesage to user.
                    $('#createAvatarFormMessage').html('<div class="alert alert-success">' + data + '</div>');
		    //Update avatar in module.
                    $("#profile-avatar").attr('src', $("#imagePreviewLarge").attr('src'));
		    //Update navbar avatar.
                    $("#avatar-icon-nav").attr('src', $("#imagePreviewLarge").attr('src'));
                }
                else 
		{ 
		    //Show error message to user.
		    $('#createAvatarFormMessage').html('<div class="alert alert-danger">' + data + '</div>'); 
		}
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#createAvatarFormMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
        e.preventDefault();	//STOP default action
        //$("#avatar-form").unbind('submit');
    });
    //Request deletion of avatar from server.
    $("#btnDeleteAvatar").click(function () {
        $.ajax(
        {
            url: "index.php?c=settings&m=deleteUserAvatar",
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                if (data == 'Avatar Deleted.') {
		    //Show message to user.
                    $('#deleteAvatarFormMessage').html('<div class="alert alert-success">' + data + '</div>');
		    //Update avatars.
                    $("#profile-avatar").attr('src', "Web/Images/default-avatar.jpg");
                    $("#avatar-icon-nav").attr('src', "Web/Images/default-avatar.jpg");
                }
                else { $('#deleteAvatarFormMessage').html('<div class="alert alert-danger">' + data + '</div>'); }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#deleteAvatarFormMessage').html('<div class="alert alert-danger">' + errorThrown + '</div>');
            }
        });
    });
});
//Submits the update avatar form.
function saveImage() {
    $('#avatar-form').submit();
}
//influenced by http://stackoverflow.com/questions/22087076/how-to-make-a-simple-image-upload-using-javascript-html
function previewImage() {
    var file = $('#newImage').prop('files')[0]; //sames as here
    var reader = new FileReader();

    reader.onloadend = function () {
        $("#imagePreviewLarge").attr('src', reader.result);
        $("#imagePreviewSmall").attr('src', reader.result);
    }

    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
}
