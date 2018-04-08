<?php
// DB Connections
$config['DBHost'] = "46.32.240.33";
$config['DBName'] = "jack--fyo-u-175877";
$config['DBUser'] = "jack--fyo-u-175877";
$config['DBPass'] = "D2Jghh6y.";

if (mysql_connect($config['DBHost'], $config['DBUser'], $config['DBPass'])) {
    $Connect = "TRUE";
}
mysql_select_db($config['DBName']);
mysql_set_charset('utf8');