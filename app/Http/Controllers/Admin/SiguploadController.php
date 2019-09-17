<?php

namespace App\Http\Controllers\Admin;

use App\Services\Storage\Oss\StorageService;
use App\Services\Storage\Oss\UrlService;
use Illuminate\Http\Request;

class SiguploadController extends AdminController
{
    public function upload(Request $request, StorageService $storageService)
    {
    	$file = $request->file('file');
    	if ($file->isValid()) {
            $filePath = $storageService->uploadFile($file, 'temp');
            if ($filePath) {
                $options = [];
                if ($request->pSize) {
                    list($width, $height) = explode('*', $request->pSize);
                    $options = [
                        'width' => $width,
                        'height'=> $height,
                    ];

                    if ($request->handleType) {
                        if ($request->handleType == 1) {
                            $options['resize_type'] = UrlService::RESIZE_TYPE_LFIT;
                        } elseif ($request->handleType == 2) {
                            $options['resize_type'] = UrlService::RESIZE_TYPE_FIXED;
                        } elseif ($request->handleType == 3) {
                            $options['resize_type'] = UrlService::RESIZE_TYPE_FILL;
                        }
                    }
                }

                return $this->handleSuccess([
                    'filePath' => $filePath,
                    'fileUrl' => UrlService::getUrl($filePath, $options)
                ]);
            }
    	}
        return $this->handleFail();
    }
}
