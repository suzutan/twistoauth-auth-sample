<?php

require("TwistOAuth.phar");
require("config.php");
session_start();

//アプリ情報のみ設定
$auth = new TwistOAuth(CONSUMER_KEY, CONSUMER_SECRET);

//認証設定をwebリダイレクトに、callback urlを設定
$auth = $auth->renewWithRequestToken(CALLBACK_URL);

//以下の場合、PIN認証になる
//PIN認証の場合のaccess_tokenの取り方はcallback.phpに記載

//$auth->renewWithRequestToken("oob");

//認証情報をそのままcallbackで使えるようにobjectをセッションに保存
$_SESSION["auth"] = $auth;

//認証URLを取得
$url = $auth->getAuthenticateUrl();

//リダイレクト
header("Location: {$url}");

