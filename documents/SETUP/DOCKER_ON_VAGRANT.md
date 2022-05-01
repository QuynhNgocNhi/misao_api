# Vagrant上でDockerを使用する

## ソフトのインストール

以下のリンクからVirtualBoxとVagrantをダウンロードしてインストールする。

[VirtualBox](https://www.virtualbox.org/wiki/Downloads)

[Vagrant](https://www.vagrantup.com/downloads.html)

## Vagrantの設定

任意の場所にVagrant用のディレクトリを作成し、以下のコマンドを実行する。
```
$ vagrant init
```

Vagrantfileが生成されるので、テキストエディタなどで開いて、<br>
`Vagrant.configure("2") do |config|` の行の下に設定を追加する。

* Syncするディレクトリは自分のローカル環境に合わせて書き換えること。<br>
(`/local/your_workspace/directory`の部分)
* portはDockerで動作させるコンテナの解放ポートに合わせて設定する必要がある。<br>
(docker-compose.ymlを参照のこと)

```
Vagrant.configure("2") do |config|
  # Sync Directory
  config.vm.synced_folder "/local/your_workspace/directory", "/home/vagrant/workspace", create:"true", mount_options: ['dmode=777','fmode=777']
  config.vm.provision "docker"

  # portマッピング
  config.vm.network "forwarded_port", guest: 8080, host: 8080
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # ssh-agent起動
  config.vm.provision "shell", run: "always", inline: <<-SHELL
    echo 'eval `ssh-agent`' > /home/vagrant/.bash_profile
  SHELL

  config.vm.box = "bento/ubuntu-19.04"
```

追加を終えたら以下のコマンドを実行する。
```
$ vagrant provision
```

## Vagrant, Dockerを起動

Vagrantを起動して入る。
```
$ vagrant up
$ vagrant ssh
```

docker-composeのインストール(初回のみ)
```
$ sudo apt install docker-compose
```

docker-compose.ymlがあるディレクトリへ移動し、docker-compose upする。<br>
(`your_project`の部分は自分の環境に合わせて書き換える)

プロジェクトでXdebugを使用している場合、remote_enableをonにしないと繋がらないので、この時点で設定しておく。<br>
(`REMOTE_ENABLE` `remote_enable`などでプロジェクトのファイルを検索すると設定箇所が出てくる)

```
$ cd workspace/project_dir/docker
$ docker-compose up -d
```

起動後、ブラウザアクセスするなどして動作を確認する。

## Vagrant, Dockerを終了

Vagrant上
```
$ cd workspace/project_dir/docker
$ docker-compose down
$ exit
```

ホストマシン上
```
$ vagrant halt
```
