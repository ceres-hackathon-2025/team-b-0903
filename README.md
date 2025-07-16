## 起動方法

```sh
# このrepostioryをclone
$ git clone XXXXX

# phpとcomposerがインストールされていることを確認
$ composer -V
Composer version 2.8.10 2025-07-10 19:08:33
PHP version 8.4.10 (/Users/h-tamai/homebrew/Cellar/php/8.4.10/bin/php)
Run the "diagnose" command to get more detailed diagnostics output.

# 必要パッケージのインストール
$ composer i

# アプリケーションの起動
$ php -S localhost:8000 -t public
```
