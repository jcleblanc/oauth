<?php
require_once "common.php";

$auth_url = sprintf("%s?scope=%s&response_type=code&redirect_uri=%s&client_id=%s",
                    AUTHORIZATION_ENDPOINT,
                    urlencode("https://identity.x.com/xidentity/resources/profile/me"),
                    urlencode(CALLBACK_URL),
                    KEY);

//forward user to PayPal auth page
header("Location: $auth_url");
?>