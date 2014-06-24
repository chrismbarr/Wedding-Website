<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title>Chris And Kirstin</title>
		<meta name="description" content="Chris & Kirstin are geting married on July 19th! Read about how they met and all kinds of wedding details!">
		<meta property="og:title" content="Chris & Kirstin" />
		<meta property="og:description" content="Chris & Kirstin are geting married on July 19th! Read about how they met and all kinds of wedding details!" />
		<meta property="og:url" content="http://chrisandkirstin.com" />
		<meta property="og:image" content="http://chrisandkirstin.com/images/section-break1-sm.jpg" />

		<link rel="stylesheet" href="styles/site.css" />
		<!--[if IE]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="scripts/_libraries/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<header id="header">
			<div class="container clearfix">
				<h1 id="title">
					Chris <span id="title-amp">&amp;</span>
					<span id="title-line-two">Kirstin</span>
				</h1>
				<nav id="nav">
					<a href="#photo-break-1" class="hide"></a>
					<a href="#our-story">Our Story</a>
					<a href="#wedding-info">Wedding Info</a>
					<a href="#rsvp">RSVP</a>
					<a href="#registries">Registries</a>
					<a href="#photo-break-5" class="hide"></a>
				</nav>
			</div>
		</header>
		
		<section class="main-section photo-section" id="photo-break-1" data-stellar-background-ratio="0.2">
			<div id="scroll-helper" class="hidden-xs">
				<div id="scroll-helper-text">Scroll Down</div>
				<div class="scroll-helper-arrow"></div>
				<div class="scroll-helper-arrow"></div>
				<div class="scroll-helper-arrow"></div>
			</div>
			<img class="hide js-mobile-image" src="" />
		</section>

		<section class="main-section" id="our-story">
			<div class="container">
				<?php include_once('parts/our-story.php'); ?>
			</div>
		</section>

		<section class="main-section photo-section" id="photo-break-2" data-stellar-background-ratio="0.05">
			<img class="hide js-mobile-image" src="" />
		</section>

		<section class="main-section" id="wedding-info">
			<div class="container">
				<?php include_once('parts/wedding-info.php'); ?>
			</div>
		</section>

		<section class="main-section photo-section" id="photo-break-3" data-stellar-background-ratio="0.4">
			<img class="hide js-mobile-image" />
		</section>

		<section class="main-section" id="rsvp">
			<div class="container">
				<?php include_once('parts/rsvp.php'); ?>
			</div>
		</section>

		<section class="main-section photo-section" id="photo-break-4" data-stellar-background-ratio="0.2">
			<img class="hide js-mobile-image" src="" />
		</section>

		<section class="main-section" id="registries">
			<div class="container">
				<?php include_once('parts/registries.php'); ?>
			</div>
		</section>

		<section class="main-section photo-section" id="photo-break-5" data-stellar-background-ratio="0.1">
			<img class="hide js-mobile-image" src="" />
		</section>

		<section class="main-section" id="bottom-quote">
			<div class="container">
				<?php include_once('parts/quote.php'); ?>
			</div>
		</section>

		<div id="wedding-party-backdrop"></div>

		<?php include_once("parts/scripts.php"); ?>
	</body>
</html>