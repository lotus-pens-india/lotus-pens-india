<!doctype html>
<html lang="en" class="pink-theme">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
	<?php if (isset($metaData)) { ?>
		<title><?= $metaData['title'] ?></title>
		<meta name="description" content="<?= $metaData['description'] ?>">
		<meta name="keywords" content="<?= $metaData['keywords'] ?>">
		<meta name="author" content="Lotus Writing Instruments">
		<meta name="publisher" content="Lotus Pens">
	<?php } else { ?>
		<title>Premium Quality Personalized Writing Instruments - Lotus Pens</title>
		<meta name="description" content="Discover exquisite custom hand-made pens at Lotus Pens. Our premium quality, personalized writing instruments are crafted with precision and elegance, perfect for collectors, professionals, and special gifts.">
		<meta name="keywords" content="Custom hand-made pens, Personalized writing pens, Premium quality pens, Luxury pens, Custom pens online, Handcrafted pens, Custom pens for gifts, High-quality writing instruments, Unique writing pens, Collectible pens, Luxury personalized pens, Handmade pens for sale, Best custom pens, Exclusive writing pens, Lotus Pens, Lotus Writing Instruments">
		<meta name="author" content="Lotus Writing Instruments">
		<meta name="publisher" content="Lotus Pens">
	<?php } ?>
	<meta name="robots" content="index">
	<link rel="icon" type="image/png" href="<?= base_url('assets/') ?>images/Lotus_Logo.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>lib/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>lib/slick/slick-theme.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/global.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/icons.css">
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/checkout.css">
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/cart.css">
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>css/login_signup_modal.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>lib/select_2/select2.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/premium.css">
	<script src="<?= base_url('assets/') ?>lib/js/jquery-3.6.4.min.js"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-BTTDEGQSZD"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-BTTDEGQSZD');
	</script>
</head>

