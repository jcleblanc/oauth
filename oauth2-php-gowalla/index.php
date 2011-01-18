<?php
require_once "common.php";

//construct Gowalla auth URI
$auth_url = $authorization_endpoint
          . "?redirect_uri=" . $callback_url
          . "&client_id=" . $key;

//forward user to Gowalla auth page
header("Location: $auth_url");
?>