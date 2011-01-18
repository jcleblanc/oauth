<?php
$key = 'key here';
$secret = 'key here';

$callback_url = "http://www.mysite.com/complete.php";
$authorization_endpoint = "https://gowalla.com/api/oauth/new";
$access_token_endpoint = "https://api.gowalla.com/api/oauth/token";

/***************************************************************************
 * Function: Run CURL
 * Description: Executes a CURL request
 * Parameters: url (string) - URL to make request to
 *             method (string) - HTTP transfer method
 *             headers - HTTP transfer headers
 *             postvals - post values
 **************************************************************************/
function run_curl($url, $method = 'GET', $headers = null, $postvals = null){
    $ch = curl_init($url);
    
    //GET request: send headers and return data transfer
    if ($method == 'GET'){
        $options = array(
            CURLOPT_HEADER => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLINFO_HEADER_OUT => 0,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1
        );
        curl_setopt_array($ch, $options);
    //POST / PUT request: send post object and return data transfer
    } else {
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postvals,
            CURLOPT_RETURNTRANSFER => 1
        );
        curl_setopt_array($ch, $options);
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

/***************************************************************************
 * Function: Refresh Access Token
 * Description: Refreshes an expired access token
 * Parameters: key (string) - application consumer key
 *             secret (string) - application consumer secret
 *             refresh_token (string) - refresh_token parameter passed in
 *                to fetch access token request.
 **************************************************************************/
function refreshToken($key, $secret, $refresh_token){
    //set URL to be used for refresh access token request
    $url = "https://api.gowalla.com/api/oauth/token";

    //construct POST object required for refresh token fetch
    $postvals = array('grant_type' => 'refresh_token',
                      'client_id' => $key,
                      'client_secret' => $secret,
                      'refresh_token' => $refresh_token);
    
    //return JSON refreshed access token object
    return json_decode(run_curl($url, 'POST', null, $postvals));
}
?>
