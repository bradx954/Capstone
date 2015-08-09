<script src='Web/JS/ServerDatabaseModule.js'></script>
<div id="ServerDatabase" class="module-container" style="width: 300px;">
    <h2 style="text-align: center; margin: 0px;">Database</h2>
    <table class="table" style="color: black; width: 100%;">
        <tr>
            <td><b>Users:</b></td>
            <td><?php echo $TPL['users'];?></td>
            <td><button class="btn btn-primary" id="ServerDatabaseResetUsers" style="width: 100%">Reset</button></td>
        </tr>
        <tr>
            <td><b>Avatars:</b></td>
            <td><?php echo $TPL['avatars'];?></td>
            <td><button class="btn btn-primary" id="ServerDatabaseResetAvatars" style="width: 100%">Reset</button></td>
        </tr>
        <tr>
            <td><b>Files:</b></td>
            <td><?php echo $TPL['files'];?></td>
            <td><button class="btn btn-primary" id="ServerDatabaseResetFiles" style="width: 100%">Reset</button></td>
        </tr>
        <tr>
            <td><b>Folders:</b></td>
            <td><?php echo $TPL['folders'];?></td>
            <td><button class="btn btn-primary" id="ServerDatabaseResetFolders" style="width: 100%">Reset</button></td>
        </tr>
    </table>
    <button class="btn btn-primary" id="ServerDatabaseReset" style="width: 100%">Total Reset</button>
</div>