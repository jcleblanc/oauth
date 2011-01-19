<?php
require_once "common.php";

//construct Facebook auth URI
$auth_url = $authorization_endpoint
          . "?redirect_uri=" . $callback_url
          . "&client_id=" . $key;

//forward user to Facebook auth page
header("Location: $auth_url");
?>