<div class='divReadable'>
<h1 class='txtCenter'>StoraCloud</h1>
<img src='Web/Images/Logo.png'>
<center>
	<button type="button" id='SignUpButton' class="btn btn-lg btn-default" data-toggle="modal" data-target="#SignUp" style="width: 150px; margin-right: 40px;">Sign Up</button>
	<button type="button" id='LoginButton' class="btn btn-lg btn-default" data-toggle="modal" data-target="#Login" style="width: 150px; margin-left: 40px;">Login</button>
	<h3><?php echo $TPL['Users'];?> users registered so far. Totaling <?php echo $TPL['Bytes'];?> bytes stored.</h3>
</center>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc hendrerit, nisl in lobortis ullamcorper, sapien sem suscipit nisl, eu pulvinar eros lectus at elit. Mauris at pharetra massa. Vestibulum nec faucibus ante, et egestas purus. Curabitur suscipit dictum feugiat. Morbi id vehicula dui, sed iaculis lorem. Vivamus eu fringilla massa. Sed ultrices, odio porttitor auctor auctor, lacus velit scelerisque libero, eu laoreet ex mauris quis enim. Sed massa turpis, maximus ac sodales in, facilisis et nisi. Suspendisse efficitur metus at nisl egestas sollicitudin. Vestibulum quis lacus aliquet, tincidunt urna quis, tristique turpis.</p>
<div>
<?php require_once 'Application/Views/Snippets/SignUp.php';?>
<?php require_once 'Application/Views/Snippets/Login.php';?>