<?php
// DB Connections
$config['DBHost'] = "";
$config['DBName'] = "";
$config['DBUser'] = "";
$config['DBPass'] = "";

if (mysql_connect($config['DBHost'], $config['DBUser'], $config['DBPass'])) {
    $Connect = "TRUE";
}
mysql_select_db($config['DBName']);
mysql_set_charset('utf8');
