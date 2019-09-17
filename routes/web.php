<?php

Route::get('file/{path}', function ($path) {
	\App\Http\Util\FileRoute::showfile($path);
})->where('path', '[a-zA-Z0-9_/.]+');