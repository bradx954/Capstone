<script src='Web/JS/UserDetailsModule.js'></script>
<div id="UserDetails" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Details</h2>
    <table style="color: black; width: 100%;">
        <tr>
            <td><b>Rank:</b></td>
            <?php 
                echo "<td>".$TPL['rank']."</td>";
            ?>
        <tr>
            <td><b>Date Registered:</b></td>
            <?php 
                echo "<td>".$TPL['rdate']."</td>";
            ?>
        </tr>
    </table>
</div>