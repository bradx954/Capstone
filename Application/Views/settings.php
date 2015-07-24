<script>
function openFileImage()
{
  $("#avatar").click();
}
</script>
<div id="avatar">
    <?php echo "<img height='256' width='256' src='data:image/png;base64,".$_SESSION['auth']['avatar']."' />"; ?>
    <form id='avatar-form'>
        <input type="file" id="avatar">
    <form>
    <button type="button" class="btn btn-primary" onClick='openFileImage();return;'>Change</button>
    <button type="button" class="btn btn-default">Delete</button>
</div>