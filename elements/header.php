<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php
			$nh = Loader::helper('navigation');
			$ih = Loader::helper('image');
			$ak_url = $nh->getCollectionURL($c);;
			$ak_title = $c->getCollectionName();
			$akd = $c->getCollectionAttributeValue('meta_description');
			$akk = $c->getCollectionAttributeValue('meta_keywords');
			$ak_img = $c->getAttribute('thumbnail');
			$thumb = $ih->getThumbnail($ak_img, 290, 435, true);
			$ak_img_url = $thumb->src;
			if(($ak_img_url == '') && ($c->getCollectionHandle() != 'single_post')){

				$ak_img_url = '/themes/niyaysociety/img/niyaysociety_thumb_share.png';

			}

		?>

		<!-- SEO content -->
		<meta property="og:url" content="<?php echo $ak_url; ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?php echo $ak_title; ?> :: อาณาจักรคนรักนิยาย" />
		<meta property="og:description" content="<?php echo $akd;  ?>" />
		<meta property="og:image:width" content="200"/>
		<meta property="og:image:height" content="303"/>
		<meta property="og:image" content="https://niyaysociety.com<?php echo $ak_img_url; ?>" />

		<!-- Latest compiled and minified CSS -->
		<link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans|Roboto" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->getThemePath(); ?>/css/global.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->getThemePath(); ?>/css/custom-style.css">

		<?php if( $c->getCollectionHandle() == 'home'): ?>
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
		<?php endif; ?>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<?php Loader::element('header_required'); ?>

		<!-- Load Helper Form Login -->
		<?php
		Loader::element('system_errors', array('error' => $error));
		Loader::library('authentication/open_id');
		$form = Loader::helper('form'); ?>

		<?php if( $c->getCollectionHandle() == 'home'): ?>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#header .navbar[role='navigation']").hide();
					$("#header .navbar[role='navigation']").addClass('navbar-fixed-top');

					$(window).scroll(function() {
						if($(window).scrollTop() > 300) {
							$("#header .navbar[role='navigation']").removeClass('fadeOutUp').addClass('fadeInDown').fadeIn();
						}else{
							$("#header .navbar[role='navigation']").removeClass('fadeInDown').addClass('fadeOutUp');
						}
					});

					$(".slides").height($(window).height());
					$(window).resize(function() {
						$(".slides").height($(window).height());
					});

				});
			</script>
		<?php endif; ?>

	</head>
