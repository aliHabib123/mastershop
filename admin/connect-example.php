<?php
$db_conn=mysqli_connect('127.0.0.1', 'root', '');
mysqli_select_db($db_conn, 'saad-holding');
$_SESSION['db_conn'] = $db_conn;
