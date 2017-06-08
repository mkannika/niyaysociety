<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
	$this->addHeaderItem('<meta name="viewport" content="width=device-width, initial-scale=1">');
	$this->addHeaderItem('<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">');
	$this->addHeaderItem('<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/global.css">');
	$this->addHeaderItem('<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/cover.css">');
	$this->addHeaderItem('<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/custom-style.css">');
?>

<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
			<div class="inner cover">
				<div class="error-template text-center">
					<h1 class="error">404</h1>
					<h2 class="error-desc">Page Not Found</h2>
					<div class="error-actions">
						<a href="/" class="btn btn-success btn-lg">กลับไปหน้าหลัก</a>
						<a href="/results" class="btn btn-default btn-lg">ไปที่หน้าค้นหา</a>
					</div>
				</div>
			</div><!--/.inner-->
		</div><!--/.cover-container-->
	</div><!--/.site-wrapper-inner-->
</div><!--/.site-wrapper-->

<?php /*if (is_object($c)) { ?>
	<br/><br/>
	<?php $a = new Area("Main"); $a->display($c); ?>
<?php }*/ ?>