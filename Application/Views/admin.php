<script>
$( document ).ready(function() 
{
    $('.active').click(function() 
    {
        if($(this).css == 'green')
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
            echo "<tr style='color: black;'>";
                echo "<td>".$user['id']."</td>";
                echo "<td>".$user['firstname']."</td>";
                echo "<td>".$user['lastname']."</td>";
                echo "<td>".$user['email']."</td>";
                echo "<td>".$user['quota']."</td>";
                echo "<td>".$user['rank']."</td>";
                echo "<td>".$user['reg_date']."</td>";
                echo "<td>".$user['active']."</td>";
            echo "</tr>";
        }
    ?>
    </table> 
</div>