<!-- Home page. -->
<div class='divReadable'>
<h1 class='txtCenter'>StoraCloud</h1>
<img src='Web/Images/Logo.png'>
<center>
	<button type="button" id='SignUpButton' class="btn btn-lg btn-default" data-toggle="modal" data-target="#SignUp" style="width: 150px; margin-right: 40px;">Sign Up</button>
	<button type="button" id='LoginButton' class="btn btn-lg btn-default" data-toggle="modal" data-target="#Login" style="width: 150px; margin-left: 40px;">Login</button>
	<h3><?php echo $TPL['Users'];?> users registered so far. Totaling <?php echo $TPL['Bytes'];?> bytes stored.</h3>
</center>
<p>Storacloud is cloud hosting site that allows you to upload, manage, download, and create your own personal files. The project was developed entirely by Brad Baago through the mohawk college Capstone project. Passwords are secured using best practices as of 2015. Due to the purely academic nature of this project data preservation is not guaranteed. It is best not to use this site for any sort of productive activity.  </p>
<div>
<?php require_once 'Application/Views/Snippets/SignUp.php';?>
<?php require_once 'Application/Views/Snippets/Login.php';?>