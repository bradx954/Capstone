<script src='Web/JS/notify.min.js'></script>
<script src='Web/JS/UsersTable.js'></script>
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
            echo "<tr id='".$user['id']."' style='color: black;'>\n";
            if($GLOBALS['config']['uel'][$user['rank']][$_SESSION['auth']['accesslevel']]){
                echo "<td>".$user['id']."</td>";
                echo "<td><a href='#' class='firstName' id=".$user['id']." style='color:blue;'>".$user['firstname']."</a></td>";
                echo "<td><a href='#' class='lastName' id=".$user['id']." style='color:blue;'>".$user['lastname']."</a></td>";
                echo "<td><a href='#' class='email' id=".$user['id']." style='color:blue;'>".$user['email']."</a></td>";
                echo "<td><a href='#' class='quota' id=".$user['id']." style='color:blue;'></a></td>";
                echo "<td><select id='".$user['id']."' name='rank' class='form-control rank' style='width: 100px;'><option>user</option><option>admin</option><option>superadmin</option></select></td>";
                echo "<td>".$user['reg_date']."</td>";
                echo "<td>".$user['active']."</td>";
                echo "<td style='width: 26px;'><a class='delete' id=".$user['id']." href='#'><img src='Web/Images/Delete-Icon.png'/></a></td>";
                echo "</tr>\n";
                echo "<script>
                    $('#".$user['id'].".quota').html(getByteString(".$user['quota']."));
                    $('#".$user['id'].".rank').val('".$user['rank']."');
                </script>\n";
           }
           else {
                echo "<td id=".$user['id'].">".$user['id']."</td>";
                echo "<td id=".$user['id'].">".$user['firstname']."</td>";
                echo "<td id=".$user['id'].">".$user['lastname']."</td>";
                echo "<td id=".$user['id'].">".$user['email']."</td>";
                echo "<td id=".$user['id']." class='quota-off'>".$user['quota']."</td>";
                echo "<td id=".$user['id'].">".$user['rank']."</td>";
                echo "<td id=".$user['id'].">".$user['reg_date']."</td>";
                echo "<td id=".$user['id'].">".$user['active']."</td>";
                echo "</tr>\n";
                echo "<script>
                    $('#".$user['id'].".quota-off').html(getByteString(".$user['quota']."));
                </script>\n";
            }
        }
    ?>
    </table> 
</div>