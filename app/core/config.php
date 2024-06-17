<?php 

defined('ROOTPATH') OR exit('Access Denied!');

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
	define('DBNAME', 'XXXXX');
	define('DBHOST', 'XXXXX');
	define('DBUSER', 'XXXXX');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/furniture/public');

}else
{
	/** database config **/
	define('DBNAME', 'XXXXX');
	define('DBHOST', 'XXXXX');
	define('DBUSER', 'XXXXX');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');

}

define('MAIL_HOST','XXXXX');
define('MAIL_USERNAME','XXXXX');
define('MAIL_PASSWORD','XXXXX');
define('MAIL_SEND_FROM','XXXXX');
define('MAIL_SEND_FROM_NAME','XXXXX');
define('MAIL_REPLY_TO','XXXXX');
define('MAIL_REPLY_TO_NAME','XXXXX');
define('MAIL_PORT',XXXXX);

define('APP_NAME', "Фабрика Меблів");
define('APP_DESC', "Вебсайт для управління Фабрикою Меблів, ведення документації та звітів");

/** true means show errors **/
define('DEBUG', false);
