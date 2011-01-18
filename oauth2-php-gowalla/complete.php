<?php
require_once "common.php";

//capture code from auth
$code = $_GET["code"];

//construct POST object for access token fetch request
$postvals = array('grant_type' => 'authorization_code',
                  'client_id' => $key,
                  'client_secret' => $secret,
                  'code' => $code,
                  'redirect_uri' => $callback_url);

//get JSON access token object (with refresh_token parameter)
$token = json_decode(run_curl($access_token_endpoint, 'POST', null, $postvals));

echo "<h1>TOKEN</h1>";
var_dump($token);
echo "<br /><br />";

//set request headers for signed OAuth request
$headers = array("Accept: application/json");

//construct URI to fetch profile information for current user
$profile_url = "https://api.gowalla.com/users/me?oauth_token=" . $token->access_token;

//fetch profile of current user
$profile = run_curl($profile_url, 'GET', $headers);

var_dump($profile);

echo "<h1>REFRESHING TOKEN</h1>";
var_dump(refreshToken($key, $secret, $token->refresh_token));
?>