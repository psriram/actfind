<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists('curlget')) {
	function curlget($url, $post=0, $POSTFIELDS='') {
		$https = 0;
		if (substr($url, 0, 5) === 'https') {
			$https = 1;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if (!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
		curl_setopt($ch, CURLOPT_COOKIEJAR,COOKIE_FILE_PATH);
		if (!empty($https)) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}


if (!function_exists('pr')) {
function pr($d){
	echo '<pre>';
	print_r($d);
	echo '</pre>';
}
}



if (!function_exists("url_name_v2")) {

function url_name_v2($name='')
{
	if (empty($name)) {
		return $name;
	}

	$patterns = array();
	$patterns[0] = "/\s+/";
	$patterns[1] = '/[^A-Za-z0-9]+/';
	$replacements = array();
	$replacements[0] = "-";
	$replacements[1] = '-';
	ksort($patterns);
	ksort($replacements);
	$output = preg_replace($patterns, $replacements, $name);
	$output = strtolower($output);
	return $output;
}//end list_name_url()
}

if (!function_exists("guid")) {

function guid()
{
    mt_srand((double) microtime() * 10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $guid = substr($charid, 0, 8) . '-' .
            substr($charid, 8, 4) . '-' .
            substr($charid, 12, 4) . '-' .
            substr($charid, 16, 4) . '-' .
            substr($charid, 20, 12);
   return $guid;
}

}


if (!function_exists("tstobts")) {
function tstobts($ts)
{
    return $ts * 1000;
}
}
if (!function_exists("btstots")) {
function btstots($bts)
{
    return $bts / 1000;
}
}
if (!function_exists("check_login")) {

function check_login()
{
  if (empty($_SESSION['user'])) {
    $referralUrl = $_SERVER['REQUEST_URI'];
    $_SESSION['redirectUrl'] = $referralUrl;
    header("Location: ".HTTPPATH.'/users/login');
    exit;
  }
}



}
if (!function_exists("ago")) {
function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] 'ago' ";
}

}
if (!function_exists("userDetails")) {

function userDetails($uid, $cache=1)
{
  //api/help/bid/mybids?uid=
  $url = APIHTTPPATH.'/users/detail?uid='.$uid.'&cache='.$cache ;
  $userDetails = curlget($url);
  $userDetails = json_decode($userDetails, 1);
  return $userDetails;
}


}
if (!function_exists("redirect")) {
function redirect()
{
  header("Location: ".HTTPPATH.'/users/login');
  exit;
}

}
if (!function_exists("check_super_admin")) {
function check_super_admin()
{
  if (empty($_SESSION['user']['access_level'])) {
    redirect();
  }
  if ($_SESSION['user']['access_level'] !== 'admin') {
    redirect();
  }
  return true;
}

}
if (!function_exists("save")) {
function save($user, $type='googleplus') {
  global $database_connMain, $connMain;
  $insertSQL = sprintf("select * from auth WHERE `uid` = %s AND sn_type = %s",
                       GetSQLValueString($user['id'], "text"),
                       GetSQLValueString($type, "text"));

  mysql_select_db($database_connMain, $connMain);
  $Result1 = mysql_query($insertSQL, $connMain);
  $rec = mysql_fetch_array($Result1);

  if (!empty($rec)) {
  $insertSQL = sprintf("UPDATE auth set email = %s, gender = %s, name = %s, `uid` = %s, link = %s, picture = %s WHERE `uid`=%s",
                       GetSQLValueString($user['email'], "text"),
                       GetSQLValueString($user['gender'], "text"),
                       GetSQLValueString($user['name'], "text"),
                       GetSQLValueString($user['id'], "text"),
                       GetSQLValueString($user['link'], "text"),
                       GetSQLValueString($user['picture'], "text"),
                       GetSQLValueString($user['id'], "text"));
  } else {
    $user_id = guid();
    $insertSQL = sprintf("Insert into auth set user_id = %s, email = %s, gender = %s, name = %s, `uid` = %s, link = %s, picture = %s, sn_type = %s",
                       GetSQLValueString($user_id, "text"),
                       GetSQLValueString($user['email'], "text"),
                       GetSQLValueString($user['gender'], "text"),
                       GetSQLValueString($user['name'], "text"),
                       GetSQLValueString($user['id'], "text"),
                       GetSQLValueString($user['link'], "text"),
                       GetSQLValueString($user['picture'], "text"),
                       GetSQLValueString($type, "text"));
  }

  mysql_select_db($database_connMain, $connMain);
  $Result1 = @mysql_query($insertSQL, $connMain);


  if (empty($Result1))
    throw new Exception(mysql_error());

}
}

if (!function_exists("encryptAES")) {
  function encryptAES($passwd) {

      $data_to_encrypt = $passwd;
      $key128 = "abcdef0123456789abcdef0123456789";
      $iv = "0000000000000000";

      $cc = $data_to_encrypt;
      $key = $key128;
      $iv =  $iv;
      $length = strlen($cc);

      $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc','');

      mcrypt_generic_init($cipher, $key, $iv);
      $encrypted = base64_encode(mcrypt_generic($cipher,$cc));
      mcrypt_generic_deinit($cipher);

     return $encrypted;
  }
}

if (!function_exists("decryptAES")) {
  function decryptAES($encrypted) {


      $key128 = "abcdef0123456789abcdef0123456789";
      $iv = "0000000000000000";


      $key = $key128;
      $iv =  $iv;


      $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc','');

      mcrypt_generic_init($cipher, $key, $iv);
      $decrypted = mdecrypt_generic($cipher,base64_decode($encrypted));
      mcrypt_generic_deinit($cipher);

      return $decrypted;
  }
}


function getString($array) {
  $get = $_GET;
  if (isset($get['locationFind'])) unset($get['locationFind']);
  if (isset($get['city_id'])) unset($get['city_id']);
  if (isset($get['q'])) unset($get['q']);
  if (!empty($array)) {
    foreach ($array as $ele) {
      if (isset($get[$ele])) unset($get[$ele]);
    }
  }
  $newparam = array();
  if (!empty($get)) {
    foreach ($get as $k => $v) {
      $newparam[] = $k.'='.urlencode($v);
    }
  }
  $query = '';
  if (count($newparam) != 0) {
    $query = "&" . htmlentities(implode("&", $newparam));
  }
  return $query;
}



function encryptText($text)
{
  require_once 'Crypt/Blowfish.php';
  $bf = new Crypt_Blowfish(ENCRYPTKEY);
  $encrypted = $bf->encrypt($text);
  return bin2hex($encrypted);
}

function decryptText($text)
{
  require_once 'Crypt/Blowfish.php';
  $bf = new Crypt_Blowfish(ENCRYPTKEY);
  $plaintext = $bf->decrypt(convertString(trim($text)));
  return trim($plaintext);
}


if (!function_exists('regexp')) {
	function regexp($input, $regexp, $casesensitive=false)
	{
		if ($casesensitive === true) {
			if (preg_match_all("/$regexp/sU", $input, $matches, PREG_SET_ORDER)) {
				return $matches;
			}
		} else {
			if (preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
				return $matches;
			}
		}

		return false;
	}
}
if (!function_exists('urltoword')) {
	function urltoword($url)
	{
		$url = str_replace('-', ' ', $url);
		$url = ucwords(strtolower($url));
		$url = trim($url);
		return $url;
	}
}

function verifyGatewaySignature($proposedSignature, $checkoutId, $amount) {
    $amount = number_format($amount, 2);
    $signature = hash_hmac("sha1", "{$checkoutId}&{$amount}", $apiSecret);

    return $signature == $proposedSignature;
}