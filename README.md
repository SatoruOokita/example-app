<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# example-appのセットアップ
## このアプリケーションについて
このアプリケーションはLaravelの学習過程で作成したものです。  
使用した参考書は「プロフェッショナルWebプログラミング Laravel9」です。

主な機能は、140文字以内のつぶやきを表示することです。

### 注意
※ Mailhogのインストールができていないため、会員登録を行うとエラー画面になります。  
※画像をアップロードしても正しく表示されない状態です。

## 1. インストール作業
### 1-1. Virtualboxインストール
[VirtualBox公式](https://www.virtualbox.org/)にアクセスし、Downloadのリンクを辿ると [Download Virtual](https://www.virtualbox.org/wiki/Downloads)ページへ移動します。

自分が使うOSに適したVirtualBoxをインストールしてください。

### 1-2. Vagrantインストール
[Vagrant公式](https://developer.hashicorp.com/vagrant)にアクセスし、installのリンクをたどると、どのOS版のVagrantをインストールするか選択するページへ移動します。

自分が使うOSに適したVagrantをインストールしてください。([Install Vagrant](https://developer.hashicorp.com/vagrant/downloads))  

## 2. 仮想マシンを立ち上げる(Vagrantfileを使う)
インストール作業が終わったら仮想マシンの立ち上げを行っていきます。  

### 2-1. example-appのルートディレクトリへ移動する
コマンドプロンプト(Windows)やターミナル(MacOS)を開き、Vagrantfileが存在するディレクトリへ移動しておきましょう。  

    cd "Path to the Directory"

移動ができたら次のコマンドを実行して仮想マシンを立ち上げてください。

### 2-2. 仮想マシンを立ち上げる
次のコマンドを実行します。

    vagrant up

すると、Vagrantfileの内容に従って仮想マシン（ubuntu）が立ち上がります。  
仮想マシンが立ち上がっているかどうかは次のコマンドで確認します。

    vagrant status

「running」と表示されたら仮想マシンは立ち上がっているので、次の手順でssh接続をします。

## 3. 仮想マシンにログインする 
次のコマンドを実行すると仮想マシンにログインすることができます。

    vagrant ssh

コマンドプロンプトの「ユーザー名@ホスト名」が、「vagrant@ubuntu-jammy」になればログイン成功です。

## 4. nginxの設定を仮想マシンに追加  
/etc/nginx/sites-available ディレクトリに、example.comというファイルを作成し、以下の設定内容を貼り付けてください。  
テキストエディターは各々好みのものを使ってください。  

※Vimを用いた作業手順の例を example.comの内容の後に記しておきます。

### /etc/nginx/sites-available/example.comの内容
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

### Vimを使った作業の例
次のコマンドを実行して example.comというファイルを作成します。

    sudo vi /etc/nginx/sites-available/example.com

エディターが立ち上がったら上記の「/etc/nginx/sites-available/example.comの内容」を丸ごと貼り付けます。
貼り付けることができたら、次の命令をVimに出して変更を保存した上でVimを閉じます。

    :wq

## 5. 設定ファイルのシンボリックリンクの作成  
次のコマンドを実行して、先ほど作成したnginxの設定ファイルのシンボリックリンクを sites-enabledディレクトリに作成します。

    sudo ln -s /etc/nginx/sites-available/example.com /etc/nginx/sites-enabled/

## 6. デフォルトのシンボリックリンクの削除  
次のコマンドを実行して、/etc/nginx/sites-enabled に元々存在しているシンボリックリンクを削除します。

    sudo rm /etc/nginx/sites-enabled/default

シンボリックリンクを削除したら、一度nginxを再起動させておきましょう。

    sudo systemctl restart nginx

## 7. mysqlにユーザー(test)を追加  
まず、mysqlにsudoを使ってログインします。

    sudo mysql

次に、mysqlにログインした状態で以下のコマンドを実行し、testというユーザーを追加します。

    CREATE USER 'test'@'localhost' IDENTIFIED BY 'Password@0000';
  
以下のコマンドを実行して、ユーザー(test)にDBへのアクセス権限を与えてください。

    GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost';

変更した設定内容を反映させるために、権限をリロードします。以下のコマンドを実行してください。

    FLUSH PRIVILEGES;

最後に、MySQLのコマンドラインクライアントを終了します。以下のコマンドを実行してください。

    exit

先ほど作成したユーザー(test)でmysqlにアクセスできるかを確認しておきましょう。
以下のコマンドを実行するとパスワードの入力が求められるので、Password@0000と入力するか、自身で設定したパスワードを入力してください。

    mysql -u test -p

mysqlに入ることができれば、問題ありません。再度exitと入力して抜けてください。

## 8. アプリケーション(example-app)をnginxのドキュメンルートへ配置する  
『vagrant up』コマンドを実行したことで、ホストOS側のexample-appディレクトリは、仮想マシン側では `/vagrant` となっています。  
次のコマンドを仮想マシンで実行すると、example-appのルートディレクトリと同じ内容が表示されるはずです。

    ls -al /vagrant 

それでは、この/vagrantディレクトリ（example-app）をnginxのドキュメントルートへ配置させていきましょう。
### 8-1. /vagrantディレクトリ（example-app）のコピーを作成
まず、仮想マシンにログインしている状態で、以下のコマンドを実行してください。

    sudo cp -r /vagrant /var/www/html/

すると/vagrantディレクトリ（example-app）が、/var/www/html/ディレクトリにコピーされます。
次のコマンドでvagrantディレクトリがコピーされたのかを確認できます。vagrantというディレクトリが追加されているはずです。

    ls -al /var/www/html

### 8-2. vagrantディレクトリの名前を変更
次のコマンドを実行して、vagrantディレクトリの名前をexample-appに変更しましょう。

    sudo mv /var/www/html/vagrant/ /var/www/html/example-app

すると /vagrantディレクトリにあったexample-appが /var/www/htmlディレクトリへ移動しています。

## 9. example-appのユーザーをwww-dataに変更  
nginxのドキュメントルートのユーザーが www:data なので、アプリケーションのユーザーも www:data に変更しておきます。

    sudo chown -R www-data:www-data /var/www/html/example-app

これで、nginxのドキュメントルートにexample-appを配置することができました。

## 10. .envファイルの編集  
ここから先の作業は、アプリケーション(example-app)のルートディレクトリで行います。  
コマンドプロンプト(Windows)やターミナル(MacOS)で移動しておきましょう。

    cd /var/www/html/example-app

### 10-1. .env.exampleファイルの名前を.envに変更
このReadMe通りに仮想マシンを立ち上げている場合は .env.exampleのファイル名を .envに名前を変更しておきましょう。次のコマンドを実行します。

    sudo mv .env.example .env

### 10-2. .envファイルの内容を変更
#### 10-2-1. データベースの設定を変更
デプロイ環境におけるmysqlの設定を、19行目から25行目にコメントアウトしています。
そのコメントアウトを解除した後、11行目から17行目に書いている開発環境におけるmysqlの設定をコメントアウトするか削除しておいてください。

#### 10-2-2. デバックモードを無効にする
リポジトリをクローンした段階では、デバックモードが有効になっているので無効にします。
4行目の`APP_DEBUG=true`を`APP_DEBUG=false`に変更してください。

#### Vimで.envファイルを開く
    sudo vi .env

#### .envファイルのデバックモードとMysqlの設定
.envファイルを開いたら、以下の設定のコメントアウトを解除してください。
Vimでファイルの中身を編集する際には「i」を1回クリックします。すると編集モードになります。 

4行目（デバックモード）  

    APP_DEBUG=false

19行目から25行目(mysqlの設定)

    # デプロイ環境でのDB設定（この行はコメントアウトのまま）
    #DB_CONNECTION=mysql
    #DB_HOST='localhost'
    #DB_PORT=3306
    #DB_DATABASE=example_app
    #DB_USERNAME=test
    #DB_PASSWORD=Password@0000

#### 変更を保存してVimを閉じる
Vimで編集モードを閉じるには、escキーを押してから、次のコマンドを入力します。

    :wq

自身で用意した仮想環境で作業を行う場合は、各仮想マシンの要件を満たす形で .envファイルを用意してください。内容については.env.exampleファイルを参照してください。

## 11. Composer install を実行  
アプリケーションのルートディレクトリで次のコマンドを実行してライブラリをインストールします。

    sudo -u www-data composer install --no-dev

## 12. データベースの作成
example-appのルートディレクトリで以下のコマンドを実行します。

    sudo -u www-data php artisan migrate

コマンドが走ると「新しく example_appというデータベースを作成するか？」と聞かれます。  
yes と答えてアプリケーションのデータベースを作成してください。

以下のコマンドを実行するとダミーのデータを挿入することができます。

    sudo -u www-data php artisan db:seed

また、次のコマンドも実行して画像をブラウザで表示できるようにしてください。

    sudo -u www-data php artisan storage:link

これで、つぶやきに紐づいた画像を表示することができるようになります。

## 13. メール送信機能を追加
### 13-1. MailHogのインストール
MailHogをインストールする前に、最新のパッケージ情報を利用できるようにします。

    sudo apt-get update

### 13-2. Go言語の実行環境をインストール
MailhogはGo言語で開発されているため、実行にはGoの実行環境が必要です。

    sudo apt-get install golang-go

### 13-3. Mailhogのインストール
カレントディレクトリに書き込み権限を与えます。

    sudo chmod 777 .

次のコマンドで指定されたURLからMailhogのバイナリファイルをダウンロードします。  
ここでは、バージョン1.0.1のLinux用のMailhogのバイナリがダウンロードされます。

    wget https://github.com/mailhog/MailHog/releases/download/v1.0.1/MailHog_linux_amd64
    
### 13-4. Mailhogを実行
ダウンロードしたMailhogバイナリに実行権限を付与することで、バイナリを実行可能な状態に変更します。

    sudo chmod +x MailHog_linux_amd64

次のコマンドでMailhogバイナリを`/usr/local/bin`ディレクトリへ移動させ、ファイル名を`mailhog`に変更します。  
`/usr/lical/bin`ディレクトリに置かれた実行ファイルは、システム全体で利用できるため、この操作によりMailhogをどこからでも実行できるようになります。

    sudo mv MailHog_linux_amd64 /usr/local/bin/mailhog

### 13-5. MailHogの起動と設定
MailHogを起動を起動します。以下のコマンドを実行してください。

    mailhog &

### 13-6. Laravelの.envファイルにMailHogの設定を追加
.envファイルのメール設定を以下の内容に変更してください。

    MAIL_MAILER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=your_email@example.com
    MAIL_FROM_NAME="${APP_NAME}"

以上で、Mailhogをexample-appに実装することができました。

メールが正しく送信されているかを確認する際には、  
会員登録の作業を行ってから、以下のipアドレスにアクセスします。

    192.168.56.56:8025

Mailhogの管理画面でメールを受信しているかどうかを確認できます。

## 14. ホストOS側からブラウザでアプリケーションを表示  
ホストOSのブラウザで仮想マシンのIPアドレスを入力すればアプリケーションを確認することができます。  

    IPアドレス：192.168.56.56

最初に表示されるLaravelデフォルトの画面にアプリケーションへのリンクを作成しているので確認してください。