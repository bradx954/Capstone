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
            $.post( "index.php?c=admin&m=updateUserQuota", { id: $(this).attr('id'), bytes: getBytes($('#'+$(this).attr('id')+'.inputBytes').val()) } );
            $('#'+$(this).attr('id')+'.quota').html(byteSplit[0]+' '+byteSplit[1]);
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
                echo "<td>".$user['firstname']."</td>";
                echo "<td>".$user['lastname']."</td>";
                echo "<td>".$user['email']."</td>";
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