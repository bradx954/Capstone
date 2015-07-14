<div class="table-responsive">
    <table class='table table-striped table-bordered table-hover' style="background-color:white;">
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
                    $user['active'] = '<a id=active-'.$user['id'].' style="color:red;">False</p>';
                break;
                case 1:
                    $user['active'] = '<a id=active'.$user['id'].' style="color:green;">True</p>';;
                break;
                default:
                    $user['active'] = '<a id=active'.$user['id'].' style="color:red;">False</p>';
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