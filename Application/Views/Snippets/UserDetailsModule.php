<script src='Web/JS/ByteStringFunctions.js'></script>
<script type="text/javascript" src="Web/JS/canvasjs.min.js"></script>
<script src='Web/JS/UserDetailsModule.js'></script>
<div id="UserDetails" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Details</h2>
    <table style="color: black; width: 100%;">
        <tr>
            <td><b>Rank:</b></td>
            <?php 
                echo "<td>".$TPL['rank']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Date Registered:</b></td>
            <?php 
                echo "<td>".$TPL['rdate']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Files:</b></td>
            <?php 
                echo "<td>".$TPL['files']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Folders:</b></td>
            <?php 
                echo "<td>".$TPL['folders']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Quota:</b></td>
            <?php 
                echo "<td id='UserDetailsQuota'>".$TPL['quota']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Used Space:</b></td>
            <?php 
                echo "<td id='UserDetailsUsedSpace'>".$TPL['usedspace']."</td>";
            ?>
        </tr>
        <tr>
            <td><b>Free Space:</b></td>
            <?php 
                echo "<td id='UserDetailsFreeSpace'>".$TPL['freespace']."</td>";
            ?>
        </tr>
    </table>
    <div id="UserDetailsChart" style="height: 300px; width: 100%;"></div>
</div>