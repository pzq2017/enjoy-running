<?php


namespace App\Http\Controllers\Api;

use App\Services\Storage\Oss\StorageService;
use App\Services\Storage\Oss\UrlService;
use Illuminate\Http\Request;

class FileController extends BaseController
{
    private $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function UploadMedia(Request $request)
    {
        $file = $request->file('file');         //图片
        $width = $request->get('width');        //图片显示的宽度
        $height = $request->get('height');      //图片显示的高度

        $filePath = $this->storageService->uploadFile($file, 'temp');
        if ($filePath) {
            $options = [];
            if ($width) {
                $options['width'] = $width;
            }
            if ($height) {
                $options['height'] = $height;
            }
            return $this->responseSuccessWithData([
                'fileUrl' => UrlService::getUrl($filePath, $options)
            ]);
        }

        return $this->responseErrorWithMessage('图片上传失败！');
    }
}
