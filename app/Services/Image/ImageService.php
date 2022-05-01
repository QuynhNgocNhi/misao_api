<?php

declare(strict_types=1);

namespace App\Services\Image;

use App\Models\Interfaces\FileMakable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageService
 * @package App\Services\Image
 */
class ImageService
{
    /**
     * 画像情報をDBに保存し、アップロードする
     *
     * @param UploadedFile $imageFile
     * @param int          $ownerId
     * @param string       $fileClass
     * @return string|null
     * @throws FileNotFoundException
     */
    public function upload(UploadedFile $imageFile, int $ownerId, string $fileClass): ?string
    {
        $fileName = $imageFile->getClientOriginalName();
        $content  = $imageFile->get();
        $pathName = $imageFile->getPathname();

        DB::beginTransaction();
        try {
            $image = $this->saveByString($fileClass, $fileName, $content, $ownerId, $pathName);
            $this->uploadToS3($image->file_path, $content);

            DB::commit();
            return $image->file_name;
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            DB::rollBack();
            return null;
        }
    }

    /**
     * ファイルネームとアップロードしたユーザーのIDから、画像を取得する
     *
     * @param string $fileName
     * @param int    $ownerId
     * @param string $fileClass
     * @return \SplFileInfo|null
     */
    public function download(string $fileName, int $ownerId, string $fileClass): ?\SplFileInfo
    {
        try {
            $file = $fileClass::query()
                ->where([
                    ['file_name', 'like', $fileName . '%'],
                    $fileClass::FOREIGN_ID => $ownerId,
                ])
                ->first();
            if (is_null($file)) {
                return null;
            }
            $binary = $this->getFromS3($file->file_path);

            return $this->createByBinary($binary);
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            return null;
        }
    }

    /**
     * DBに保存する
     *
     * @param string $fileClass
     * @param string $fileName
     * @param string $content
     * @param int    $ownerId
     * @param string $pathName
     * @return FileMakable
     */
    private function saveByString(
        string $fileClass,
        string $fileName,
        string $content,
        int $ownerId,
        string $pathName
    ): FileMakable {
        $file = $fileClass::fromFileName($fileName, $content, $ownerId, $pathName);

        if (!$file->save()) {
            throw new \RuntimeException('データベースへの保存に失敗しました');
        }

        return $file;
    }

    /**
     * S3に画像をアップロードする
     *
     * @param string $pathName
     * @param string $content
     */
    private function uploadToS3(string $pathName, string $content)
    {
        $isSaved = Storage::disk('s3')->put($pathName, $content, 'public');

        if (!$isSaved) {
            throw new \RuntimeException('S3への保存に失敗しました');
        }
    }

    /**
     * S3から画像を取得する
     *
     * @param string $pathName
     * @return string
     * @throws FileNotFoundException
     */
    private function getFromS3(string $pathName): string
    {
        $image = Storage::disk('s3')->get($pathName);
        if (is_null($image)) {
            throw new \RuntimeException('S3からの画像の取得に失敗しました');
        }

        return $image;
    }

    /**
     * SplFileInfoオブジェクトを作成する
     *
     * @param string $binary
     * @return \SplFileInfo
     */
    private function createByBinary(string $binary): \SplFileInfo
    {
        try {
            // 一時ファイル作成
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'mm-');
            // SplFileInfo オブジェクトを作成
            $tmpFileInfo = new \SplFileInfo($tmpFilePath);

            // 書き込み専用
            $writer = $tmpFileInfo->openFile('w');

            // SplFileInfoオブジェクトに書き出す
            $writer->fwrite($binary);

            // ファイルハンドルを閉じる
            $writer = null;

            return $tmpFileInfo;
        } catch (\Exception $e) {
            throw new \RuntimeException('SplFileInfoオブジェクトの作成に失敗しました');
        }
    }
}


