<?php
require_once "common.php";

//capture code from auth
$code = $_GET["code"];

//construct POST object for access token fetch request
$postvals = array('grant_type' => 'authorization_code',
                  'client_id' => KEY,
                  'client_secret' => SECRET,
                  'code' => $code,
                  'redirect_uri' => CALLBACK_URL);

//get JSON access token object (with refresh_token parameter)
$token = json_decode(run_curl(ACCESS_TOKEN_ENDPOINT, 'POST', $postvals));

//set request headers for signed OAuth request
$headers = array("Accept: application/json");

//construct URI to fetch contact information for current user
$contact_url = "https://www.google.com/m8/feeds/contacts/default/full?oauth_token=" . $token->access_token;

//fetch profile of current user
$contacts = run_curl($contact_url, 'GET', $headers);

var_dump($contacts);

echo "<h1>REFRESHING TOKEN</h1>";
var_dump(refreshToken($token->refresh_token));
?>
