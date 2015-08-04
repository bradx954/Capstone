<script src='Web/JS/UserFieldsEditModule.js'></script>
<div id="UserFields" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Fields</h2>
    <div id="UserEditFieldsMessage"></div>
    <table style="color: black; width: 100%;">
        <tr>
            <td><b>Email:</b></td>
            <?php 
                if($GLOBALS['config']['usel']['email'][$_SESSION['auth']['accesslevel']]){echo "<td><a id='0' class='EmailUserField'>".$TPL['email']."</a></td></tr>";}
                else{echo "<td>".$TPL['email']."</td>";}
            ?>
        <tr>
            <td><b>First Name:</b></td>
            <?php 
                if($GLOBALS['config']['usel']['fname'][$_SESSION['auth']['accesslevel']]){echo "<td><a id='0' class='FirstNameUserField'>".$TPL['fname']."</a></td></tr>";}
                else{echo "<td>".$TPL['fname']."</td>";}
            ?>
        </tr>
        <tr>
            <td><b>Last Name:</b></td>
            <?php 
                if($GLOBALS['config']['usel']['lname'][$_SESSION['auth']['accesslevel']]){echo "<td><a id='0' class='LastNameUserField'>".$TPL['lname']."</a></td></tr>";}
                else{echo "<td>".$TPL['lname']."</td>";}
            ?>
        </tr>
    </table>
</div>