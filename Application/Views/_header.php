<html>
    <!-- I Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.-->
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link href="Web/CSS/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="Web/CSS/theme.css">
        <link rel="shortcut icon" href="Web/Images/LogoIcon.ico" />
        <script src='Web/JS/jquery-1.11.3.min.js'></script>
        <script src='Web/JS/bootstrap.min.js'></script>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-71040357-1', 'auto');
            ga('send', 'pageview');

        </script>
        <title>Storacloud</title>
    </head>
    <body style='padding-top: 50px;'>
<?php
if (isset($_SESSION['auth']['email'])) {
    require_once 'Application/Views/Snippets/NavBar.php';
}
?>