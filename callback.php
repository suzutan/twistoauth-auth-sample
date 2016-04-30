<?php

require("TwistOAuth.phar");
require("config.php");
session_start();

//承認のための文字列を取得
$oauth_verifier = isset($_GET["oauth_verifier"])? $_GET["oauth_verifier"] : null;

//セッションに認証情報がなければ出直させる
if(!isset($_SESSION["auth"])) {
	echo "auth.php にアクセスしてから出直してきてください. <br />", PHP_EOL;
	exit;
}

//セッションから認証情報を取得
$auth = $_SESSION["auth"];

//sessionに保存する必要がなくなったため破棄
unset($_SESSION["auth"]);

//承認情報から、OAuthのためのキーを取得
$auth = $auth->renewWithAccessToken($oauth_verifier);

echo "consumer_key is {$auth->ck}<br />";
echo "consumer_secret is {$auth->cs}<br />";
echo "access_token is {$auth->ot}<br />";
echo "access_token_secret is {$auth->os}<br />";

//access_token, access_token_secretを保存している場合は、以下のコードでnewすればよい
//$auth = new TwistOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);



//これはTL取得
$tweet = $auth->get("statuses/user_timeline", ["count" => 10]);
foreach($tweet as $v) {

	echo "@{$v->user->screen_name}: {$v->text}<br />",PHP_EOL;
}

//これはpostテスト
var_dump($auth->post("statuses/update", ["status" => "@su2ca これはテストツイート " . time()] ));


