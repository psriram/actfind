<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle; ?></title>
<link rel="stylesheet" href="http://jqueryui.com/jquery-wp-content/themes/jquery/css/base.css?v=1">
<link rel="stylesheet" href="http://jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">
<link href="<?php echo HTTPPATH; ?>/styles/style.css" rel="stylesheet" type="text/css" />

</head>

<body class="jquery-ui search search-no-results listing single-author">
<!--jquery home page page-id-5 page-template page-template-page-fullwidth-php page-slug-index single-author singular-->
<header>
	<section id="global-nav">
		<nav>
			<div class="constrain">
				<ul class="projects">
					<li class=""><a href="#" title="">Project A</a></li>
					<li class=""><a href="#" title="">Project B</a></li>
					<li class=""><a href="#" title="">Project C</a></li>
				</ul>
				<ul class="links">
					<li><a href="#">Menu1</a></li>
					<li class="dropdown"><a href="#">Menu2</a>
						<ul>
							<li><a href="#">Submenu1</a></li>
							<li><a href="#">Submenu2</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</section>
</header>


<div id="container">
	<div id="logo-events" class="constrain clearfix">
		<h2 class="" id="htitle">Activity Finder</h2>

		<aside></aside>
	</div>

	<nav id="main" class="constrain clearfix">
		<div class="menu-top-container">
	<ul id="menu-top" class="menu">
    <li class="menu-item"><a href="/">Link 1</a></li>
    <li class="menu-item"><a href="/">Link 2</a></li>
    <li class="menu-item"><a href="/">Link 3</a></li>
    <li class="menu-item"><a href="/">Link 4</a></li>
	</ul>
</div>

		<form method="get" class="searchform" action="">
	<button type="submit" class="icon-search"><span class="visuallyhidden">search</span></button>
	<label>
		<span class="visuallyhidden">Search</span>
		<input type="text" name="s" value=""
			placeholder="Search...">
	</label>
</form>
	</nav>

	<div id="content-wrapper" class="clearfix row">

<div class="content-right twelve columns">
	<div id="content">

		<header class="page-header">
			<h1 class="page-title"><?php echo $pageTitle; ?></h1>
			<hr>
		</header>

				<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php echo !empty($subPageTitle) ? $subPageTitle : ''; ?></h1>
				</header>

				<div class="entry-content">
					<?php echo $contentForTemplate; ?>
				</div>
			</article>
			</div>

	<div id="sidebar" class="widget-area" role="complementary">
	<aside class="widget">
		<h3 class="widget-title">Side item 1</h3>
		<ul>
			<li><a href="#">side item 2</a></li>
		</ul>
	</aside>
	<aside class="widget">
		<h3 class="widget-title">Side item 2</h3>
		<ul>
			<li><a href="#">side item 3</a></li>
		</ul>
	</aside>
</div>
</div>

	</div>
</div>

<footer class="clearfix simple">
	<br /><br /><br /><br /><br /><br /><br /><br />
</footer>
</body>
</html>