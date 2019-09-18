<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/12
 * Time: 12:26
 */

namespace App\Services\Storage\Oss;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorageService
{
    private $oss;

    const PIECE_SIZE = 500 * 1024 * 1024;     //每次分片上传的文件大小为500M
    const LOG_TAG = '[storage:oss]: ';

    public function __construct()
    {
        $this->oss = new AliOss();
        $this->oss->setBucket(config('oss.bucket'));
    }

    public function uploadFile(UploadedFile $file, $filePath = '')
    {
        $pathImg = empty($filePath) ? 'images/'.Carbon::now()->format('Y/m/d') : $filePath;
        $newFilename = md5($file->getClientOriginalName().time().rand(1, 10000)).'.'.$file->getClientOriginalExtension();
        $object = $pathImg.'/'.$newFilename;

        $result = $this->oss->upload($object, $file->getPathname());
        if ($result && !empty($result['etag'])) {
            return $object;
        }

        return null;
    }

    public function exists($source)
    {
        $source = $this->parseSourcePath($source);
        return $this->oss->doesObjectExist($source['object'], $source['bucket']);
    }

    public function delete($source)
    {
        $data = $this->parseSourcePath($source);
        if ($this->exists($source)) {
            $delete_result = $this->oss->deleteObject($data['object'], $data['bucket']);
            if ($delete_result) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function move($fromSource, $toSource)
    {
        $fromSourceArr = $this->parseSourcePath($fromSource);
        $toObject = $this->getTargetObject($fromSourceArr['object'], $toSource);
        $copy_result = $this->oss->copyObject($fromSourceArr['object'], $toObject, $fromSourceArr['bucket']);
        if ($copy_result) {
            $this->delete($fromSource);
            return $toObject;
        } else {
            return null;
        }
    }

    /**
     * @param $source
     *
     * @return array
     */
    private function parseSourcePath($source)
    {
        $source = urldecode($source);
        $bucket = $this->oss->getBucket();
        if (preg_match("/^(http:\/\/|https:\/\/).*$/", $source)) {
            $urlArr = explode('/', $source);
            $strArr = explode('.', $urlArr[2]);
            $bucket = $strArr[0];
            $object = '';
            for ($i = 3; $i < count($urlArr); ++$i) {
                $object .= '/'.$urlArr[$i];
            }
            $object = ltrim($object, '/');
            if (false !== strpos($object, '?')) {
                $pathArr = explode('?', $object);
                $object = $pathArr[0];
            }
        } else {
            $object = $source;
        }
        Log::info(self::LOG_TAG.'bucket => '.$bucket.';object=>'.$object);
        return [
            'bucket' => $bucket,
            'object' => $object,
        ];
    }

    /**
     * @param $fromObject
     * @param $toSource
     *
     * @return string
     */
    private function getTargetObject($fromObject, $toSource)
    {
        if (isset($toSource['target_dir'])) {
            $pathArr = explode('/', $fromObject);
            $toObject = $toSource['target_dir'].'/'.$pathArr[count($pathArr) - 1];
        } elseif (isset($toSource['target_path'])) {
            $toObject = $toSource['target_path'];
        } else {
            $toObject = $toSource;
        }
        return $toObject;
    }
}