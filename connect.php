<?php
define('host','localhost');
define('dbusername','root');
define('dbpassword','');
define('dbname','blogdata');

$link=mysqli_connect(host,dbusername,dbpassword,dbname);
if($link==false)
{
    die("database connection error.".mysqli_connect_error());
}

?>