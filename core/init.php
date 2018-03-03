<?php
$db=mysqli_connect('127.0.0.1','root','','tutorial');
if(mysqli_connect_errno()){
echo 'Database conenction failed with following erro: '. mysql_connect_error();
die();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/config.php';
require_once BASEURL.'helpers/helpers.php';





