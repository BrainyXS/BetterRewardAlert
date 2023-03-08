<?php

require_once "cfg.php";

if (!isset($_GET["code"])) {
    header("Location: https://id.twitch.tv/oauth2/authorize?client_id=" . cfg::CLIENT_ID . "&scope=channel:manage:redemptions&response_type=code&redirect_uri=" . cfg::CALLBACK_URL);
    return;
}


$code = $_GET["code"];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://id.twitch.tv/oauth2/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "client_id=" . cfg::CLIENT_ID . "&client_secret=" . cfg::CLIENT_SECRET . "&code=" . $code . "&grant_type=authorization_code&redirect_uri=" . cfg::CALLBACK_URL,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded"
    ),
));
$response = curl_exec($curl);

$json = json_decode($response);
$token = $json->access_token;

echo $token;