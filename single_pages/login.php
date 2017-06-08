<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php $this->addHeaderItem('<meta name="viewport" content="width=device-width, initial-scale=1">'); ?>

<link rel="stylesheet" media="screen" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/login.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/global.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/custom-style.css">

<?php Loader::library('authentication/open_id');?>
<?php $form = Loader::helper('form'); ?>
<script type="text/javascript">
$(function() {
	$("input[name=uName]").focus();
});
</script>

<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
			<div class="inner cover">
			<div class="form-signin">
				<div class="panel panel-default animated fadeInDown">
				<div class="panel-body">



<?php if (isset($intro_msg)) { ?>
<div class="alert-message block-message success"><p><?php echo $intro_msg?></p></div>
<?php } ?>

<?php if( $passwordChanged ){ ?>

	<div class="block-message info alert-message"><p><?php echo t('Password changed.  Please login to continue. ') ?></p></div>

<?php } ?> 

<?php if($changePasswordForm){ ?>

	<div class="page-header"><h1>Reset Password</h1></div>
	<div class="alert alert-warning"><?php echo t('Enter your new password below.') ?></div>
	<form id="reset-password" method="post" action="<?php echo $this->url( '/login', 'change_password', $uHash )?>"> 

		<div class="form-group">
			<input type="password" name="uPassword" placeholder="<?php echo t('New Password')?>" id="uPassword" class="ccm-input-text">
		</div>

		<div class="form-group">
			<input type="password" name="uPasswordConfirm" placeholder="<?php echo t('Confirm Password')?>" id="uPasswordConfirm" class="ccm-input-text">
		</div>

		<?php echo $form->submit('submit', t('Sign In'), array('class' => 'btn btn-success btn-lg btn-block'))?>
	</form>


<?php }elseif($validated) { ?>

<div class="page-header"><h1>Email Address Verified</h1></div>

<div class="success alert-message block-message">
<p>
<?php echo t('The email address <b>%s</b> has been verified and you are now a fully validated member of this website.', $uEmail)?>
</p>
<div class="alert-actions"><a class="btn small" href="<?php echo $this->url('/')?>"><?php echo t('Continue to Site')?></a></div>
</div>


<?php } else if (isset($_SESSION['uOpenIDError']) && isset($_SESSION['uOpenIDRequested'])) { ?>

<div class="ccm-form">

<?php switch($_SESSION['uOpenIDError']) {
	case OpenIDAuth::E_REGISTRATION_EMAIL_INCOMPLETE: ?>

		<form method="post" action="<?php echo $this->url('/login', 'complete_openid_email')?>">
			<p><?php echo t('To complete the signup process, you must provide a valid email address.')?></p>
			<div class="form-group">
				<label for="uEmail"><?php echo t('Email Address')?></label><br/>
				<?php echo $form->text('uEmail')?>
			</div>
			<div class="form-group">
			<?php echo $form->submit('submit', t('Sign In'), array('class' => 'btn btn-success btn-lg btn-block'))?>
			</div>
		</form>

	<?php break;
	case OpenIDAuth::E_REGISTRATION_EMAIL_EXISTS:
	
	$ui = UserInfo::getByID($_SESSION['uOpenIDExistingUser']);
	
	?>

		<div class="page-header"><h1>Login</h1></div>
		<form method="post" action="<?php echo $this->url('/login', 'do_login')?>">
			<p><?php echo t('The OpenID account returned an email address already registered on this site. To join this OpenID to the existing user account, login below:')?></p>
			<label for="uEmail"><?php echo t('Email Address')?></label><br/>
			<div><strong><?php echo $ui->getUserEmail()?></strong></div>
			<br/>
			
			<div>
			<label for="uName"><?php if (USER_REGISTRATION_WITH_EMAIL_ADDRESS == true) { ?>
				<?php echo t('Email Address')?>
			<?php } else { ?>
				<?php echo t('Username')?>
			<?php } ?></label><br/>
			<input type="text" name="uName" id="uName" <?php echo (isset($uName)?'value="'.$uName.'"':'');?> class="ccm-input-text">
			</div>			<div>

			<label for="uPassword"><?php echo t('Password')?></label><br/>
			<input type="password" name="uPassword" id="uPassword" class="ccm-input-text">
			</div>

			<div class="ccm-button">
			<?php echo $form->submit('submit', t('Sign In') . ' &gt;', array('class' => 'btn btn-success btn-lg btn-block'))?>
			</div>
		</form>

	<?php break;

	}
?>

</div>

<?php } else if ($invalidRegistrationFields == true) { ?>

<p><?php echo t('You must provide the following information before you may login.')?></p>
	
<form method="post" action="<?php echo $this->url('/login', 'do_login')?>">
	<?php 
	$attribs = UserAttributeKey::getRegistrationList();
	$af = Loader::helper('form/attribute');
	
	$i = 0;
	foreach($unfilledAttributes as $ak) { 
		if ($i > 0) { 
			print '<br/><br/>';
		}
		print $af->display($ak, $ak->isAttributeKeyRequiredOnRegister());	
		$i++;
	}
	?>
	
	<?php echo $form->hidden('uName', Loader::helper('text')->entities($_POST['uName']))?>
	<?php echo $form->hidden('uPassword', Loader::helper('text')->entities($_POST['uPassword']))?>
	<?php echo $form->hidden('uOpenID', $uOpenID)?>
	<?php echo $form->hidden('completePartialProfile', true)?>

	<div class="ccm-button">
		<?php echo $form->submit('submit', t('Sign In'))?>
		<?php echo $form->hidden('rcID', $rcID); ?>
	</div>
	
</form>	

<?php } else { ?>

<div class="page-header"><h1>Login</h1></div>
<form id="loginForm" method="post" action="<?php echo $this->url('/login', 'do_login')?>">
	<div class="form-group">
		<input type="text" class="form-control login-field" placeholder="<?php if (USER_REGISTRATION_WITH_EMAIL_ADDRESS == true) { ?><?php echo t('Email Address')?><?php } else { ?><?php echo t('Username')?><?php } ?>" name="uName" id="uName" <?php echo (isset($uName)?'value="'.$uName.'"':'');?> />
	</div>

	<input type="password" class="form-control" name="uPassword" id="uPassword" placeholder="Password" data-toggle="password" data-placement="after" />
	
	<div class="checkbox">
		<label><input type="checkbox" name="uMaintainLogin" id="uMaintainLogin" value="1"><?php echo t('จำฉันไว้ในระบบ')?></label>
	</div>

	<div class="action form-group">
		<?php echo $form->submit('submit', t('ล็อกอิน'), array('class' => 'btn btn-success btn-lg btn-block'))?>
	</div>

	<?php if (isset($locales) && is_array($locales) && count($locales) > 0) { ?>
		<div class="form-group">
			<label for="USER_LOCALE" class="control-label"><?php echo t('Language')?></label>
			<div class="form-control"><?php echo $form->select('USER_LOCALE', $locales)?></div>
		</div>
	<?php } ?>

	<?php $rcID = isset($_REQUEST['rcID']) ? Loader::helper('text')->entities($_REQUEST['rcID']) : $rcID; ?>
	<input type="hidden" name="rcID" value="<?php echo $rcID?>" />

	<div class="clearfix">
		<a data-toggle="modal" data-target="#forgetPass" class="pull-left">ลืมรหัสผ่าน?</a>
		<a href="/register" class="pull-right">สมัครสมาชิก</a>
	</div>

<?php if (OpenIDAuth::isEnabled()) { ?>
	<fieldset>
	<legend><?php echo t('OpenID')?></legend>

	<div class="form-group">
		<label for="uOpenID" class="control-label"><?php echo t('Login with OpenID')?>:</label>
		<div class="form-control">
			<input type="text" name="uOpenID" id="uOpenID" <?php echo (isset($uOpenID)?'value="'.$uOpenID.'"':'');?> class="ccm-input-openid">
		</div>
	</div>
	</fieldset>
<?php } ?>

</form><!--/#loginForm-->
<a name="forgot_password"></a>

<?php } ?>



				</div>
				</div>
			</div>
			</div><!--/.inner-->
		</div><!--/.cover-container-->
	</div><!--/.site-wrapper-inner-->
</div><!--/.site-wrapper-->


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
					<?php echo $form->submit('submit', t('Reset and Email Password'), array('class' => 'btn btn-success btn-lg btn-block')); ?>
				</form>
			</div>
		</div>
	</div>
</div>

<!--====  End of Forgot Password Modal  ====-->


<!--====  End of Register Modal  ====-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/themes/niyaysociety/js/bootstrap-show-password.js"></script>
<script type="text/javascript">
	(function ($) {
		$('.alert-error').addClass('animated fadeIn');


		var modalUniqueClass = ".modal";
		$('.modal').on('show.bs.modal', function(e) {
		  var $element = $(this);
		  var $uniques = $(modalUniqueClass + ':visible').not($(this));
		  if ($uniques.length) {
			$uniques.modal('hide');
			$uniques.one('hidden.bs.modal', function(e) {
			  $element.modal('show');
			});
			return false;
		  }
		});
	})(jQuery);
</script>