<script src='Web/JS/AvatarEditModule.js'></script>
<div id="avatar" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Avatar</h2>
    <?php echo "<img id='profile-avatar' height='256' width='256' src='".$_SESSION['auth']['avatar']."' style='display: block; margin: auto; border-style: solid;
    border-width: medium;'/>"; ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePicture" style="display: block; margin: auto; width: 256px;">Change</button>
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm-delete-avatar" style="display: block; margin: auto; width: 256px;">Delete</button>
</div>
<div id="changePicture" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Avatar Picture</h4>
      </div>
      <div class="modal-body">
      <div id="createAvatarFormMessage"></div>
      <img src="" height="256" width="256" alt="Image preview..." id='imagePreviewLarge'>
      <img src="" height="36" width="36" alt="Image preview..." id='imagePreviewSmall'>
        <form id='avatar-form' method="post" action="index.php?c=settings&m=updateUserAvatar">
            <input type="file" id="newImage" name="newImage" accept="image/*" onchange="previewImage()"/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="saveImage();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div class="modal fade" id="confirm-delete-avatar" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h2>You sure you want to delete your avatar?<h2>
                <div id="deleteAvatarFormMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a id="btnDeleteAvatar" class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>