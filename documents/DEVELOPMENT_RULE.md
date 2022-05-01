# 開発ルール

[< 戻る](../README.md)

## コミットルール

[こちら](https://github.com/aidiot-org/development-guide/blob/main/documents/GIT_RULES.md) を参照のこと。

## Migration

### ファイル名のつけ方

#### 新しいテーブルを作成する

ファイル名を "create_テーブル名_table" とする。

```shell script
(例) samplesテーブルの新規作成時のmigrationファイルを作成する
$ php artisan make:migration create_samples_table --table=samples
```

#### テーブルを更新する

ファイル名を "処理内容_テーブル名_table" とする。

```shell script
(例1) samplesテーブルにfooカラムを追加する
$ php artisan make:migration add_column_foo_to_samples_table --table=samples

(例2) samplesテーブルからfooカラム,barカラムを削除する
$ php artisan make:migration drop_columns_foo_and_bar_from_samples_table --table=samples
```
