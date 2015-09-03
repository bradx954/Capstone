<script src='Web/JS/FilesSideBar.js'></script>
<link href='Web/startbootstrap-simple-sidebar-1.0.4/css/simple-sidebar.css' rel='stylesheet'>
<div id="wrapper">
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                <?php echo $_SESSION['auth']['email'];?>
            </a>
        </li>
        <li>
            <button class="btn btn-primary" id="New" style="width: 100%;">New</button>
        </li>
    </ul>
</div>