<body class="<?php echo $c->getCollectionTypeHandle(); ?>">
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
				<a class="logo" href="/">Niyay Society</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">นิยาย<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/all-niyay/drama">ดราม่า</a></li>
							<li><a href="/all-niyay/romantic">โรแมนติก</a></li>
							<li><a href="/all-niyay/comedy">คอมเมดี้</a></li>
							<li><a href="/all-niyay/erotic">อีโรติก</a></li>
							<li><a href="/all-niyay/fantasy">แฟนตาซี</a></li>
							<li><a href="/all-niyay/investigate">สืบสวนสอบสวน</a></li>
							<li><a href="/all-niyay/action">ต่อสู้</a></li>
							<li><a href="/all-niyay/y">นิยาย Y</a></li>
							<li><a href="/all-niyay/fanfic">แฟนฟิค</a></li>
						</ul>
					</li>
					<li><a href="/writers">นักเขียน</a></li>
					<li><a href="https://blog.niyaysociety.com">บทความ</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					$u = new User();
					$username = $c->getVersionObject()->getVersionAuthorUserName();
					$ui = UserInfo::getByUserName($username);
					$ih = Loader::helper('image');

					if ($u->isRegistered()) {

						if (Config::get("ENABLE_USER_PROFILES")) {
							$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
						} else {
							$userName = $u->getUserName();
						} ?>

					<li class="login-msg">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?php echo t('สวัสดีคุณ <b>%s</b>', $userName)?>
					</li>
					<li>
						<a href="<?php echo $this->url('/login', 'logout')?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;<?php echo t('ออกจากระบบ')?>
						</a>
					</li><?php

					} else {  ?>

					<li>
						<a data-toggle="modal" data-target="#modalLogin"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;<?php echo t('เข้าสู่ระบบ')?></a>
					</li>
					<li>
						<a data-toggle="modal" data-target="#modalRegister">
							<span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>
							&nbsp;<?php echo t('สมัครสมาชิก')?>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>

	<?php if( $c->getCollectionHandle() == 'home'): ?>
	<!--begin bg-carousel-->
	<div id="bg-fade-carousel" class="carousel">
		<div class="slides">
			<div class="slide1"></div>
			<div class="slide2"></div>
			<div class="slide3"></div>
		</div>
		<div class="overlay"></div>

		<div class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-xs-6">
						<a href="/" class="logo">Niyay Society</a>
					</div>
					<div class="col-xs-6"><?php
						$u = new User();
						$username = $c->getVersionObject()->getVersionAuthorUserName();
						$ui = UserInfo::getByUserName($username);
						$ih = Loader::helper('image');

						if ($u->isRegistered()) {

							if (Config::get("ENABLE_USER_PROFILES")) {
								$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
							} else {
								$userName = $u->getUserName();
							} ?>

						<div class="sign-in text-right">
							<span><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?php echo t('สวัสดีคุณ <b>%s</b>', $userName)?></span>
							<span><a href="<?php echo $this->url('/login', 'logout')?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;<?php echo t('ออกจากระบบ')?></a></span>
						</div><?php

						} else {  ?>

						<div class="sign-in text-right">
							<span><a data-toggle="modal" data-target="#modalLogin"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;<?php echo t('เข้าสู่ระบบ')?></a></span>
							<span><a data-toggle="modal" data-target="#modalRegister"><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>&nbsp;<?php echo t('สมัครสมาชิก')?></a></span>
						</div>

						<?php } ?>

					</div><!--/.col-md-6-->
				</div>
			</div><!--/.container-->
		</div><!--/.row-header-->

		<div class="container carousel-overlay text-center">
			<h1>ค้นหานิยายน่าอ่าน</h1>
			<p class="lead">แหล่งอ่านนิยายออนไลน์ที่ทันสมัย อ่านง่าย อ่านสบายทุกอุปกรณ์</p>
			<div class="text-center">
				<? $a = new Area('Search'); $a->display($c); ?>
			</div>

			<div class="text-center">
				<a class="btn btn-lg btn-success" <?php if( $u -> isLoggedIn () == false){echo 'data-toggle="modal" data-target="#modalLogin"';}else{echo 'href="/index.php/dashboard/composer/write/"';}?>><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;สร้างผลงานใหม่</a>
				<a class="btn btn-lg btn-success" <?php if( $u -> isLoggedIn () == false){echo 'data-toggle="modal" data-target="#modalLogin"';}else{echo 'href="/index.php/dashboard/composer/write/"';}?>><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;เพิ่มเนื้อหา</a>
			</div>
		</div>
	</div><!-- .carousel -->
	<!--end bg-carousel-->
	<?php endif; ?>
</header><!--/#header-->

<?php //if( $c->getCollectionHandle() == 'home'): ?>

<!--=================================
=            Login Modal            =
==================================-->

<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">เข้าสู่ระบบ</h4>
			</div>
			<div class="modal-body">

			<?php if( $u -> isLoggedIn () == false ){ ?>
			<form method="post" action="<?php echo $this->url('/login', 'do_login')?>">
				<div class="form-group">
					<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="<?php if (USER_REGISTRATION_WITH_EMAIL_ADDRESS == true) { ?><?php echo t('Email Address')?><?php } else { ?><?php echo t('Username')?><?php } ?>" name="uName" id="uName" <?php echo (isset($uName)?'value="'.$uName.'"':'');?> />
				</div>
				<input type="password" class="form-control" name="uPassword" id="uPassword" placeholder="Password" data-toggle="password" data-placement="after" />
				<div class="checkbox">
					<label class="checkbox"><input type="checkbox" class="ccm-input-checkbox" name="uMaintainLogin" id="uMaintainLogin" value="1" data-toggle="checkbox" checked="checked"><span><?php echo t('จำฉันไว้ในระบบ')?></span></label>
				</div>

				<div class="action form-group">
					<?php echo $form->submit('submit', t('ล็อกอิน'), array('class' => 'btn btn-success btn-lg btn-block'))?>
				</div>
				<div class="clearfix">
					<a data-toggle="modal" data-target="#forgetPass" class="pull-left">ลืมรหัสผ่าน?</a>
					<a data-toggle="modal" data-target="#modalRegister" class="pull-right">สมัครสมาชิก</a>
				</div>
			</form>
			<?php	}  ?>
			</div>
			<!--<div class="modal-footer">
				<div class="social-login">
					<a style="background-color:#3b5998;color:#fff;" href="#" class="btn btn-block btn-lg btn-facebook btn-block"><i class="fa fa-facebook-official" aria-hidden="true"></i>  ล็อกอินด้วย Facebook</a>
					<a style="background-color:#dd4b39;color:#fff;" href="#" class="btn btn-block btn-lg btn-google btn-block"><i class="fa fa-google-plus" aria-hidden="true"></i>  ล็อกอินด้วย Google Plus</a>
				</div>
			</div>-->
		</div>
	</div>
</div>


<!--====  End of Login Modal  ====-->


<!--===========================================
=            Forgot Password Modal            =
============================================-->

<div class="modal fade" id="forgetPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">ลืมรหัสผ่าน?</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo $this->url('/login', 'forgot_password'); ?>" class="ccm-forgot-password-form">
					<div class="alert alert-warning img-rounded">
						<?php echo t('ลืมรหัสผ่าน?'); ?><br>
						<?php echo t("กรอกอีเมล์ของท่าน ระบบส่งจะลิ้งค์ไปยังอีเมล์ของท่านเพื่อตั้งรหัสผ่านใหม่"); ?>
					</div>
					<input type="hidden" name="rcID" value="<?php echo $rcID; ?>" />
					<div class="form-group">
						<input type="text" name="uEmail" placeholder="Email Address" value="" class="ccm-input-text form-control">
					</div>
					<div class="actions">
						<?php echo $form->submit('submit', t('Reset and Email Password'), array('class' => 'btn btn-success btn-lg btn-block')); ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--====  End of Forgot Password Modal  ====-->


<!--====================================
=            Register Modal            =
=====================================-->

<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">สมัครสมาชิก</h4>
			</div>

			<!-- modal-body -->
			<div class="modal-body">

<?php
$attribs = UserAttributeKey::getRegistrationList();

if($success) { ?>

<?php	switch($success) {
		case "registered":
			?>
			<p><strong><?php echo $successMsg ?></strong><br/><br/>
			<a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></p>
			<?php
		break;
		case "validate":
			?>
			<p><?php echo $successMsg[0] ?></p>
			<p><?php echo $successMsg[1] ?></p>
			<p><a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></p>
			<?php
		break;
		case "pending":
			?>
			<p><?php echo $successMsg ?></p>
			<p><a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></p>
            <?php
		break;
	} ?>

<?php
} else { ?>

<div class="form-group social-login">
	<!--<a style="background-color:#3b5998;color:#fff;" href="" class="btn btn-block btn-lg btn-facebook btn-block"><i class="fa fa-facebook-official" aria-hidden="true"></i>  ล็อกอินด้วย Facebook</a>
	<a style="background-color:#dd4b39;color:#fff;" href="#" class="btn btn-block btn-lg btn-google btn-block"><i class="fa fa-google-plus" aria-hidden="true"></i>  ล็อกอินด้วย Google Plus</a>-->
</div>

<form method="post" action="<?php echo $this->url('/register', 'do_register')?>">

	<?php //if ($displayUserName) { ?>
		<div class="form-group">
			<?php echo $form->text('uName' , array('class' => 'form-control', 'placeholder' => 'Username')); ?>
			<?php //echo $form->hidden('uName', uniqid()); ?>
			<?php //echo $form->label('uName',t('Username')); ?>
		</div>
	<?php //} ?>

	<div class="form-group">
		<?php echo $form->text('uEmail', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
	</div>
	<div class="form-group">
		<?php echo $form->password('uPassword', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
	</div>
	<div class="form-group">
		<?php echo $form->password('uPasswordConfirm', array('class' => 'form-control', 'placeholder' => 'Password Confirm')); ?>
	</div>

<?php if (count($attribs) > 0) { ?>

	<div class="checkbox">
	<legend><?php echo t('Options')?></legend>
	<?php

	$af = Loader::helper('form/attribute');

	foreach($attribs as $ak) { ?>
			<?php echo $af->display($ak, $ak->isAttributeKeyRequiredOnRegister());	?>
	<?php }?>
	</div>

<?php } ?>

	<?php if (ENABLE_REGISTRATION_CAPTCHA) { ?>

		<div class="form-group">
			<?php $captcha = Loader::helper('validation/captcha'); ?>
			<?php
		  	  $captcha->showInput();
			  $captcha->display();
		  	?>
		</div>


	<?php } ?>

	<div class="form-group">
	<?php echo $form->hidden('rcID', $rcID); ?>
	<?php echo $form->submit('register', t('สมัครสมาชิก'), array('class' => 'btn btn-success btn-lg btn-block'))?>
	</div>

	<div class="text-center">ถ้าคุณเป็นสมาชิกอยู่แล้ว<a data-toggle="modal" data-target="#modalLogin">คลิกที่นี่</a></div>

</form>
<?php } ?>

			</div><!-- /modal-body -->
		</div>
	</div>
</div>

<!--====  End of Register Modal  ====-->

<?php //endif; ?>
