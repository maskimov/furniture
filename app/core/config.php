<?php 

defined('ROOTPATH') OR exit('Access Denied!');

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
	define('DBNAME', 'furniture');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/furniture/public');

}else
{
	/** database config **/
	define('DBNAME', 'furniture');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');

}

define('MAIL_HOST','smtp.gmail.com');
define('MAIL_USERNAME','kozyriev.developer@gmail.com');
define('MAIL_PASSWORD','vtly ibtt ulog wigk');
define('MAIL_SEND_FROM','kozyriev.developer@gmail.com');
define('MAIL_SEND_FROM_NAME','Furniture Factory');
define('MAIL_REPLY_TO','kozyriev.developer@gmail.com');
define('MAIL_REPLY_TO_NAME','Maksim Kozyriev');
define('MAIL_PORT',587);

define('APP_NAME', "Фабрика Меблів");
define('APP_DESC', "Вебсайт для управління Фабрикою Меблів, ведення документації та звітів");

/** true means show errors **/
define('DEBUG', false);
