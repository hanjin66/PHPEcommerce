<?php
$db=mysqli_connect('127.0.0.1','root','','tutorial');
if(mysqli_connect_errno()){
echo 'Database conenction failed with following erro: '. mysql_connect_error();
die();
}

define('BASEURL','/tutorial/');

?>





