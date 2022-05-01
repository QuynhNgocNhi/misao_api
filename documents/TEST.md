# テスト

[< 戻る](../README.md)

## 準備

1. MySQLに`test`テーブルがなければ作成する <br>
([開発環境セットアップ](./documents/SETUP.md)の初期化に際に作成されている)

```MySQL
mysql> CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

2. .env.testingにDBの接続情報など必要な環境変数を設定する

## テストファイルのディレクトリ

- `tests/Feature` : API(Controller)に対しての結合テスト。
- `tests/Unit` : ModelやService,ValidationRuleに対しての単体テスト。

## 実行方法

```
# 全てのテストを実行
$ docker-compose exec php php artisan test

# ファイル
$ docker-compose exec php php artisan test tests/Feature/SampleTest.php
```
