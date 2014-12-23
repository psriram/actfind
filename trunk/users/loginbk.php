<?php
$pageTitle = 'Login Details';

require_once SITEDIR.'/api/googleauth/src/Google_Client.php'; // include the required calss files for google login
require_once SITEDIR.'/api/googleauth/src/contrib/Google_PlusService.php';
require_once SITEDIR.'/api/googleauth/src/contrib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName("Google Authentication"); // Set your applicatio name
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me')); // set scope during user login
$client->setClientId(CLIENTID); // paste the client id which you get from google API Console
$client->setClientSecret(CLIENTSECRET); // set the client secret
$client->setDeveloperKey(DEVELOPERKEY); // Developer key
$url = 'http://' . $_SERVER['HTTP_HOST'] . LOGINURL;
$client->setRedirectUri($url); // paste the redirect URI where you given in APi Console. You will get the Access Token here during login success
$plus 		= new Google_PlusService($client);
$oauth2 	= new Google_Oauth2Service($client); // Call the OAuth2 class for get email address
if(isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
  unset($_SESSION['gplusuer']);
  session_destroy();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . LOGINURL);
  exit;
}
if(isset($_GET['code'])) {
	$client->authenticate(); // Authenticate
	$_SESSION['access_token'] = $client->getAccessToken(); // get the access token here
	header('Location: http://' . $_SERVER['HTTP_HOST'] . LOGINURL);
  exit;
}

if(isset($_SESSION['access_token'])) {
	$client->setAccessToken($_SESSION['access_token']);
}

$title = 'Title';
if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();
  save($user, 'googleplus');
  $_SESSION['user'] = $user;
  $details = userDetails($_SESSION['user']['id'], 0);
  $_SESSION['user']['access_level'] = 'member';
  if ($details['success'] == 1) {
    $_SESSION['user']['access_level'] = !empty($details['data']['access_level']) ? $details['data']['access_level'] : 'member';
    $_SESSION['user']['user_id'] = !empty($details['data']['user_id']) ? $details['data']['user_id'] : '';
  }
  $me 			= $plus->people->get('me');
  $optParams 	= array('maxResults' => 100);
  $activities 	= $plus->activities->listActivities('me', 'public',$optParams);
  // The access token may have been updated lazily.
  $_SESSION['access_token'] 		= $client->getAccessToken();
  $email 							= filter_var($user['email'], FILTER_SANITIZE_EMAIL); // get the USER EMAIL ADDRESS using OAuth2
  if (isset($_SESSION['redirectUrl'])) {
    $url = $_SESSION['redirectUrl'];
    unset($_SESSION['redirectUrl']);
    header("Location: ".$url);
    exit;
  }
} else {
	$authUrl = $client->createAuthUrl();
}

if(isset($me)){ 
	$_SESSION['gplusuer'] = $me; // start the session
}
?>
<?php 
if(isset($authUrl)) {
	echo "<a class='login' href='$authUrl'><img src=\"".APIDIR."/googleauth/google-login-button-asif18.png\" alt=\"Google login\" title=\"login with google\" /></a>";
	} else {
		?>
<p><b>ID: </b><?php echo $_SESSION['user']['id']; ?><br>
<b>Name: </b><?php echo $_SESSION['user']['name']; ?><br>
<b>Gender: </b><?php echo $_SESSION['user']['gender']; ?><br>
<img src="<?php echo $_SESSION['user']['picture']; ?>" />
</p>
		<?php
}

/*
[user] => Array
        (
            [id] => 112913147917981568678
            [email] => manishkk74@gmail.com
            [verified_email] => 1
            [name] => Manish Khanchandani
            [given_name] => Manish
            [family_name] => Khanchandani
            [link] => https://plus.google.com/112913147917981568678
            [picture] => https://lh6.googleusercontent.com/-nLg0dFRo0DQ/AAAAAAAAAAI/AAAAAAAAGQs/AO_UIb6UHAM/photo.jpg
            [gender] => male
        )
        */
?>