<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
function remote_get_contents($url, $timeout = 25)
{
    if (function_exists('curl_init')) {
        $url = check_url($url);
        return curl_get_contents($url, $timeout);
    } else {
        return file_get_contents($url, FILE_USE_INCLUDE_PATH);
    }
}

function curl_get_contents($url, $timeout, $ssl = true)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (!$ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    $output = curl_exec($ch);
    curl_close($ch);

    if ($output === false && $ssl) {
        return curl_get_contents($url, $timeout, false);
    }
    return $output;
}

function curl_post($url, $fields, $ssl = true)
{
    //url-ify the data for the POST
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    if (!$ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    $output = curl_exec($ch);
    //close connection
    curl_close($ch);

    if ($output === false && $ssl) {
        return curl_post($url, $fields, false);
    }

    return $output;
}

function curl_download($url, $file_destination, $ssl = true)
{
    $file = fopen($file_destination, 'wb+');
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_FILE, $file);

    if (!$ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    $output = curl_exec($ch);
    curl_close($ch);
    fclose($file);

    if ($output === false && $ssl) {
        return curl_download($url, $file_destination, false);
    }

    return $output;
}

function check_url($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (200 == $retcode) {
        return $url;
    } else {
        return str_replace('https://www.ownergy.com.br/', 'https://www.ownergy.com.br/', $url);
    }
}
