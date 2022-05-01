<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Image;

use App\Models\User;
use App\Models\UserProfileImage;
use App\Models\UserVerificationToken;
use App\Services\Image\ImageService;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class ImageServiceTest
 * @package Tests\Unit\Services\Image\ImageServiceTest
 * command:
 *   php artisan test tests/Unit/Services/Image/ImageServiceTest.php
 */
class ImageServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var User $user */
    private $user;

    /** @var ImageService $imageService */
    private $imageService;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');

        // テストはuserの画像として登録する
        $this->user = factory(User::class)->create();

        $this->imageService = new ImageService();
    }

    /**
     * @test
     */
    public function fileMakableインタフェースを実装しているクラスは、画像アップロードに成功する()
    {
        $dummyImage                = UploadedFile::fake()->image('dummy.jpeg');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $this->assertNotFalse($result);
        $this->assertNotEquals([], Storage::disk('s3')->allFiles());
    }

    /**
     * @test
     */
    public function fileMakableインタフェースを実装していないクラスは、画像アップロードに失敗する()
    {
        $this->expectException(Exception::class);

        $dummyImage                  = UploadedFile::fake()->image('dummy.jpeg');
        $ownerId                     = $this->user->id;
        $noImplementFileMakableClass = UserVerificationToken::class;

        $this->imageService->upload($dummyImage, $ownerId, $noImplementFileMakableClass);
    }

    /**
     * @test
     */
    public function jpg形式の画像アップロードに成功する()
    {
        $dummyImage                = UploadedFile::fake()->image('dummy.jpg');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $this->assertNotFalse($result);
        $this->assertNotEquals([], Storage::disk('s3')->allFiles());
    }

    /**
     * @test
     */
    public function jpeg形式の画像アップロードに成功する()
    {
        $dummyImage                = UploadedFile::fake()->image('dummy.jpeg');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $this->assertNotFalse($result);
        $this->assertNotEquals([], Storage::disk('s3')->allFiles());
    }

    /**
     * @test
     */
    public function png形式の画像アップロードに成功する()
    {
        $dummyImage                = UploadedFile::fake()->image('dummy.png');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $this->assertNotFalse($result);
        $this->assertNotEquals([], Storage::disk('s3')->allFiles());
    }

    /**
     * @test
     */
    public function fileMakableインタフェースを実装しているクラスは、画像ダウンロードに成功する()
    {
        $dummyImage                = UploadedFile::fake()->image('dummy.jpeg');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $fileName = pathinfo($result, PATHINFO_FILENAME);

        $this->imageService->download($fileName, $ownerId, $implementFileMakableClass);

        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function fileMakableインタフェースを実装していないクラスは、画像ダウンロードに失敗する()
    {
        $this->expectException(Exception::class);

        $dummyImage                = UploadedFile::fake()->image('dummy.jpeg');
        $ownerId                   = $this->user->id;
        $implementFileMakableClass = UserProfileImage::class;

        $result = $this->imageService->upload($dummyImage, $ownerId, $implementFileMakableClass);

        $fileName = pathinfo($result, PATHINFO_FILENAME);

        $noImplementFileMakableClass = UserVerificationToken::class;

        $this->imageService->download($fileName, $ownerId, $noImplementFileMakableClass);
    }
}
