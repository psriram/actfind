<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle; ?></title>
<link href="<?php echo HTTPPATH; ?>/styles/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo HTTPPATH; ?>/layouts/home/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo HTTPPATH; ?>/scripts/jquery.number.js"></script>
</head>

<body>
<h1><?php echo $pageTitle; ?></h1>
<?php echo $contentForTemplate; ?>
</body>
</html>