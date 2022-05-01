<?php

declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface FileMakable
 * @package App\Models\Interfaces
 */
interface FileMakable
{
    /**
     * @param string $originalFileName
     * @param string $content
     * @param int    $ownerId
     * @param string $pathName
     * @return FileMakable
     */
    public static function fromFileName(
        string $originalFileName,
        string $content,
        int $ownerId,
        string $pathName
    ): FileMakable;
}
