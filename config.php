<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id16750019_tpbmn321');
define('DB_PASSWORD', '~$LQlKPA6f&3c%WG');
define('DB_NAME', 'id16750019_freekyk');
 
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>