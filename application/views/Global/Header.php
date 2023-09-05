<!doctype html>
<html lang="en" class="pink-theme">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="Akshay Waghe">

	<title>Lotus Pens</title>

	<!-- Material design icons CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/gofruit/') ?>vendor/materializeicon/material-icons.css">
	<!-- Material design icons CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Roboto fonts CSS -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?= base_url('assets/') ?>lib/css/bootstrap-5.2.3.min.css" />

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>lib/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>lib/slick/slick-theme.css" />

	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/global.css" />
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css" />
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/icons.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/checkout.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/cart.css" />

</head>

<body>
	<div class="header">
		<div class="header-wrapper">
			<div class="logo-wrapper">
				<a href="<?= base_url() ?>"><img src="<?= base_url('assets/') ?>images/Lotus_Logo.png" /></a>
			</div>
			<div class="icons-wrapper">
				<div class="search-bar">
					<svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="512" height="512">
						<path d="M23.707,22.293l-5.969-5.969a10.016,10.016,0,1,0-1.414,1.414l5.969,5.969a1,1,0,0,0,1.414-1.414ZM10,18a8,8,0,1,1,8-8A8.009,8.009,0,0,1,10,18Z" />
					</svg>
					<input type="text" placeholder="Search Products" />
				</div>
				<a href="cart" class="hover-fx mx-1">
					<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
						<path d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z" />
					</svg>
				</a>
				<a href="cart" class="hover-fx mx-1">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
						<g id="_01_align_center" data-name="01 align center">
							<path d="M24,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H0V2H1.222a1,1,0,0,1,.993.883L3.8,16.351A3,3,0,0,0,6.778,19H20V17H6.778a1,1,0,0,1-.993-.884L5.654,15H21.836ZM20.164,13H5.419L4.478,5H21.607Z" />
							<circle cx="7" cy="22" r="2" />
							<circle cx="17" cy="22" r="2" />
						</g>
					</svg>
				</a>
				<a class="hover-fx mx-1">
					<svg class="menu-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 490.667 490.667" style="enable-background: new 0 0 490.667 490.667" xml:space="preserve" width="512" height="512">
						<g>
							<path d="M469.333,224h-448C9.551,224,0,233.551,0,245.333c0,11.782,9.551,21.333,21.333,21.333h448   c11.782,0,21.333-9.551,21.333-21.333C490.667,233.551,481.115,224,469.333,224z" />
							<path d="M21.333,117.333h448c11.782,0,21.333-9.551,21.333-21.333s-9.551-21.333-21.333-21.333h-448C9.551,74.667,0,84.218,0,96   S9.551,117.333,21.333,117.333z" />
							<path d="M469.333,373.333h-448C9.551,373.333,0,382.885,0,394.667C0,406.449,9.551,416,21.333,416h448   c11.782,0,21.333-9.551,21.333-21.333C490.667,382.885,481.115,373.333,469.333,373.333z" />
						</g>
					</svg>
				</a>
			</div>
			<div class="menu-wrapper">
				<div class="container">
					<ul class="menu-level-one">
						<li class="level-one-item"><a href="#">About Us</a></li>
						<li class="level-one-item"><a href="#">Custom Pens</a></li>
						<li class="level-one-item">
							<a href="#">Products</a>
							<ul class="menu-level-two">
								<li><a href="#">About Us</a></li>
								<li><a href="#">Custom Pens</a></li>
								<li><a href="#">Products</a></li>
								<li><a href="#">Accessories</a></li>
								<li><a href="#">FAQs</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Currency</a></li>
							</ul>
						</li>
						<li class="level-one-item"><a href="#">Accessories</a></li>
						<li class="level-one-item"><a href="#">FAQs</a></li>
						<li class="level-one-item"><a href="#">Contact Us</a></li>
						<li class="level-one-item"><a href="#">Currency</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="header-backdrop"></div>
	</div>