<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<link rel="stylesheet" media="screen" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/register.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/global.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/custom-style.css">


<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
		<div class="inner cover">
			<div class="form-register">
				<div class="panel panel-default animated fadeInDown">
					<div class="panel-body">
						<div class="page-header"><h1><?php echo t('Site Registration')?></h1></div>


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

<!--<div class="form-group social-login">
	<a style="background-color:#3b5998" href="" class="btn btn-block btn-lg btn-facebook btn-block"><i class="fa fa-facebook-official" aria-hidden="true"></i>  ล็อกอินด้วย Facebook</a>
	<a style="background-color:#dd4b39" href="#" class="btn btn-block btn-lg btn-google btn-block"><i class="fa fa-google-plus" aria-hidden="true"></i>  ล็อกอินด้วย Google Plus</a>
</div>-->

<form method="post" action="<?php echo $this->url('/register', 'do_register')?>">
	
	<?php //if ($displayUserName) { ?>
		<div class="form-group">
			<!-- Remove username input -->
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
			<?php echo $captcha->label(); ?>
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

	<div class="text-center">ถ้าคุณเป็นสมาชิกอยู่แล้ว<a href="/login">คลิกที่นี่</a></div>
	
</form>
<?php } ?>



					</div><!--/.panel-body-->
				</div>
			</div><!--/.row-->
		</div><!--/.inner-->
		</div><!--/.cover-container-->
	</div><!--/.site-wrapper-inner-->
</div><!--/.site-wrapper-->


