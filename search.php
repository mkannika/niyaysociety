<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<div id="main">
	<div class="search container">
		<h2 class="page-header">ผลการค้นหา</h2>
		<div class="alert alert-warning">
			ระบบค้นหาข้อมูล<br>ท่านสามารถค้นหาข้อมูลได้ทั้งหน้าเว็บ ไม่ว่าจะเป็นนิยาย บทความ ตลอดจนค้นหาสมาชิกในเว็บไซต์ เพียงท่านระบุคำค้นหาที่เกี่ยวข้อง หรือคำ keyword เช่น บุญรัตน์, แวมไพร์, แม่มด หรืออื่นๆ ระบบจะทำการค้นหาและแสดงข้อมูลมาให้ท่านที่ข้างล่างนี้
		</div>
		<div class="text-center"><? $a = new Area('Search'); $a->display($c); ?></div>
	</div>
</div>

<?php $this->inc('elements/footer.php'); ?>