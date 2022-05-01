# 開発環境セットアップ

[< 戻る](../README.md)

## ローカル開発環境の準備

### (1) リポジトリのチェックアウト

任意のディレクトリにgit cloneする。

```
(例)
$ git clone https://github.com/aidiot-inc/github-repo.git
```

### (2) Dockerの実行環境準備

Docker for Macは動作が重く、Vagrant上でDockerを動作させるようにする。<br>
セットアップは以下の解説を参照すること。

[Vagrant上でDockerを使用する](./SETUP/DOCKER_ON_VAGRANT.md)

### (3) 初期化

dockerでプロジェクトのコンテナを起動させた後、<br>
Vagrant内のプロジェクトのルートディレクトリでコマンドを実行する。

```
$ sh ./shell_scripts/init.sh
```

### Tips. 以下のエラーが出る場合

```
Plugin initialization failed (include(/var/www/src/vendor/composer/package-versions-deprecated/src/PackageVersions/Installer.php): Failed to open stream: No such file or directory), uninstalling plugin
  - Removing composer/package-versions-deprecated (1.11.99.2)
    Install of composer/package-versions-deprecated failed

                                                                               
  [ErrorException]                                                             
  include(/var/www/src/vendor/composer/package-versions-deprecated/src/Packag  
  eVersions/Installer.php): Failed to open stream: No such file or directory 
```

以下のコマンドを実行

```
docker exec -it php composer require composer/package-versions-deprecated --dev --prefer-source
```


### (4) /etc/hostsの編集

名前解決をしてアクセスするため、.envのAPP_URLを参考にして /etc/hosts に追加する。

```
(設定例)

[/etc/hosts]
...
127.0.0.1 gfc-satei-tool.local
```

### (5) 表示確認

ブラウザで「上記で設定したアドレス+解放しているポート番号」にアクセスできるか確認する。
```
(例) http://gfc-satei-tool.local:8080
```

## constantGenerate.jsの生成

`npm run dev` や `npm run prod` でビルドする前に、<br>
以下のコマンドで`app\Models`から`resources/js/common/configs/constantGenerate.js`にconstファイルをコピーしてください。

Run the following command to copy const from `app\Models` to `resources/js/common/configs/constantGenerate.js`.<br>
Run this command before build with `npm`

```
php artisan constant:generate
```

＊ `npm run watch` を実行している場合は再起動が必要です。


---

## .env関連

### SMTPサーバ

過去にバウンスメールによる送信停止の問題が出たこともあり、AWSのアイディオットのアカウントのSESはローカルの開発環境では使用しないようにする。<br>

手軽でオススメなのは[MailTrap](https://mailtrap.io/)や自分のGmailアカウントを利用する方法。<br>
アプリケーションで利用するためにはアプリパスワードを発行する必要がある。<br>
[アプリパスワード発行手順](https://www.howtonote.jp/google-account/2step-verify/index6.html)

```
(設定例)

[.env]
MAIL_DRIVER=smtp
MAIL_PORT=587
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=hogehoge@gmail.com
MAIL_PASSWORD=アプリパスワード
MAIL_FROM_ADDRESS=hogehoge@gmail.com
MAIL_ENCRYPTION=tls
```

---

## Xdebug, PhpStorm設定

### Xdebug

[Xdebugセットアップ方法](./XDEBUG.md)を参照。

### ESLint

#### Step1

`ESLint`で検索するか、<br>
PHPStorm<br>
→ Preferences<br>
→ Languages & Frameworks<br>
→ JavaScript<br>
→ Code Quality Tools<br>
→ ESLint
と移動して設定画面を開く。

#### Step2

1. `Automatic ESLint configuration` を選択する。
2. `Run eslint --fix on save` にチェックを入れる。

設定を保存する。
