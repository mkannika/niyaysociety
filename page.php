<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

	<div class="template-page">
		<div class="container">
			<?php $a = new Area('Content'); $a->display($c); ?>
		</div>
	</div>

<?php $this->inc('elements/footer.php'); ?>
