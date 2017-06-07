<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="header">

	<!-- Fixed navbar -->
	<nav class="navbar navbar-inverse animated navbar-burger" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="logo" href="http://niyaysociety.com">Niyay Society</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">นิยาย<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="https://niyaysociety.com/all-niyay/drama">ดราม่า</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/romantic">โรแมนติก</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/comedy">คอมเมดี้</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/erotic">อีโรติก</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/fantasy">แฟนตาซี</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/investigate">สืบสวนสอบสวน</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/action">ต่อสู้</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/y">นิยาย Y</a></li>
							<li><a href="https://niyaysociety.com/all-niyay/fanfic">แฟนฟิค</a></li>
						</ul>
					</li>
					<li><a href="https://niyaysociety.com/members">นักเขียน</a></li>
					<li><a href="https://blog.niyaysociety.com">บทความ</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="https://niyaysociety.com/login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;เข้าสู่ระบบ</a>
					</li>
					<li>
						<a href="https://niyaysociety.com/register">
							<span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>&nbsp;สมัครสมาชิก
						</a>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
</header><!--/#header-->


<div id="content" class="container">
