# Attendance Management System

## 概要
従業員の出勤、退勤、休憩を簡単に記録・管理するための勤怠管理アプリケーションです。

## 機能一覧
- ログイン / 認証（Fortify）
- バリデーション
- 打刻機能（出勤・退勤・休憩）
- 勤怠履歴確認（日別・月別）
- 管理者機能（勤怠修正・申請承認・CSV 出力）

## 従業員フロー
1. 会員登録：メールアドレス、氏名、パスワードでアカウントを作成
2. ログイン：メールアドレス・パスワードでログイン
3. 出勤打刻：勤務開始時に「出勤」ボタンをクリック
4. 休憩打刻：休憩開始／終了時にボタンをタップ
5. 退勤打刻：勤務終了時に「退勤」ボタンをクリック
6. 履歴確認：勤怠一覧ページで月別・日別の勤怠記録を参照

## 管理者フロー
1. データ管理：従業員ごとの勤怠情報を管理画面から編集
2. 申請承認：従業員からの修正申請を承認
3. CSV 出力：スタッフの月次勤怠を CSV としてダウンロード

## 使用技術
- PHP：8.1.33
- Laravel：8.83.29
- MariaDB：11.3（MySQL互換）
- Composer：2.8.12
- Laravel Fortify：1.19.1
- nginx：1.21.1
- JavaScript（Vanilla JS / 時刻表示に使用）
- Docker Engine : 28.1.1
- Docker Compose : 2.36.0

## 開発環境構築

### コンテナの作成と起動

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass







## ログイン情報・注意点

本アプリでは、管理者アカウントは初期状態では作成されていません。  
管理画面を使用する場合は、管理者用アカウントを作成後、`role` を DB 上で `admin` に変更してください。

### 従業員用テストアカウント
- メールアドレス：test@example.com
- パスワード：password
- ログインURL：http://localhost/staff/login

### 管理者用テストアカウント
- メールアドレス：admin@example.com
- パスワード：password
- ログインURL：http://localhost/admin/login


## ルーティング構成について

本アプリでは、責務ごとにルートファイルを分割し、可読性と保守性を高めています。

- **routes/web.php**  
  ログイン / ログアウトなど認証関連のルートを定義しています。

- **routes/staff.php**  
  従業員（スタッフ）側が利用する画面のルートを定義しています。  
  出勤・退勤・休憩の打刻、勤怠一覧、月次確認などを担当します。

- **routes/admin.php**  
  管理者機能専用のルートファイルです。  
  勤怠修正、申請承認、スタッフ一覧、CSV 出力など、管理者向け機能を担当しています。  

