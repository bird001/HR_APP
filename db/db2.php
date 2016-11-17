<?php

	define('DB','HR_DEPT');
	define('USER','root');
	define('PWD','toor');

	$dbh = new PDO('mysql:host=localhost;dbname='.DB,USER,PWD);
         
         /*
        $dbh = mysql_connect("localhost", "root", "toor");
        if (!$dbh) {
            die("Error:" . mysql_error());
        }
        mysql_select_db("test_db", $dbh);
          * 
          */

?>