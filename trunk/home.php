<?php
//controller comes here
$pageTitle = 'test home';
//getting data
$url = 'http://mkhancha.mkgalaxy.com/api/home';
$content = curlget($url);
$data = json_decode($content, 1);

//view comes below
?>
home
<?php echo pr($data);?>