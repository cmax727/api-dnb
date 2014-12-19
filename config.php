<?php
/* 
We use this database to test the client projects
so please make sure when you are worrking on any project you make a config.php file which 
must include the databse settings and baseUrl vaiable, and any other variables.
The idea is that we should not facebook problems while transfering the app

mySql tables should always start with some prefix like projectname_tablename
myphp admin: https://p3nlmysqladm001.secureserver.net/grid50/419/index.php?uniqueDnsEntry=henozclients.db.6684030.hostedresource.com

*/



$host = "henozclients.db.6684030.hostedresource.com";
$dbUser = "henozclients";
$dbPass = "clients9@Henoz";
$dbName = "henozclients";
$baseUrl = "http://root.local";
$paging=10;


$host = "localhost";
$dbUser = "root";
$dbPass = "root";
$dbName = "dnb_api";
$baseUrl = "http://me.local/api-dnb";
$paging=10;

?>
