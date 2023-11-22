<!doctype html>
<html lang="en" class="pink-theme">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="Akshay Waghe">

	<title>Lotus Pens</title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/') ?>images/Lotus_Logo.png">
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/') ?>lib/select_2/select2.css" />
	<script src="<?= base_url('assets/') ?>lib/js/jquery-3.6.4.min.js"></script>
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
				<!-- <li class="menu-item">
					<a type="button" class="mx-1 hover-fx p-0" style="border-radius:50%;text-decoration:none;height:20px;width:20px;color:black;font-size:22px;font-weight:500">
						<?= $this->session->userdata('currency_symbol') ?>
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
				</li> -->
				<a href="<?= base_url() ?>wishlist" class="hover-fx mx-1">
					<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
						<path d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z" />
					</svg>
				</a>
				<div class="shooping-cart-icon-top-bar">
					<a class="count" id="cart_items_count" style="text-decoration: none;" href="<?= base_url() ?>cart">0</a>
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
						<li class="level-one-item"><a href="<?= base_url() ?>about_a_us">About Us</a></li>
						<li class="level-one-item"><a href="#">Custom Pens</a>
							<ul class="menu-level-two">
								<li><label style="color:grey;font-size:13px">Custom Pens</label></li>
								<li><a href="<?= base_url() ?>/custom_hand_painted">Custom Hand Painted Fountain Pens</a></li>
								<li><a href="<?= base_url() ?>/custom_pens">Custom Fountain Pens</a></li>
							</ul>
						</li>
						<li class="level-one-item">
							<a href="<?= base_url() ?>products">Products</a>
						</li>
						<li class="level-one-item"><a href="#">Accessories</a></li>
						<li class="level-one-item"><a href="<?= base_url() ?>faqs">FAQs</a></li>
						<li class="level-one-item"><a href="<?= base_url() ?>contact_us">Contact Us</a></li>
						<li class="level-one-item"><a href="<?= base_url() ?>about_us">About Fountain Pens</a></li>

						<?php
						if ($this->session->userdata('is_user_login')) { ?>
							<li><a type="button" href="<?= base_url() ?>profile">Profile</a></li>
							<li><a type="button" href="<?= base_url() ?>orders">My Orders</a></li>
							<li><a type="button" onclick="logout()">Logout</a></li>
						<?php } else { ?>
							<li><a type="button" onclick="openLoginModal()">Login</a></li>
						<?php }
						?>

						<!-- <li class="level-one-item"><a href="#">Currency</a>
							<ul class="menu-level-two">
								<li><a type="button" onclick="changeCurrency('euro')">€ Euro</a></li>
								<li><a type="button" onclick="changeCurrency('pound')">£ Pound Sterling</a></li>
								<li><a type="button" onclick="changeCurrency('rupee')">₹ Rupee</a></li>
								<li><a type="button" onclick="changeCurrency('usd')">$ US Dollar</a></li>
							</ul>
						</li> -->
					</ul>
				</div>
			</div>
		</div>
		<div class="header-backdrop"></div>
	</div>



	<!-- Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="wrapper">
						<div class="title-text">
							<div class="title login">
								Login</div>
							<div class="title signup">
								Signup</div>
						</div>
						<div class="form-container">
							<div class="slide-controls shadow-lg">
								<input type="radio" name="slide" id="login" checked>
								<input type="radio" name="slide" id="signup">
								<label for="login" class="slide login">Login</label>
								<label for="signup" class="slide signup">Signup</label>
								<div class="slider-tab">
								</div>
							</div>
							<div class="form-inner">
								<form action="#" class="login p-2" id="login_form" class="">
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
											<a href="#" style="text-decoration: none;color:black">Forgot password?</a>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<input type="submit" value="Login" class="action-button">
										</div>
									</div>
									<div class="signup-link">
										Not a member? <a href="">Signup now</a></div>
									<div class="row">
										<div class="col text-center">
											<img src="http://localhost/lotus_pens/assets/images/Lotus_Logo.png" style="height: 70px;width:70px">
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
											<label for="signup_password">Passowrd</label>
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



	<!-- Modal -->
	<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<img src='' style="width: 100%;" id="quickViewImg">
				</div>
			</div>
		</div>
	</div>