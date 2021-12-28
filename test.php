<?php

//API urls

//$req_url = 'http://mydrupalserver.com/oauth/request_token';
$req_url = 'http://kavya-rasik.com/oauth/request_token';

//$authurl = 'http://mydrupalserver.com/oauth/authorize';
$authurl = 'http://kavya-rasik.com/oauth/authorize';

//$acc_url = 'http://mydrupalserver.com/oauth/access_token';
$acc_url = 'http://kavya-rasikcom/oauth/access_token';
 

//Your Application key and secret

//$conskey = 'FASMSeZqsNJwDLzhPBNgV46vdxcCV8BT';
$conskey = 'yrSprUfbGexkQPKTUdoNrHnzyUcemD7L';

//$conssec = 'nVsqAzqBTtWhwYsQzguZmd5Mw4bWWTnA';
$conssec = 'SzLrxSuq5Fa6CVQsmpymE7YSB9rD9GUK';
 

//Your Application URL

//$api_url = 'http://myapp.com/rest';
$api_url = 'http://prosperconsulting.in/test';

 

//Enable session.  We will store token information here later

session_start();

 

// state will determine the point in the authorization request our user is in

// In state=1 the next request should include an oauth_token.

// If it doesn't go back to 0

if(!isset($_GET['oauth_token']) && $_SESSION['state']==1) $_SESSION['state'] = 0;

 

try {

  //create a new Oauth request

  $oauth = new OAuth($conskey, $conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

  $oauth->enableDebug();

  //If this is a new request, request a new token with callback and direct user to allow/deny page

  if(!isset($_GET['oauth_token']) && !$_SESSION['state']) {

    $request_token_info = $oauth->getRequestToken($req_url);

    $_SESSION['secret'] = $request_token_info['oauth_token_secret'];

    $_SESSION['state'] = 1;

    header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);

    exit;

  //If this is a callback from allow/deny page, request the auth token and auth token secret codes

//and save them in session

  } else if($_SESSION['state']==1) {

    $oauth->setToken($_GET['oauth_token'], $_SESSION['secret']);

    $access_token_info = $oauth->getAccessToken($acc_url);

    $_SESSION['state'] = 2;

    $_SESSION['token'] = $access_token_info['oauth_token'];

    $_SESSION['secret'] = $access_token_info['oauth_token_secret'];

  } 

  $oauth->setToken($_SESSION['token'], $_SESSION['secret']);

 

   // URL should have the format "$api_url/node/[nid]".

  $oauth->fetch("$api_url/node/1");

 

  $json = json_decode($oauth->getLastResponse());

  print_r($json);

} catch(OAuthException $E) {

  print_r($E);

}

?>