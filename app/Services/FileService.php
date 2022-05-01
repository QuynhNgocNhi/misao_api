<?php

namespace App\Services;

use App\Traits\FileUpload;
use Illuminate\Support\Facades\Storage;

class FileService {
    const TEMP_FOLDER = 'uploads/temp/';

    protected $driver;

    public function __construct($driver = null)
    {
        $this->setDriver($driver);
    }

    private function setDriver($driver)
    {
        $this->driver = empty($driver) ? config('filesystems.default') : $driver;
    }

    public function uploadTempFile($file): array
    {
        return $this->uploadFile($file, self::TEMP_FOLDER, true);
    }

    public function moveTempFile($fileName, $folder)
    {
        $newName = str_replace(self::TEMP_FOLDER, $folder, $fileName);
        switch ($this->driver) {
            case 'local':
                if (!Storage::disk('local_public')->move($fileName, $newName)) {
                    throw new \Exception('move file error');
                }
                return '/' . ltrim($newName, '/');
            case 's3':
                if (!Storage::disk('s3')->move($fileName, $newName)) {
                    throw new \Exception('move file error');
                }
                return $newName;
            default:
                throw new \Exception('upload file error');
        }
    }

    public function uploadFile($file, string $folder = '', bool $includeTime = true): array
    {
        // switch ($this->driver) {
        //     case 'local':
                return $this->uploadFileToLocal($file, $folder);
            // case 's3':
            //     return $this->uploadFileToS3($file, $folder);
            // default:
            //     throw new \Exception('upload file error');
        // }
    }

    public function exist(string $fileName)
    {
        switch ($this->driver) {
            case 'local':
                return Storage::disk('local_public')->exists($fileName);
            case 's3':
                return Storage::disk('s3')->exists($fileName);
            default:
                return false;
        }
    }

    public function delete(string $fileName)
    {
        switch ($this->driver) {
            case 'local':
                return Storage::disk('local_public')->delete($fileName);
            case 's3':
                return Storage::disk('s3')->delete($fileName);
            default:
                return false;
        }
    }

    public function uploadFileToS3($file, string $folder = '', bool $includeTime = true): array
    {
        [$folder, $fileName] = $this->getFilename($file, $folder, $includeTime);
        $path = Storage::disk('s3')->put($folder . $fileName, $file);
        $result = [
            'path' => $path,
            'url'  => Storage::disk('s3')->url($path),
        ];
        return $result;
    }

    public function uploadFileToLocal($file, string $folder = '', bool $includeTime = true): array
    {
        [$folder, $fileName] = $this->getFilename($file, $folder, $includeTime);

        $file->move(public_path($folder), $fileName);

        return [
            'path' => $folder . $fileName,
            // 'url' => url($folder) . '/' . $fileName,
            'url' => url($folder) . '/' . $fileName,
        ];
    }

    protected function getFilename($file, string $folder = '', bool $includeTime = true)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileName = \Illuminate\Support\Str::slug(pathinfo($fileNameOrigin, PATHINFO_FILENAME)) . '.' . pathinfo($fileNameOrigin, PATHINFO_EXTENSION);

        // prevent file name long
        $length = strlen($fileName);
        if ($length >= 200) {
            $fileName = substr($fileName, $length - 200);
        }

        if ($includeTime) {
            $fileName = time() . '_' . $fileName;
        }
        $folder = rtrim($folder, '/') . '/';

        return [$folder, $fileName];
    }
}
