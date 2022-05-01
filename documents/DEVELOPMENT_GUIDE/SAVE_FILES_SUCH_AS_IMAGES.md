# 画像等のファイルの保存手順

[< 戻る](../DEVELOPMENT_GUIDE.md)

## モデルに紐づくファイルの保存先のテーブルを用意したい場合

例：`users`に紐づく画像ファイルの保存先を用意したい

- (1) migrationファイルを用意する<br>
  参考: `2020_04_23_110919_create_user_profile_images_table.php`
- (2) FileMakableインターフェイスを実装してモデルを作成する。<br>
  参考: `app/Models/UserProfileImage.php`
- (3) `app/Services/Image/ImageService.php`を利用して、追加したテーブルとモデルを元に、ファイルのアップロード、ダウンロードを行うことができる。
  参考: `tests/Unit/Service/Image/ImageServiceTest.php`

## どのモデルにも紐づかないファイルの場合



