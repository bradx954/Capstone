<script src="Web/JS/LoginForm.js"></script>
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
        <a href="#" id='loginForgotPassowrd'>Forgot Password?</a>
        <button class="btn btn-primary" id="SubmitLoginForm" style="width: 100%;">Login</button>
      </div>
    </div>
  </div>
</div>