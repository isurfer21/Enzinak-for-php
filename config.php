<?php
/**
 * @filename config.php
 * @author Abhishek Kumar
**/

$isRemote = false;

if($isRemote) {
	define('DB_HOST','192.168.1.100');
	define('DB_USER','admin');
	define('DB_PASS','abcd123');
	define('DB_SCHEMA','testdb');
} else {
	define('DB_HOST','127.0.0.1');
	define('DB_USER','root');
	define('DB_PASS','');
	define('DB_SCHEMA','attensity');
}

?>