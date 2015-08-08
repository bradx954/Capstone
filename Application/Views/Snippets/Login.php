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
        <div id="LoginFormHome">
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
        <div id="LoginFormEmail" style="display: none;">
        <h3>Enter email of account.</h3>
            <form action="index.php?c=home&m=checkEmail" method="post" name="LoginFormEmail" id="LoginFormEmail">
                <div class="form-group" id="emailGroup">
                  <label for="Email">Email address</label>
                  <div class="" id="emailValidation"></div>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="width: 100%;">
                </div>
            </form>
            <button class="btn btn-primary" id="SubmitLoginFormEmail" style="width: 100%;">Next</button>
        </div>
      </div>
    </div>
  </div>
</div>