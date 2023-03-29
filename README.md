<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 作業手順の目次
### 1. 仮想マシンを立ち上げるまでの作業
1-1. Virtualboxインストール  
1-2. Vagrantインストール  
1-3. 仮想マシンを立ち上げる  

### 2. 仮想マシンを立ち上げてからの作業
2-1. リポジトリをクローン  
2-2. .env.exampleをリネーム  
2-3. scpコマンドでアプリケーションを仮想マシンへ送る  
2-4. example-appのユーザーをwww-dataに変更  
2-5. nginxの設定を仮想マシンに追加  
2-6. 設定ファイルのシンボリックリンクの作成  
2-7. デフォルトのシンボリックリンクの削除  
2-8. mysqlにユーザーを追加  
2-9. ホストOS側からブラウザでアプリケーションを表示  

## 1-1. Virtualboxインストール
[VirtualBox公式](https://www.virtualbox.org/)にアクセスし、Downloadのリンクを辿ると [Download Virtual](https://www.virtualbox.org/wiki/Downloads)ページへ移動します。

自分が使うOSに適したVirtualBoxをインストールしてください。


## 1-2. Vagrantインストール
[Vagrant公式](https://developer.hashicorp.com/vagrant)にアクセスし、installのリンクをたどると、どのOS版のVagrantをインストールするかを選択するページへ移動します。

自分が使うOSに適したVagrantをインストールしてください。([Install Vagrant](https://developer.hashicorp.com/vagrant/downloads))  

## 1-3. 仮想マシンを立ち上げる(Vagrantfileを使う)
上記2つの作業が終わったら仮想マシンの立ち上げを行っていきます。

まず、仮想マシンを立ち上げたいディレクトリへ移動（もしくはディレクトリを作成）します。  
次に、そのディレクトリ内にVagrantfileというファイルを用意し、リポジトリ内にあるVagrantfileの内容をコピーしておきます。

そして、次のコマンドを実行してください。

    vagrant up

すると、Vagrantfileの内容に従って仮想マシン（ubuntu）が立ち上がります。


## 2-1. リポジトリをクローン

## 2-2. .env.exampleをリネーム

## 2-3. scpコマンドでアプリケーションを仮想マシンへ送る

## 2-4. example-appのユーザーをwww-dataに変更

## 2-5. nginxの設定を仮想マシンに追加

## 2-6. 設定ファイルのシンボリックリンクの作成

## 2-7. デフォルトのシンボリックリンクの削除

## 2-8. mysqlにユーザーを追加

## 2-9. ホストOS側からブラウザでアプリケーションを表示


