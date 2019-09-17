<?php

namespace App\Http\Util;

use Intervention\Image\Facades\Image;

class FileRoute
{
	public static function showfile($path)
	{
		$real_path = \Storage::path('').$path;
		if (file_exists($real_path)) {
			$mime = Image::make($real_path)->mime();
			header('Content-type:'.$mime);
			echo file_get_contents($real_path);
		} else {
			header('HTTP/1.1 404 Not Found');
		}
		exit;
	}
}