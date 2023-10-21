<!doctype html>
<html lang="en" class="pink-theme">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="Akshay Waghe">

	<title>Lotus Pens</title>

	<style>
		.menu-item {
			display: inline-block;
			/* background-color: #4285f4; */
			position: relative;
		}

		.menu-item a {
			text-decoration: none;
			padding: 6px 10px;
			color: #fff;
			display: block;
		}

		.drop-menu {
			display: none;
			position: absolute;
			background-color: #fff;
			min-width: 150px;
			box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
		}

		.menu-item ul {
			padding: 0px !important;
		}

		.drop-menu-item {
			width: 100%;
		}

		.drop-menu-item:hover {
			background-color: #eee;
		}

		.drop-menu-item a {
			color: #555;
		}

		.menu-item:hover .drop-menu {
			display: block;
		}

		.shooping-cart-icon-top-bar {
			position: relative;
			display: block;
			width: 28px;
			height: 28px;
			height: auto;
			overflow: hidden;
		}

		.material-icons {
			position: relative;
			top: 4px;
			z-index: 1;
			font-size: 24px;
			color: white;
		}

		.count {
			position: absolute;
			top: 0;
			right: 0;
			z-index: 2;
			font-size: 11px;
			border-radius: 50%;
			background: #d60b28;
			width: 16px;
			height: 16px;
			line-height: 16px;
			display: block;
			text-align: center;
			color: white;
			font-family: 'Roboto', sans-serif;
			font-weight: bold;
		}
		}
	</style>
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
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/login_signup_modal.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body id="page_body">
	<input type="hidden" value="<?= base_url() ?>" id="base_url_input" />
	<input type="hidden" value="<?= $this->session->userdata('is_user_login') ?>" id="is_user_login" />
	<input type="hidden" value="<?= $this->session->userdata('currency_symbol') ?>" id="currency_symbol" />

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
				<li class="menu-item">
					<a type="button" class="mx-1">
						<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="100.000000pt" height="100.000000pt" viewBox="0 0 100.000000 100.000000" preserveAspectRatio="xMidYMid meet">

							<g transform="translate(0.000000,100.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
								<path d="M386 944 c-160 -39 -293 -175 -331 -339 -18 -77 -17 -120 4 -120 10
0 18 22 27 73 16 95 56 175 118 238 163 162 424 163 589 1 l52 -52 -50 -5
c-36 -4 -50 -9 -50 -20 0 -12 18 -16 88 -18 l88 -3 -3 88 c-2 70 -6 88 -18 88
-11 0 -16 -15 -20 -52 l-5 -53 -53 54 c-116 117 -271 160 -436 120z" />
								<path d="M415 871 c-210 -55 -335 -264 -280 -466 l17 -65 54 0 c87 0 123 -54
69 -105 l-26 -23 29 -21 c68 -48 123 -64 217 -65 123 0 188 25 271 108 99 99
135 230 99 361 l-17 65 -54 0 c-87 0 -123 54 -69 105 l26 23 -29 21 c-78 55
-222 85 -307 62z m180 -130 c48 -22 72 -48 58 -62 -7 -7 -26 -1 -59 16 -61 33
-117 30 -169 -9 -32 -25 -75 -91 -75 -115 0 -6 46 -11 113 -13 92 -2 112 -6
112 -18 0 -12 -21 -16 -117 -18 -109 -2 -118 -4 -118 -22 0 -18 9 -20 118 -22
96 -2 117 -6 117 -18 0 -12 -20 -16 -112 -18 -129 -3 -130 -4 -80 -78 57 -84
127 -104 212 -58 32 17 51 22 58 15 24 -24 -68 -80 -134 -81 -56 0 -133 44
-168 96 -16 25 -33 58 -36 74 -4 19 -14 30 -27 32 -29 4 -35 28 -9 35 27 7 27
39 0 46 -26 7 -20 31 9 35 13 2 23 13 27 32 12 54 63 117 117 144 61 30 108
32 163 7z" />
								<path d="M926 508 c-2 -7 -9 -42 -15 -77 -46 -277 -345 -429 -597 -306 -30 15
-78 50 -107 78 l-52 52 50 5 c36 4 50 9 50 20 0 12 -18 16 -88 18 l-88 3 3
-88 c2 -70 6 -88 18 -88 11 0 16 15 20 52 l5 53 53 -54 c116 -117 266 -159
431 -121 171 41 310 188 341 363 7 38 10 77 7 86 -8 19 -26 21 -31 4z" />
							</g>
						</svg>
					</a>
					<ul class="drop-menu">
						<li class="drop-menu-item">
							<a type="button" onclick="changeCurrency('euro')">€ Euro</a>
						</li>
						<li class="drop-menu-item">
							<a type="button" onclick="changeCurrency('pound')">£ Pound Sterling</a>
						</li>
						<li class="drop-menu-item">
							<a type="button" onclick="changeCurrency('rupee')">₹ Rupee</a>
						</li>
						<li class="drop-menu-item">
							<a type="button" onclick="changeCurrency('usd')">$ US Dollar</a>
						</li>
					</ul>
				</li>
				<a href="<?= base_url() ?>wishlist" class="hover-fx mx-1">
					<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
						<path d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z" />
					</svg>
				</a>
				<div class="shooping-cart-icon-top-bar">
					<span class="count" id="cart_items_count">0</span>
					<a href="<?= base_url() ?>cart" class="hover-fx mx-1 material-icons">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
							<g id="_01_align_center" data-name="01 align center">
								<path d="M24,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H0V2H1.222a1,1,0,0,1,.993.883L3.8,16.351A3,3,0,0,0,6.778,19H20V17H6.778a1,1,0,0,1-.993-.884L5.654,15H21.836ZM20.164,13H5.419L4.478,5H21.607Z" />
								<circle cx="7" cy="22" r="2" />
								<circle cx="17" cy="22" r="2" />
							</g>
						</svg>
					</a>
				</div>
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
						<?php
						if ($this->session->userdata('is_user_login')) { ?>
							<li><a type="button" onclick="logout()">Logout</a></li>
						<?php } else { ?>
							<li><a type="button" onclick="processToCheckout()">Login</a></li>
						<?php }
						?>

						<li class="level-one-item"><a href="#">Currency</a>
							<ul class="menu-level-two">
								<li><a type="button" onclick="changeCurrency('euro')">€ Euro</a></li>
								<li><a type="button" onclick="changeCurrency('pound')">£ Pound Sterling</a></li>
								<li><a type="button" onclick="changeCurrency('rupee')">₹ Rupee</a></li>
								<li><a type="button" onclick="changeCurrency('usd')">$ US Dollar</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="header-backdrop"></div>
	</div>