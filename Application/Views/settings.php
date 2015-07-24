<script>
    function saveImage()
    {
        
    }
    //influenced by http://stackoverflow.com/questions/22087076/how-to-make-a-simple-image-upload-using-javascript-html
    function previewImage()
    {
       var file    = $('#newImage').prop('files')[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           $("#imagePreview").attr('src', reader.result);
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
    }
</script>
<div id="avatar">
    <?php echo "<img height='256' width='256' src='data:image/png;base64,".$_SESSION['auth']['avatar']."' />"; ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePicture">Change</button>
    <button type="button" class="btn btn-default">Delete</button>
</div>
<div id="changePicture" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Avatar Picture</h4>
      </div>
      <div class="modal-body">
      <img src="" height="256" width="256" alt="Image preview..." id='imagePreview'>
        <form id='avatar-form' method="post" action="#">
            <input type="file" id="newImage" name="newImage" accept="image/*" onchange="previewImage()">
        <form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="saveImage();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>