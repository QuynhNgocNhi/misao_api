# Makefileを利用したショートカットコマンドの作成

[< 戻る](../DEVELOPMENT_DOC.md)

## 利用コンポーネント

`docker/Makefile`

## 事前準備

dockerのホストとなるvagrant上でmakeコマンドが実行できるようにする。
※デフォルトで入っていると思います。

## 使用例

1. すでに定義されているコマンドを元に`make hoge`のようなコマンドで実行したいコマンドを追記する。
2. `vagrant ssh`でvagrantにログインし、`app/docker`で`make hoge`を実行する。

## Tips

