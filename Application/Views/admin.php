<script>
function getByteString(bytes)
{
    var divisible = true;
    var divided = 0;
    while(divisible)
    {
        if(bytes > 999)
        {
            bytes = bytes / 1000;
            divided++;
        }
        else{divisible = false;}
    }
    switch(divided)
    {
        case 0:
        return bytes+' B';
        break;
        case 1:
        return bytes+' KB';
        break;
        case 2:
        return bytes+' MB';
        break;
        case 3:
        return bytes+' GB';
        break;
        default:
        return bytes+' GB';
    }
}
function getBytes(byteString)
{
    var byteSplit = byteString.split(" ");
    switch(byteSplit[1])
    {
        case 'B': return byteSplit[0];
        case 'KB': return byteSplit[0]*1000;
        case 'MB': return byteSplit[0]*1000*1000;
        case 'GB': return byteSplit[0]*1000*1000*1000;
        default: return byteSplit[0];
    }
}
$( document ).ready(function() 
{
    $('.active').click(function() 
    {
        if($(this).html() == 'True')
        {
            $.post( "index.php?c=admin&m=deactivateUser", { id: $(this).attr('id') } );
            $(this).css('color', 'red');
            $(this).html("False");
        }
        else
        {
            $.post( "index.php?c=admin&m=activateUser", { id: $(this).attr('id') } );
            $(this).css('color', 'green');
            $(this).html("True");
        }
    });
    $('.quota').click(function() 
    {
        var byteSplit = $(this).html().split(' ');
        $(this).html('');
        $(this).after('<form name="updateQuota" class="quotaUpdate" id="'+$(this).attr('id')+'" method="post" action="index.php?c=admin&m=updateUserQuota"><input type="number" name="bytes" id="'+$(this).attr('id')+'" class="form-control inputBytes" style="width: 100px; display: inline;"><select name="byteString" id="'+$(this).attr('id')+'" class="form-control byteString" style="width: 75px; display: inline;"><option value="B">B</option><option value="KB">KB</option><option value="MB">MB</option><option value="GB">GB</option></select><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#'+$(this).attr('id')+'.inputBytes').val(byteSplit[0]);
        $('#'+$(this).attr('id')+'.byteString').val(byteSplit[1]);
        $('#'+$(this).attr('id')+'.quotaUpdate').submit(function (event){
            event.preventDefault();
            $.post( "index.php?c=admin&m=updateUserQuota", { id: $(this).attr('id'), bytes: getBytes($('#'+$(this).attr('id')+'.inputBytes').val()+' '+$('#'+$(this).attr('id')+'.byteString').val()) } );
            $('#'+$(this).attr('id')+'.quota').html($('#'+$(this).attr('id')+'.inputBytes').val()+' '+$('#'+$(this).attr('id')+'.byteString').val());
            $(this).remove();
        });
    });
    $('.email').click(function() 
    {
        var email = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateEmail" class="emailUpdate" id="'+$(this).attr('id')+'" method="post" action="index.php?c=admin&m=updateUserEmail"><input type="text" name="email" id="'+$(this).attr('id')+'" class="form-control inputEmail" style="width: 300px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#'+$(this).attr('id')+'.inputEmail').val(email);
        $('#'+$(this).attr('id')+'.emailUpdate').submit(function (event){
            event.preventDefault();
            $.post( "index.php?c=admin&m=updateUserEmail", { id: $(this).attr('id'), email: $('#'+$(this).attr('id')+'.inputEmail').val() } );
            $('#'+$(this).attr('id')+'.email').html($('#'+$(this).attr('id')+'.inputEmail').val());
            $(this).remove();
        });
    });
    $('.firstName').click(function() 
    {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateFirstName" class="firstNameUpdate" id="'+$(this).attr('id')+'" method="post" action="index.php?c=admin&m=updateUserFirstName"><input type="text" name="firstName" id="'+$(this).attr('id')+'" class="form-control inputFirstName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#'+$(this).attr('id')+'.inputFirstName').val(name);
        $('#'+$(this).attr('id')+'.firstNameUpdate').submit(function (event){
            event.preventDefault();
            $.post( "index.php?c=admin&m=updateUserFirstName", { id: $(this).attr('id'), firstName: $('#'+$(this).attr('id')+'.inputFirstName').val() } );
            $('#'+$(this).attr('id')+'.firstName').html($('#'+$(this).attr('id')+'.inputFirstName').val());
            $(this).remove();
        });
    });
    $('.lastName').click(function() 
    {
        var name = $(this).html();
        $(this).html('');
        $(this).after('<form name="updateLastName" class="lastNameUpdate" id="'+$(this).attr('id')+'" method="post" action="index.php?c=admin&m=updateUserLastName"><input type="text" name="lastName" id="'+$(this).attr('id')+'" class="form-control inputLastName" style="width: 150px; display: inline;"><button type="submit" class="btn btn-primary">Save</button></form>');
        $('#'+$(this).attr('id')+'.inputLastName').val(name);
        $('#'+$(this).attr('id')+'.lastNameUpdate').submit(function (event){
            event.preventDefault();
            $.post( "index.php?c=admin&m=updateUserLastName", { id: $(this).attr('id'), lastName: $('#'+$(this).attr('id')+'.inputLastName').val() } );
            $('#'+$(this).attr('id')+'.lastName').html($('#'+$(this).attr('id')+'.inputLastName').val());
            $(this).remove();
        });
    });
});
</script>
<div class="table-responsive">
    <table class='table table-bordered table-hover table-condensed' style="background-color:white;">
    <tr style="color: black;">
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Quota</th>
        <th>Rank</th>
        <th>Date Registered</th>
        <th>Enabled</th>
    </tr>
    <?php
        foreach($TPL['users'] as $user)
        {
            switch($user['active'])
            {
                case 0:
                    $user['active'] = '<a href="#" class="active" id='.$user['id'].' style="color:red;">False</a>';
                break;
                case 1:
                    $user['active'] = '<a href="#" class="active" id='.$user['id'].' style="color:green;">True</a>';;
                break;
                default:
                    $user['active'] = '<a href="#" class="active" id='.$user['id'].' style="color:red;">False?</a>';
            }
            echo "<tr style='color: black;'>\n";
                echo "<td>".$user['id']."</td>";
                echo "<td><a href='#' class='firstName' id=".$user['id']." style='color:blue;'>".$user['firstname']."</a></td>";
                echo "<td><a href='#' class='lastName' id=".$user['id']." style='color:blue;'>".$user['lastname']."</a></td>";
                echo "<td><a href='#' class='email' id=".$user['id']." style='color:blue;'>".$user['email']."</a></td>";
                echo "<td><a href='#' class='quota' id=".$user['id']." style='color:blue;'></a></td>";
                echo "<td>".$user['rank']."</td>";
                echo "<td>".$user['reg_date']."</td>";
                echo "<td>".$user['active']."</td>";
            echo "</tr>\n";
            echo "<script>$('#".$user['id'].".quota').html(getByteString(".$user['quota']."));</script>\n";
        }
    ?>
    </table> 
</div>