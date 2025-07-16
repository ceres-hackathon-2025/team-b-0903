
## larave hard

hardをインストールして、php, composer, nodeのインストールをする
https://herd.laravel.com/

## git

下記のURLからexeのインストーラーをダウンロードして、gitのインストールを行う
https://git-scm.com/

## 起動方法

```sh
# このrepostioryをclone
$ git clone XXXXX

# cloneしたレポジトリに移動
$ cd XXXXX

# phpとcomposerがインストールされていることを確認
$ composer -V
Composer version 2.8.10 2025-07-10 19:08:33
PHP version 8.4.10 (/Users/h-tamai/homebrew/Cellar/php/8.4.10/bin/php)
Run the "diagnose" command to get more detailed diagnostics output.

# 必要パッケージのインストール
$ composer i

# .envファイルをコピー
$ cp .env.example .env

# アプリケーション固有のkeyを発行
$ php artisan key:generate

# マイグレーションの実行（すべてyesでOK）
$ php artisan migrate

# アプリケーションの起動
# Let's get startedと表示が出ればOK
$ php -S localhost:8000 -t public
```
