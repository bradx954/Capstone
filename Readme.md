Storacloud software application v1.01
Author: Brad Baago email: brad.baago@linux.com

This software was developed for Mohawk college's capstone project and is subject to their licensing.

Images included have their sources listed in Web/Images/ImageSources.txt.

Server Requirements:

PHP 5.6.16 or higher
MySQL Database.

Installation Instructions:

1. Move files to web directory.
2. Run Scripts/installDB.sql to setup database.(It is important to rename the username, password, and database if you choose on the script and in the Config/dBase.php file)
3. Go to site and create a account.
4. Change your accounts rank to superadmin in mysql.
5. Additional configuration available in the other config file in Config/.

Framework based on supplied code from lab 6 in mohawk college's advanced php course. Web/main.php and Application/models/userauth.php contain a lot of non original content.

Some plugins used:
JQuery: https://jquery.com/
Bootstrap: http://getbootstrap.com/
Simple Side Bar: http://startbootstrap.com/template-overviews/simple-sidebar/
Code Mirror: https://codemirror.net/
JQuery ContextMenu: https://github.com/swisnl/jQuery-contextMenu
double tap : https://gist.github.com/attenzione/7098476
notifaction pop ups: http://bootstrap-notify.remabledesigns.com/
table sorter: http://tablesorter.com/docs/
table filterer: https://sunnywalker.github.io/jQuery.FilterTable/
charts: http://canvasjs.com/
boot box: http://bootboxjs.com/