<body id="page_body">
	<input type="hidden" value="<?= base_url() ?>" id="base_url_input">
	<input type="hidden" value="<?= $this->session->userdata('is_user_login') ?>" id="is_user_login">
	<input type="hidden" value="<?= $this->session->userdata('currency_symbol') ?>" id="currency_symbol">

	<header class="header lp-header">
		<nav class="navbar navbar-expand-lg lp-navbar">
			<a class="lp-brand" href="<?= base_url() ?>" aria-label="Lotus Pens home">
				<img src="<?= base_url('assets/') ?>images/Lotus_Logo.png" title="Lotus Pens" alt="Lotus Pens">
				<span class="lp-brand-copy">
					<span class="lp-brand-name">Lotus Pens</span>
					<span class="lp-brand-tagline">Writing Instruments</span>
				</span>
			</a>

			<div class="lp-mobile-actions">
				<a href="<?= base_url() ?>wishlist" class="lp-icon-btn" title="Wishlist" aria-label="Wishlist">
					<i class="fa fa-heart-o"></i>
				</a>
				<a href="<?= base_url() ?>cart" class="lp-icon-btn" title="Cart" aria-label="Cart">
					<i class="fa fa-shopping-bag"></i>
					<span class="lp-cart-count" id="cart_items_count_mobile">0</span>
				</a>
			</div>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#lotusNavbar" aria-controls="lotusNavbar" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fa fa-bars"></i>
			</button>

			<div class="collapse navbar-collapse" id="lotusNavbar">
				<ul class="navbar-nav lp-nav">
					<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>about_a_us">About Us</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="customPensMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Custom Pens</a>
						<ul class="dropdown-menu" aria-labelledby="customPensMenu">
							<li><a class="dropdown-item" href="<?= base_url() ?>custom_hand_painted">Custom Hand Painted Fountain Pens</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>products">Fountain Pens</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>products/4">Accessories</a></li>
						</ul>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>products">Shop</a></li>
					<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>faqs">FAQs</a></li>
					<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>contact_us">Contact Us</a></li>
					<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>about_us">About Fountain Pens</a></li>
					<?php if ($this->session->userdata('is_user_login')) { ?>
						<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>profile">Profile</a></li>
						<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>orders">My Orders</a></li>
					<?php } ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="currencyMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Currency</a>
						<ul class="dropdown-menu" aria-labelledby="currencyMenu">
							<li><a class="dropdown-item" type="button" onclick="changeCurrency('rupee')">INR Rupee</a></li>
							<li><a class="dropdown-item" type="button" onclick="changeCurrency('usd')">USD Dollar</a></li>
						</ul>
					</li>
					<?php if ($this->session->userdata('is_user_login')) { ?>
						<li class="nav-item"><a class="nav-link" type="button" onclick="logout()">Logout</a></li>
					<?php } else { ?>
						<li class="nav-item"><a class="nav-link" type="button" onclick="openLoginModal()">Login</a></li>
					<?php } ?>
				</ul>

				<div class="lp-actions">
					<div class="lp-search">
						<input type="text" placeholder="Search products" id="search_product_desktop" aria-label="Search products">
						<button type="button" data-search-submit title="Search" aria-label="Search"><i class="fa fa-search"></i></button>
					</div>
					<input type="hidden" id="search_product" value="">
					<a href="<?= base_url() ?>wishlist" class="lp-icon-btn d-none d-lg-inline-flex" title="Wishlist" aria-label="Wishlist">
						<i class="fa fa-heart-o"></i>
					</a>
					<a href="<?= base_url() ?>cart" class="lp-icon-btn d-none d-lg-inline-flex" title="Cart" aria-label="Cart">
						<i class="fa fa-shopping-bag"></i>
						<span class="lp-cart-count" id="cart_items_count">0</span>
					</a>
				</div>
			</div>
		</nav>
	</header>

	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="loginModalLabel">Lotus Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="wrapper">
						<div class="title-text">
							<div class="title login">Login</div>
							<div class="title signup">Signup</div>
						</div>
						<div class="form-container">
							<div class="slide-controls shadow-lg">
								<input type="radio" name="slide" id="login" checked>
								<input type="radio" name="slide" id="signup">
								<label for="login" class="slide login">Login</label>
								<label for="signup" class="slide signup">Signup</label>
								<div class="slider-tab"></div>
							</div>
							<div class="form-inner">
								<form action="#" class="login p-2" id="login_form">
									<div class="row">
										<div class="col-12">
											<label for="username">Username</label>
											<input type="text" placeholder="Email Address" required id="username">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<label for="password">Password</label>
											<input type="password" placeholder="Password" required id="password">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<a class="nav-link" href="#" style="text-decoration: none;color:black">Forgot password?</a>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<input type="submit" value="Login" class="action-button">
										</div>
									</div>
									<div class="signup-link">Not a member? <a class="nav-link" href="">Signup now</a></div>
									<div class="row">
										<div class="col text-center">
											<img src="<?= base_url('assets/') ?>images/Lotus_Logo.png" style="height: 70px;width:70px" title="Lotus Pens" alt="Lotus Pens">
										</div>
									</div>
								</form>
								<form class="signup p-2" id="signup_form">
									<div class="row">
										<div class="col-6">
											<label for="signup_firstname">First Name</label>
											<input type="text" required id="signup_firstname" name="signup_firstname">
										</div>
										<div class="col-6">
											<label for="signup_lastname">Last Name</label>
											<input type="text" required id="signup_lastname" name="signup_lastname">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<label for="signup_email">Email</label>
											<input type="email" id="signup_email" name="signup_email">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<label for="signup_mobile">Mobile</label>
											<input type="number" required id="signup_mobile" name="signup_mobile">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<label for="signup_username">Username</label>
											<input type="text" required id="signup_username" name="signup_username">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<label for="signup_password">Password</label>
											<input type="password" required id="signup_password" name="signup_password">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<input type="submit" value="Signup" class="action-button">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="quickViewModalLabel">Quick View</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<img src="" style="width: 100%;" id="quickViewImg" alt="Pen quick view" title="Pen quick view">
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
