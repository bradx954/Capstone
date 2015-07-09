<script>
$(document).ready(function()
{
  $("#SubmitLoginForm").click(function()
  {
    document.getElementById('LoginFormMessage').innerHTML = '';
    $("#LoginForm").submit(function(e)
      {
      	var postData = $(this).serializeArray();
      	var formURL = $(this).attr("action");
      	$.ajax(
      	{
      		url : formURL,
      		type: "POST",
      		data : postData,
      		success:function(data, textStatus, jqXHR) 
      		{
            if(data == "Login Success"){window.location.assign("<?php echo $TPL['Login_Page'];?>");}
            else{document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">'+data+'</div>';}
      		},
      		error: function(jqXHR, textStatus, errorThrown) 
      		{
            document.getElementById('LoginFormMessage').innerHTML = '<div class="alert alert-danger">'+errorThrown+'</div>';
      		}
      	});
          e.preventDefault();	//STOP default action
          //e.unbind();
          $("#LoginForm").unbind('submit');
      });
      $('#LoginForm').submit();
  });
});
</script>
<div id="Login" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        <div id="LoginFormMessage"></div>
        <form action="index.php?c=home&m=login" method="post" name="LoginForm" id="LoginForm">
        <div class="form-group" id="emailGroup">
          <label for="Email">Email address</label>
          <div class="" id="emailValidation"></div>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="width: 100%;">
        </div>
        <div class="form-group"" id='passwordGroup'>
          <label for='Password'>Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="width: 100%;">
        </div>
        </form>
        <button class="btn btn-primary" id="SubmitLoginForm" style="width: 100%;">Login</button>
      </div>
    </div>
  </div>
</div>