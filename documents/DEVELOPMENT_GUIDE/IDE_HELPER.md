# ide helperの利用手順

[< 戻る](../DEVELOPMENT_DOC.md)

## 事前準備

`composer install`を実行しておいてください。

## 使用例

phpコンテナの中で以下を実行

※基本的にmodelのPHPdocはモデルのクラスファイルに記載してください

```shell
php artisan ide-helper:generate
php artisan ide-helper:models -W
php artisan ide-helper:meta
```

より詳細な使用方法は以下を参考にしてください。

https://github.com/barryvdh/laravel-ide-helper

## Tips

`composer install`に失敗した場合は以下の記事を参考に`unzip`の完了を遅らせるスクリプトを追加する。

https://qiita.com/yasuaki640/items/efaf3ea15d3b1b06f587