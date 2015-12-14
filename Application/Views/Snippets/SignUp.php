<!-- Sign up window. -->
<script src="Web/JS/SignUpForm.js"></script>
<div id="SignUp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sign Up</h4>
      </div>
      <div class="modal-body">
        <div id="FormMessage"></div>
        <div id="divComplete" style="display: none;">
          <div class="alert alert-success">Congrats you are all signed up!!!</div>
            <img src="Web/Images/Checkmark.png">
           <button type="button" class="btn btn-primary" data-dismiss="modal" id="modalClose" style="width: 100%;">Close</button>
        </div>
        <form action="index.php?c=home&m=registerNewUser" method="post" name="SignUpForm" id="SignUpForm">
        <div class="form-group" id="emailGroup">
          <label for="Email">Email address</label>
          <div class="" id="emailValidation"></div>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="width: 98%;">
        </div>
        <div class="form-group" id="nameGroup">
          <label for="Name">Name</label>
          <div class="form-inline">
            <input type="text" class="form-control" id="Name" name="fName" placeholder="First Name" style="width: 49%;">
            <input type="text" class="form-control" id="Name" name="lName" placeholder="Last Name" style="width: 49%;">
          </div>
        </div>
        <div class="form-group" id='passwordGroup'>
          <label for='Password'>Password</label>
          <div class="" id="passwordStrength"></div>
          <div class="form-inline">
            <input type="password" class="form-control" id="password1" name="password" placeholder="Password" style="width: 49%;">
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Password Confirm" style="width: 49%;">
          </div>
        </div>
        <div class="form-group" id="questionGroup">
          <label for="question">Security Question</label>
          <div class="form-inline">
          <select class="form-control" id="question" name="question" placeholder="Security Question" style="width: 49%;">
          <?php require 'Config/SecurityQuestions.html';?>
          </select>
          <input type="password" class="form-control" id="answer" name="answer" placeholder="Answer" style="width: 49%;">
          </div>
        </div>
        </form>
        <button class="btn btn-primary" id="SubmitForm" style="width: 100%;">Sign Up</button>
      </div>
    </div>
  </div>
</div>