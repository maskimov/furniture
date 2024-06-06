<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

class Image
{
	public function saveImage($path, $file)
	{		
		$photo = rand(1000000, 9999999).'.jpg';
		$temp_photo = $file['tmp_name'];
		$folder = $path.$photo;
		if (!move_uploaded_file($temp_photo, $folder)) {
			$folder = NULL;
		}

		return $folder;
	}

	public function deleteImage($file){
    	if (file_exists($file)){
        	unlink($file);
    	}
	}
}