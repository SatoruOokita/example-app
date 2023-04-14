<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# example-appのセットアップ
## このアプリケーションについて
このアプリケーションはLaravelの学習過程で作成したものです。  
使用した参考書は「プロフェッショナルWebプログラミング Laravel9」です。

主な機能は、つぶやき機能と席替え機能です。

### つぶやき機能でできること
- ユーザー登録
- 140文字以内のつぶやきの作成（画像を4枚まで添付）
- 作成したつぶやきの編集
- 作成したつぶやきの削除
- 作成されたつぶやきの表示
  
### 席替え機能でできること
- 生徒数・座席の列の数・座席の行の数を入力
- 入力に応じて席替えを実行
- 席替えのやり直し

### 注意
※ ~~Mailhogのインストールができていないため、会員登録を行うとエラー画面になります。~~  
※ ~~画像をアップロードしても正しく表示されない状態です。~~

## 0. 「インストール作業」の前に
本ReadMeは、仮想環境をVagrantで用意し、そこでアプリケーションを動作させることを念頭に作成しています。

ローカルの開発環境で動作させる場合には、手順0-1~0-5を参考に作業を進めてプロジェクトを立ち上げてください。

※Windowsマシンで作業を行う場合は、[WSL](https://learn.microsoft.com/ja-jp/windows/wsl/install)環境とDocker [Desktop](https://docs.docker.com/desktop/install/windows-install/)を用意し、WSLのターミナルで作業を進めてください。

### 0-1. リポジトリをクローン
次のコマンドを実行して、GitHubのリポジトリからプロジェクトをクローンしましょう。

    git clone https://github.com/SatoruOokita/example-app.git

### 0-2. アプリケーションのディレクトリへ移動
アプリケーションのルートディレクトリへ移動

    cd example-app

### 0-3. .envファイルの作成
`.env.example`をコピーして`.env`を作成する

    cp .env.example .env

### 0-4. 必要なパッケージをインストール
次のコマンドを実行し、プロジェクトの依存関係をインストールします。  
これにより、必要なパッケージがインストールされます。

    composer install

### 0-5. アプリケーションを実行
Laravel Sailを使用して、Dockerコンテナを起動します。  
これにより、アプリケーションの実行環境が整います。次のコマンドを実行してください。

    ./vendor/bin/sail up

#### ※`could not open input file`エラーが発生した場合
`composer.json`にLaravel Sailをインストールするように記述しているにも関わらず`./vendor/bin/sail up`コマンドを実行した際に`could not open input file`エラーが発生することがありました。

そのような場合には、次のコマンドを実行してlaravel/sailパッケージをインストールし直してから、再度`./vendor/bin/sail up`コマンドを実行してください。

    composer require laravel/sail --dev

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
仮想マシンを立ち上げるコマンドを実行します。

    vagrant up

Vagrantfileの内容に従って仮想マシン（ubuntu）が立ち上がります。 (数分かかる場合があります。)

仮想マシンが立ち上がっているかどうかは次のコマンドで確認します。

    vagrant status

「running」と表示されたら仮想マシンは立ち上がっているので、次の手順でssh接続をします。

## 3. 仮想マシンにログインする 
仮想マシンにログインしましょう。

    vagrant ssh

コマンドプロンプトの「ユーザー名@ホスト名」が、「vagrant@ubuntu-jammy」になればログイン成功です。

## 4. アプリケーションを `/var/www/html`ディレクトリへ配置する  
仮想マシンにログインできたら、まずはアプリケーションを `/var/www/html`ディレクトリへ移動させます。

なお、ここ（Vagrantを利用する場合）ではLaravelアプリケーション名は`example-app`とし、デプロイ先を`/var/www/html/example-app`として作業を進めていきます。

### 4-1. アプリケーションを確認
ホストOS側のexample-appディレクトリは、仮想マシン側では `/vagrant` となっています。  
次のコマンドを実行すると、example-appのルートディレクトリと同じ内容が表示されるはずです。

    ls -al /vagrant 

### 4-2. アプリケーションを移動（コピー）
それでは、この/vagrantディレクトリ（example-app）を`/var/www/html/`ディレクトリへ配置しましょう。以下のコマンドを実行してください。

    sudo cp -r /vagrant /var/www/html/example-app

`/vagrant`ディレクトリが、`/var/www/html/`ディレクトリに、`example-app`としてコピーされます。

### 4-3. 移動できたか確認
次のコマンドで`/var/www/html`ディレクトリの中身を見ると、`example-app`というディレクトリが追加されていることが確認できます。

    ls -al /var/www/html

## 5. nginxの設定を仮想マシンに追加  
デフォルトの設定の場合、nginxのドキュメントルートは`/var/www/html/index.nginx-debian.html`です。

`example-app/public`がnginxのドキュメントルートとなるように設定を変更していきましょう。テキストエディターは好みのものを使ってください。 

`/etc/nginx/sites-available` ディレクトリに、`example.com`というファイルを作成し、以下の設定内容を貼り付けてください。  

※Vimを用いた作業手順の例を記しておきます。

### Vimを使った作業例
次のコマンドを実行して `example.com`というファイルを作成してvimを開きます。

    sudo vi /etc/nginx/sites-available/example.com

vimが立ち上がったら以下の「/etc/nginx/sites-available/example.comの内容」をコピーして貼り付けます。

#### /etc/nginx/sites-available/example.comの内容
    server {
        listen 80;
        listen [::]:80;
        server_name example.com;
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

貼り付けることができたら、次の命令をVimに出して変更を保存した上でVimを閉じます。

    :wq

## 6. 設定ファイルのシンボリックリンクの作成  
次のコマンドを実行して、先ほど新しく作成したnginxの設定ファイルのシンボリックリンクを `sites-enabled`ディレクトリに作成します。

    sudo ln -s /etc/nginx/sites-available/example.com /etc/nginx/sites-enabled/

## 7. デフォルトのシンボリックリンクの削除  
次のコマンドを実行して、`/etc/nginx/sites-enabled` に元々存在しているシンボリックリンクを削除します。

    sudo rm /etc/nginx/sites-enabled/default

シンボリックリンクを削除したら、一度nginxを再起動させておきましょう。

    sudo systemctl restart nginx

## 8. MySQLにユーザー(test)を追加  
`Vagrant up`実行時にMySQLをインストールしています。  
データベースを利用できるよう、MySQLの設定を行っていきましょう。

### 8-1. MySQLにログイン
mysqlにsudoを使ってログインします。

    sudo mysql

### 8-2. ユーザーの追加
次に、mysqlにログインした状態で以下のコマンドを実行し、testというユーザーを追加します。

    CREATE USER 'test'@'localhost' IDENTIFIED BY 'Password@0000';

### 8-3. ユーザーの権限を編集
以下のコマンドを実行して、ユーザー(test)にDBへのアクセス権限を与えてください。

    GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost';

### 8-4. 変更内容の反映
変更した設定内容を反映させるために、権限をリロードします。以下のコマンドを実行してください。

    FLUSH PRIVILEGES;

MySQLのコマンドラインクライアントを終了します。以下のコマンドを実行してください。

    exit

### 8-5. MySQLにアクセスできるか確認
先ほど作成したユーザー(test)でMySQLにアクセスできるかを確認しておきましょう。
以下のコマンドを実行するとパスワードの入力が求められるので、「 Password@0000 」と入力するか、自身で設定したパスワードを入力してください。

    mysql -u test -p

MySQLに入ることができれば、問題ありません。再度exitと入力して抜けてください。

## 9. example-appのユーザーをwww-dataに変更  
nginxのユーザーが `www:data` なので、アプリケーションのユーザーも `www:data` に変更しておきます。

    sudo chown -R www-data:www-data /var/www/html/example-app

## 10. アプリケーションへ移動
ここから先の作業は、アプリケーション(example-app)のルートディレクトリで行います。  
コマンドプロンプト(Windows)やターミナル(MacOS)で移動しておきましょう。

    cd /var/www/html/example-app

## 11. .envファイルの編集  
### 11-1. .env.exampleファイルの名前を.envに変更
.env.exampleのファイル名を .envに名前を変更しておきましょう。次のコマンドを実行します。

    sudo mv .env.example .env

`.env`ファイルを編集し、自分の環境に適した設定を行ってください。
なお、`.env.example.production`に本番環境で動作する設定を記しているので適時ご利用ください。

### 11-2. .envファイルの内容を変更

    sudo vi .env

変更するのは、データベースとメールセクションの２箇所です。

#### データベースの設定内容
    DB_CONNECTION=mysql
    DB_HOST='localhost'
    DB_PORT=3306
    DB_DATABASE=example_app     
    DB_USERNAME=test
    DB_PASSWORD=Password@0000

#### メール機能の設定内容（Mailhogを利用）
    MAIL_MAILER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

## 12. Composer install を実行  
次のコマンドを実行し、パッケージをインストールしましょう。

    sudo -u www-data composer install --optimize-autoloader --no-dev

### ※composer.jsonについて
通常、Fakerはテストやシーディングに使用されるため、本番環境で利用することは推奨されません。

ただし今回は、つぶやき内容を表示させるために`composer.json`ファイルの`"require"`セクションに`"fakerphp/faker": "^1.9.1"`を書き足しています。

## 13. データベースの作成
### 13-1. マイグレーションを実行
example-appのルートディレクトリで以下のコマンドを実行します。

    sudo -u www-data php artisan migrate

コマンドが走ると「新しく example_appというデータベースを作成するか？」と聞かれます。  
yes と答えてアプリケーションのデータベースを作成してください。

### 13-2. ダミーデータの挿入
以下のコマンドを実行するとダミーのデータを挿入することができます。

    sudo -u www-data php artisan db:seed

### 13-3. 画像を表示
また、次のコマンドも実行して画像をブラウザで表示できるようにしてください。

    sudo -u www-data php artisan storage:link

これで、`/storage`ディレクトリに格納されている画像を表示できるようになります。

## 14. メール送信機能を追加
### 14-1. MailHogのインストール
MailHogをインストールする前に、最新のパッケージ情報を利用できるようにします。以下のコマンドを実行してください。

    sudo apt-get update

次のコマンドで指定されたURLからMailhogのバイナリファイルをダウンロードします。  
ここでは、バージョン1.0.1のLinux用のMailhogのバイナリがダウンロードされます。

    sudo -u www-data wget https://github.com/mailhog/MailHog/releases/download/v1.0.1/MailHog_linux_amd64
    
### 14-2. Mailhogを実行
ダウンロードしたMailhogバイナリに実行権限を付与することで、バイナリを実行可能な状態に変更します。

    sudo chmod +x MailHog_linux_amd64

次のコマンドでMailhogバイナリを`/usr/local/bin`ディレクトリへ移動させ、ファイル名を`mailhog`に変更します。  
`/usr/lical/bin`ディレクトリに置かれた実行ファイルは、システム全体で利用できるため、この操作によりMailhogをどこからでも実行できるようになります。

    sudo mv MailHog_linux_amd64 /usr/local/bin/mailhog

### 14-3. MailHogの起動
MailHogを起動を起動します。以下のコマンドを実行してください。

    mailhog &

### 14-4. メール機能の確認
メールが正しく送信されているかをMailhogで確認する際には、会員登録の作業を行ってから、以下のURLにアクセスします。

    http://192.168.56.56:8025

Mailhogの管理画面でメールを受信しているかどうかを確認できます。

## 15. ホストOS側からブラウザでアプリケーションを表示  
ホストOSのブラウザで以下のURLを入力すればアプリケーションを確認することができます。  

    http://192.168.56.56

最初に表示されるLaravelデフォルトの画面にアプリケーションへのリンクを作成しているので確認してください。