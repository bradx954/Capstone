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
        <div id="LoginFormEmailEnter" style="display: none;">
        <h3>Enter email of account.</h3>
            <form action="index.php?c=home&m=checkEmail" method="post" name="LoginFormEmail" id="LoginFormEmail">
                <div class="form-group" id="emailGroup">
                  <label for="Email">Email address</label>
                  <div class="" id="emailValidation"></div>
                  <input type="email" class="form-control focus-control" id="email" name="email" placeholder="Email" style="width: 100%;">
                </div>
            </form>
            <button class="btn btn-primary" id="SubmitLoginFormEmail" style="width: 100%;">Next</button>
        </div>
        <div id="LoginFormAnswerEnter" style="display: none;">
        <h3>Answer Security Question.</h3>
            <form action="index.php?c=home&m=checkAnswer" method="post" name="LoginFormAnswer" id="LoginFormAnswer">
                <div class="form-group" id="answerGroup">
                  <label for="Answer" id="LoginFormQuestion"></label>
                  <input type="text" class="form-control" id="answer" name="answer" placeholder="Answer" style="width: 100%;">
                  <input type="hidden" id="email" name="email">
                </div>
            </form>
            <button class="btn btn-primary" id="SubmitLoginFormAnswer" style="width: 100%;">Next</button>
        </div>
        <div id="LoginFormPasswordEnter" style="display: none;">
        <h3>Answer Security Question.</h3>
            <form action="index.php?c=home&m=updatePassword" method="post" name="LoginFormPassword" id="LoginFormPassword">
                <div class="form-group" id='passwordGroup'>
                  <label for='Password'>Password</label>
                  <div class="" id="newpasswordStrength"></div>
                  <div class="form-inline">
                    <input type="password" class="form-control" id="newpassword1" name="password" placeholder="Password" style="width: 49%;">
                    <input type="password" class="form-control" id="newpassword2" placeholder="Password Confirm" style="width: 49%;">
                  </div>
                </div>
                <input type="hidden" id="email" name="email">
                <input type="hidden" id="answer" name="answer">
            </form>
            <button class="btn btn-primary" id="SubmitLoginFormPassword" style="width: 100%;">Reset Password</button>
        </div>
      </div>
    </div>
  </div>
</div>