<?php 

defined('ROOTPATH') OR exit('Access Denied!');

/** check which php extensions are required **/
check_extensions();
function check_extensions()
{

	$required_extensions = [

		'gd',
		'mysqli',
		'pdo_mysql',
		'pdo_sqlite',
		'curl',
		'fileinfo',
		'intl',
		'exif',
		'mbstring',
	];

	$not_loaded = [];

	foreach ($required_extensions as $ext) {
		
		if(!extension_loaded($ext))
		{
			$not_loaded[] = $ext;
		}
	}

	if(!empty($not_loaded))
	{
		show("Please load the following extensions in your php.ini file: <br>".implode("<br>", $not_loaded));
		die;
	}
}

function user (string $key = '')
{
  $ses = new \Core\Session;
  $row = $ses->user();

  if (!empty($row->$key))
    return $row->$key;

  return'';
}

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . ROOT."/".$path);
	die;
}

/** load image. if not exist, load placeholder **/
function get_image(mixed $file = '',string $type = 'post'):string
{

	$file = $file ?? '';
	if(file_exists($file))
	{
		return ROOT . "/". $file;
	}

	if($type == 'user'){
		return ROOT."/assets/images/user.webp";
	}else{
		return ROOT."/assets/images/no_image.jpg";
	}

}

/** return URL variables **/
function URL($key):mixed
{
	$URL = $_GET['url'] ?? 'home';
	$URL = explode("/", trim($URL,"/"));
	
	switch ($key) {
		case 'page':
		case 0:
			return $URL[0] ?? null;
		case 'section':
		case 'slug':
		case 1:
			return $URL[1] ?? null;
		case 'action':
		case 2:
			return $URL[2] ?? null;
		case 'id':
		case 3:
			return $URL[3] ?? null;
		default:
			return null;
	}

}


/** displays input values after a page refresh **/
function old_checked(string $key, string $value, string $default = ""):string
{

  if(isset($_POST[$key]))
  {
    if($_POST[$key] == $value){
      return ' checked ';
    }
  }else{

    if($_SERVER['REQUEST_METHOD'] == "GET" && $default == $value)
    {
      return ' checked ';
    }
  }

  return '';
}


function old_value(string $key, mixed $default = "", string $mode = 'post'):mixed
{
  $POST = ($mode == 'post') ? $_POST : $_GET;
  if(isset($POST[$key]))
  {
    return $POST[$key];
  }

  return $default;
}

function old_select(string $key, mixed $value, mixed $default = "", string $mode = 'post'):mixed
{
  $POST = ($mode == 'post') ? $_POST : $_GET;
  if(isset($POST[$key]))
  {
    if($POST[$key] == $value)
    {
      return " selected ";
    }
  }else

  if($default == $value)
  {
    return " selected ";
  }

  return "";
}

/** returns a user readable date format **/
function get_date($date)
{
	return date("jS M, Y",strtotime($date));
}


