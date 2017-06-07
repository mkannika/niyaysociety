<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="clear"></div>

<div id="agreement" class="text-center">
	<div class="container">
		<h3>ข้อตกลงในการใช้งาน </h3>
		<p>ข้อความทีท่านได้อ่านจาก เว็บเพจนี้ เกิดขึ้นจากการเขียนโดยสาธารณชน และ เผยแพร่โดยอัตโนมัติ ผู้ดูแลเว็บไซต์แห่งนี้ ไม่ได้เห็นด้วย และไม่ขอรับผิดชอบ ต่อข้อความใดๆทั้งสิ้น ดังนั้นผู้อ่านทุกท่าน โปรดใช้วิจารณญาณในการกลั่นกรองด้วยตนเอง และ ถ้าหากท่านพบเห็นข้อความใดๆ ที่ ขัดต่อกฎหมาย และ ศีลธรรม กรุณาแจ้งมาที่ webmasterเพื่อทีมงานจะได้ ดำเนินการในทันที ขอขอบพระคุณ</p>
	</div>
</div>

<div id="footer">
	<div class="container">
		<div id="footer-inner">
			<div class="row">
				<div class="col-sm-3 col-xs-4">
					<h3>นิยาย</h3>
					<ul class="main-menu">
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
				</div>
				<div class="col-sm-3 col-xs-4">
					<h3>เมนูทั่วไป</h3>
					<ul class="main-menu">
						<li><a href="/blog.niyaysociety.com">บทความ</a></li>
						<li><a href="/writers">นักเขียน</a></li>
						<li><a href="/profile">โปรไฟล์</a></li>
						<li><a href="/profile">นิยายของฉัน</a></li>
						<li><a href="/profile/friends">เพื่อนนักเขียน</a></li>
					</ul>
				</div>
				<div class="col-sm-3 col-xs-4">
					<h3>ความช่วยเหลือ</h3>
					<ul class="help-menu">
						<li><a href="/howto">วิธีเขียนนิยาย</a></li>
						<li><a href="/terms">ข้อตกลงในการใช้งาน</a></li>
						<li><a href="/sitemap">แผนผังเว็บไซต์</a></li>
						<li><a href="/privacy-policy">นโยบายความเป็นส่วนตัว</a></li>
					</ul>
				</div>
				<div class="col-sm-3 col-xs-12">
					<h3>ติดต่อเรา</h3>
					<ul class="contact">
						<li><a href="/about-us">เกี่ยวกับเรา</a></li>
						<li><a href="/contact-us">ติดต่อเรา</a></li>
					</ul>
					<address>
						<strong>ทีมงานเว็บไซต์นิยายโซไซตี้ดอทคอม</strong><br>
						<a href="mailto:webmaster@niyaysociety.com">webmaster@niyaysociety.com</a>
						<div class="social-area">
							<a class="btn btn-social btn-facebook btn-simple" href="#">
								<span class="fa fa-facebook"></span>
							</a>
							<a class="btn btn-social btn-twitter btn-simple" href="">
								<span class="fa fa-twitter"></span>
							</a>
							<a class="btn btn-social btn-google-plus btn-simple" href="">
								<span class="fa fa-google"></span>
							</a>
						</div>
					</address>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">&copy;<?php echo date('Y')?> <?php echo h(SITE)?>. Powered by <a href="https://www.concrete5.org/" target="_blank">Concrete5</a></div>
</div>
<!-- Script Require //-->


<!-- Loading specific script -->
<script src="<?php echo $this->getThemePath(); ?>/js/apps.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->getThemePath(); ?>/js/script.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	if($(".listFiction").length){
		$(".listFiction .nameTitle").matchHeight();
		$(".listFiction .well").matchHeight();
		$(".listFiction .displayThumbnail").matchHeight();
	}
});
</script>
<?php if($c->getCollectionName() == "Avatar"): ?>
<script src="<?php echo $this->getThemePath(); ?>/js/jquery.cropit.js" type="text/javascript"></script>
<?php endif; ?>

<!-- Profile Edit -->
<?php if($c->getCollectionName() == "Edit"): ?>
<link rel="stylesheet" type="text/css" href="/concrete/css/jquery.ui.css">
<script src="/concrete/js/bootstrap.js" type="text/javascript"></script>
<script src="/concrete/js/jquery.ui.js" type="text/javascript"></script>
<script src="/concrete/js/jquery.form.js" type="text/javascript"></script>
<script src="/concrete/js/jquery.rating.js" type="text/javascript"></script>
<?php endif; ?>

<!-- Homepage -->
<?php //if( $c->getCollectionHandle() == 'home'): ?>
<script src="/themes/niyaysociety/js/bootstrap-show-password.js"></script>
<?php //endif; ?>

<?php if( $c->getCollectionHandle() == 'home'): ?>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.slides').slick({
			autoplay: true,
			arrows:false,
			fade:true,
			speed: 2000,
			ease: 'cubic-bezier(.94,.64,.51,.94)'
		});
	});
</script>
<?php endif; ?>

<!-- Facebook Sharing -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1866929160193121";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php  Loader::element('footer_required'); ?>
</body>
</html>
