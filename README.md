<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 作業手順
## 1. インストール作業
### 1-1. Virtualboxインストール  
### 1-2. Vagrantインストール  
 
## 2. インストール後の作業
### 2-1. 仮想マシンを立ち上げる 
### 2-2. 仮想マシンにログインする
### 2-3. .envファイルの編集 
### 2-4. アプリケーションを仮想マシンへ送る  
### 2-5. example-appのユーザーをwww-dataに変更  
### 2-6. Composer install を実行
### 2-7. nginxの設定を仮想マシンに追加  
### 2-8. 設定ファイルのシンボリックリンクの作成  
### 2-9. デフォルトのシンボリックリンクの削除  
### 2-10. mysqlにユーザーを追加  
### 2-11. ホストOS側からブラウザでアプリケーションを表示  
※ Mailhogのインストールができていないため、会員登録を行うとエラー画面になる。

## 1. インストール作業
### 1-1. Virtualboxインストール
[VirtualBox公式](https://www.virtualbox.org/)にアクセスし、Downloadのリンクを辿ると [Download Virtual](https://www.virtualbox.org/wiki/Downloads)ページへ移動します。

自分が使うOSに適したVirtualBoxをインストールしてください。

### 1-2. Vagrantインストール
[Vagrant公式](https://developer.hashicorp.com/vagrant)にアクセスし、installのリンクをたどると、どのOS版のVagrantをインストールするかを選択するページへ移動します。

自分が使うOSに適したVagrantをインストールしてください。([Install Vagrant](https://developer.hashicorp.com/vagrant/downloads))  

## 2. インストール後の作業
### ２-1. 仮想マシンを立ち上げる(Vagrantfileを使う)
インストール作業が終わったら仮想マシンの立ち上げを行っていきます。

まずはコマンドプロンプト(Windows)やターミナル(MacOS)を開き、仮想マシンを立ち上げたいディレクトリへ移動（もしくはディレクトリを作成）します。  
次に、プロジェクトのルートディレクトリにあるVagrantfileの内容をコピーし、先ほど作成したディレクトリ内にVagrantfileを作成します。

Vagrantfileが存在するディレクトリへ移動しておきましょう。

    cd "Path to the Directory"

次のコマンドを実行して仮想マシンを立ち上げてください。

    vagrant up

すると、Vagrantfileの内容に従って仮想マシン（ubuntu）が立ち上がります。  
仮想マシンが立ち上がっているかどうかは次のコマンドで確認します。

    vagrant status

「running」と表示されたら仮想マシンは立ち上がっているので、次の手順でssh接続をします。

### 2-2. 仮想マシンにログインする 
次のコマンドを実行すると仮想マシンにログインすることができます。

    vagrant ssh

コマンドプロンプトの「ユーザー名@ホスト名」が、「vagrant@ubuntu-jammy」になればログイン成功です。

### 2-3. アプリケーションを仮想マシンへ送る
自身が作業しやすい方法でアプリケーション(example-app)をnginxのドキュメントルート(var/www/html)へ配置してください。

例として、以下にVagrantの共有フォルダを用いて nginxのドキュメントルートへアプリケーションを配置する手順を示します。

まず、手順2-1で vagrant upコマンドを実行したディレクトリに example-appを配置します。  
これで仮想マシンの /vagrantディレクトリに example-appを配置することができます。

次にexample-appをnginxのドキュメントルートへ移動させます。
手順2-2で仮想マシンにログインしているので、以下のコマンドを実行してください。

    sudo mv /vagrant/example-app /var/www/html

### 2-4. example-appのユーザーをwww-dataに変更
nginxのドキュメントルートのユーザーが www:data なので、アプリケーションのユーザーも www:data に変更しておきます。
    sudo chown -R www-data:www-data /var/www/html/example-app

### 2-5. .envファイルの編集 
.env.exampleの19行目から25行目にデプロイ環境でのmysqlの設定をコメントアウトして記載しています。
そのコメントアウトを解除した後、11行目から17行目に書いている開発環境でのmysqlの設定をコメントアウトするか削除しておいてください。

また、本ドキュメントの通りに仮想マシンを立ち上げている場合は .env.exampleのファイル名を .envに名前を変更しておきましょう。

    sudo mv .env.example .env

自身で用意した仮想環境で作業を行う場合は、各仮想マシンの要件を満たす形で .envファイルを用意してください。内容については.env.exampleファイルを参照してください。

### 2-6. Composer install を実行
アプリケーションのルートディレクトリで次のコマンドを実行してライブラリをインストールします。

    sudo composer install

### 2-7. nginxの設定を仮想マシンに追加
次のコマンドでファイル名を example.comと指定してVimを開きます。

    sudo vi /etc/nginx/sites-available/example.com

エディターが立ち上がったら以下の内容を貼り付けてください。

#### /etc/nginx/sites-available/example.comの内容
    server {
        listen 80;
        listen [::]:80;
        server_name example.com;
        # root /srv/example.com/public;
        # root /var/www/html/;
        root /var/www/html/example-app/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";

        index index.php;

        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }

上の内容を貼り付けることができたら、次のコマンドでVimを閉じます。

    :wq


### 2-8. 設定ファイルのシンボリックリンクの作成
次のコマンドを実行して、先ほど作成したnginxの設定ファイルのシンボリックリンクを sites-enabledディレクトリへ作成します。

    sudo ln -s /etc/nginx/sites-available/example.com /etc/nginx/sites-enabled/

### 2-9. デフォルトのシンボリックリンクの削除
次のコマンドを実行して、 /etc/nginx/sites-enabled に元々存在しているシンボリックリンクを削除します。

    sudo rm /etc/nginx/sites-enabled/default

### 2-10. mysqlにユーザーを追加
まず、mysqlにsudoを使ってログインします。

    sudo mysql

次に、mysqlにログインした状態で以下のコマンドを実行し、testというユーザーを追加します。

    mysql> CREATE USER 'test'@'localhost' IDENTIFIED BY 'Password@0000';

先ほど作成したユーザー（test）でmysqlにアクセスできるかを確認します。

    mysql -u test -p

上のコマンドでmysqlにアクセスすることができたら。  
以下のコマンドを実行して、ユーザーtestにDBへのアクセス権限を与えてください。

    mysql> GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost';

### 2-11. データベースの作成
example-appのルートディレクトリで以下のコマンドを実行します。

    php artisan migrate

コマンドが走ると、「新しく example_appというデータベースを作成するか？」と聞かれる。  
yes と答えると、アプリケーションのデータベースが作成される。

最後に以下のコマンドを実行するとダミーのデータを挿入することができる。

    php artisan db:seed

### 2-11. ホストOS側からブラウザでアプリケーションを表示
ホストOSのブラウザで仮想マシンのIPアドレスを入力すればアプリケーションを確認することができる。  

    IPアドレス：192.168.56.56

最初に表示される画面のリンクを辿ると、Laravelの学習用に作成したアプリケーションにアクセスできる。