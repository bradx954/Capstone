<script src='Web/JS/UserFieldsEditModule.js'></script>
<div id="UserFields" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Fields</h2>
    <div id="UserEditFieldsMessage"></div>
    <table style="color: black; width: 100%;">
        <tr>
            <td><b>Email:</b></td>
            <td><a id="0" class="EmailUserField"><?php echo $TPL['email'];?></a></td>
        </tr>
        <tr>
            <td><b>First Name:</b></td>
            <td><?php echo $TPL['fname'];?></td>
        </tr>
        <tr>
            <td><b>Last Name:</b></td>
            <td><?php echo $TPL['lname'];?></td>
        </tr>
    </table>
</div>