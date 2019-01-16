<?php

require_once('./config.php');

function _fetchUrl($url) {
  global $config;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, $config["curl_timeout"]);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $config["curl_sslverifypeer"]);
  $feedData = curl_exec($ch);
  curl_close($ch);
  return $feedData;
}

$request = _fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$config["facebook_app_id"]}&client_secret={$config["facebook_secret_id"]}");
$response = json_decode($request);
$posts = _fetchUrl("https://graph.facebook.com/{$config["facebook_page_id"]}/posts?access_token={$response->access_token}&fields={$config["facebook_fields"]}");

echo $posts;

?>
