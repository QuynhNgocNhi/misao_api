<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

use Closure;

/**
 * キャッシュする前提のモデルが実装するべきインターフェイス
 *
 * Interface Cacheable
 * @package App\Models\Interfaces
 */
interface Cacheable
{
    /**
     * キャッシュクリアイベント
     *
     * @return Closure
     */
    static public function savedListener(): Closure;

    /**
     * すべてのキャッシュをクリアする
     */
    static public function clearCache(): void;

    /**
     * キャッシュされた全レコードを取得
     *
     * @return mixed
     */
    static public function getAllCached(): mixed;
}