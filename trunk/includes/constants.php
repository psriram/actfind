<?php

define('SITEDIR', dirname(dirname(__FILE__)));
$dir = dirname($_SERVER['PHP_SELF']);
if ($dir == '/') $dir = '';

define('SITENAME', 'ActivityFinder');
define('HTTPPATH', 'http://'.$_SERVER['HTTP_HOST'].$dir);
define('ROOTHTTPPATH', $dir);

define('ROOTDIR', dirname(dirname(__FILE__)));
define('APIDIR', $dir.'/api');
define('APIHTTPPATH', 'http://'.$_SERVER['HTTP_HOST'].APIDIR);
define('LOGINURL', '/users/login');

define('PLACESAPIKEY', 'AIzaSyBvXqWIcqyTVRgjXsVjDbdORcNaXHVjtOw');


date_default_timezone_set('America/Los_Angeles');
define('_FUNC_TIME_ZERO', 0);
define('_FUNC_TIME_FIVEMINUTE', 300);
define('_FUNC_TIME_TENMINUTE', 600);
define('_FUNC_TIME_FIFTEENMINUTE', (60*15));
define('_FUNC_TIME_THIRTYMINUTE', (60*30));
define('_FUNC_TIME_HOUR', 3600);
define('_FUNC_TIME_FOUR_HOUR', (_FUNC_TIME_HOUR*4));
define('_FUNC_TIME_DAY', (_FUNC_TIME_HOUR*24));
define('_FUNC_TIME_WEEK', (_FUNC_TIME_HOUR*24*7));
define('_FUNC_TIME_MONTH', (_FUNC_TIME_HOUR*24*31));
define('_FUNC_TIME_TRHEE_MONTH', (_FUNC_TIME_HOUR*24*90));
define('_FUNC_TIME_SIX_MONTH', (_FUNC_TIME_HOUR*24*90*2));
define('_FUNC_TIME_NINE_MONTH', (_FUNC_TIME_HOUR*24*90*3));
define('_FUNC_TIME_YEAR', (_FUNC_TIME_HOUR*24*365));