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

### 2-1. 仮想マシンを立ち上げるディレクトリを用意する
仮想マシンを立ち上げたいディレクトリへ移動（もしくはディレクトリを作成）します。  
次に、example-appのルートディレクトリにあるVagrantfileと同じ内容のVagrantfileを、仮想マシンを立ち上げるディレクトリ内に用意します。(コピペOK)

### 2-2. コマンドを実行して仮想マシンを立ち上げる
コマンドプロンプト(Windows)やターミナル(MacOS)を開き、Vagrantfileが存在するディレクトリへ移動しておきましょう。  

    cd "Path to the Directory"

移動ができたら次のコマンドを実行して仮想マシンを立ち上げてください。

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

## 8. アプリケーション(example-app)を仮想マシンへ送る  
自身が作業しやすい方法でアプリケーション(example-app)をnginxのドキュメントルート(var/www/html)へ配置してください。  
例として、Vagrantの共有フォルダを用いて nginxのドキュメントルートへアプリケーションを配置する手順を示します。

### 共有フォルダを使う方法
まず、ホストOS側で『vagrant up』コマンドを実行したディレクトリに example-appを配置します。  
これで仮想マシン側の /vagrantディレクトリにも example-appを配置することができています。  

次にexample-appをnginxのドキュメントルートへ移動させます。  
仮想マシンにログインしている状態で、以下のコマンドを実行してください。

    sudo mv /vagrant/example-app /var/www/html

すると /vagrantディレクトリにあったexample-appが /var/www/htmlディレクトリへ移動しています。

## 9. example-appのユーザーをwww-dataに変更  
nginxのドキュメントルートのユーザーが www:data なので、アプリケーションのユーザーも www:data に変更しておきます。

    sudo chown -R www-data:www-data /var/www/html/example-app

## 10. .envファイルの編集  
ここから先の作業は、アプリケーション(example-app)のルートディレクトリで行います。  
コマンドプロンプト(Windows)やターミナル(MacOS)で移動しておきましょう。

    cd /var/www/html/example-app

### 10-1. .env.exampleファイルの名前を.envに変更
このReadMe通りに仮想マシンを立ち上げている場合は .env.exampleのファイル名を .envに名前を変更しておきましょう。次のコマンドを実行します。

    sudo mv .env.example .env

### 10-2. .envファイルの内容を変更
デプロイ環境におけるmysqlの設定を、.env.exampleの19行目から25行目にコメントアウトしています。
そのコメントアウトを解除した後、11行目から17行目に書いている開発環境におけるmysqlの設定をコメントアウトするか削除しておいてください。

#### Vimで.envファイルを開く
    sudo vi .env

#### .envファイルのMysqlの設定
.envファイルを開いたら、以下の設定のコメントアウトを解除してください。
Vimでファイルの中身を編集する際には「i」を1回クリックします。すると編集モードになります。 

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

    sudo composer install

### 12. データベースの作成
example-appのルートディレクトリで以下のコマンドを実行します。

    php artisan migrate

コマンドが走ると「新しく example_appというデータベースを作成するか？」と聞かれます。  
yes と答えてアプリケーションのデータベースを作成してください。

最後に以下のコマンドを実行するとダミーのデータを挿入することができる。

    php artisan db:seed

## 13. ホストOS側からブラウザでアプリケーションを表示  
ホストOSのブラウザで仮想マシンのIPアドレスを入力すればアプリケーションを確認することができます。  

    IPアドレス：192.168.56.56

最初に表示されるLaravelデフォルトの画面にアプリケーションへのリンクを作成しているので確認してください。