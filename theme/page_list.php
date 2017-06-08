<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<div class="container">
	<?php $a = new Area('Title'); $a->display($c); ?>
	<?php
		$a = new Area('Pagelist');
		$a->display($c);
	?>
</div>

<?php $this->inc('elements/footer.php'); ?>
