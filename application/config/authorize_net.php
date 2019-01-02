<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Authorize.net Account Info
$core = Setting::first();
$config['api_login_id'] = $core->authorize_api_login_id;
$config['api_transaction_key'] = $core->authorize_api_transaction_key;
$config['api_url'] = 'https://secure.authorize.net/gateway/transact.dll'; // PRODUCTION URL
//$config['api_url'] = 'https://test.authorize.net/gateway/transact.dll'; // TEST URL


/* EOF */