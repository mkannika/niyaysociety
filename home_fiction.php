<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');

//Load helper
Loader::model('page_counter');
$ih = Loader::helper('image');
$nh = Loader::helper('navigation');
$th = Loader::helper('text');
$db = Loader::db();
$av = Loader::helper('concrete/avatar');
$iph = Loader::helper('validation/ip');
$datetime = Loader::helper('form/date_time');

global $u;

//Get story thumbnail
$img = $c->getAttribute('thumbnail');

//Get writer name
$original_author = Page::getByID($c->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

//Get avatar
$userID = $c->getCollectionUserID();
$pageOwner = UserInfo::getByID($userID);
$userOwner = $pageOwner->getUserName();
$uID = $u->getUserID();

$cID = $c->getCollectionID();

//Get Attribute
$status = $c->getAttribute('status');
$color = "";
if($status == 'ยังไม่จบ'){ $color = "#E74C3C"; }else if( $status == 'จบแล้ว' ){ $color = "#2ECC71"; }

//Get Category
$category = Page::getByID($c->getCollectionParentID());

$query_score = "SELECT * FROM `VoteScore` WHERE `cID` = $cID";
$row_score = $db->Execute($query_score);
$checkVoteScore = '';

if($row_score->RecordCount() > 0){
	$checkVoteScore = 'true';
} else {
	$checkVoteScore = 'false';
}

// Message for success
function successMsg($score){

	$scoreVoted = $score;

	$html = '';

	$html .=<<<EOS
	<div class="modal fade" id="actionStatus" tabindex="-1" role="dialog" aria-labelledby="actionStatus" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="alert alert-success" role="alert">
				<strong>ขอบคุณค่ะ!</strong> คุณได้โหวตให้เรื่องนี้ {$scoreVoted}  คะแนน
			</div>
		</div>
	</div>

	<script type="text/javascript">
	$(function() {
		$('#actionStatus').modal('show');
	});
	</script>
EOS;
	print_r($html);
}


// Message for error
function errorMsg(){

	$html = '';

	$html .=<<<EOS
			<div class="modal fade" id="actionStatus" tabindex="-1" role="dialog" aria-labelledby="actionStatus" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="alert alert-danger" role="alert">
						<strong>ขอโทษค่ะ!</strong> คุณโหวตเรื่องนี้ไปแล้ว คุณสามารถโหวตได้อีก 1 ชั่วโมงข้างหน้าค่ะ
					</div>
				</div>
			</div>

			<script type="text/javascript">
			$(function() {
				$('#actionStatus').modal('show');
			});
			</script>
EOS;
	print_r($html);

}

/**
 *
 * Form Ranking Submit
 *
 */

if(isset($_POST['submit'])){

	/**

		TODO:
		- Step 1. Check if VoteSystem table has data
		- Step 2. Check if timestamp isn't lower than an hour.
		- Step 3. Check if VoteScore table has page id

	 **/


	// Step 1. Check if VoteSystem table has data

	if( $u -> isLoggedIn () == true ):

	$query = "SELECT * FROM `VoteSystem` WHERE `uID` = $uID AND `cID` = $cID";
	$row = $db->Execute($query);

	if($row->RecordCount() > 0){

		// If database do has data
		$getLastTimeVoted = $db->GetOne("SELECT `timestamp` FROM `VoteSystem` WHERE `uID` = $uID AND `cID` = $cID");

		$nextHour = strtotime($getLastTimeVoted) + 3600;
		$currentTime = strtotime(date('Y-m-d H:i:s'));

		// Step 2. Check if timestamp isn't lower than an hour.
		if($currentTime >= $nextHour){

			//Update data of current page id. Set current `timestamp`
			$q = "UPDATE `VoteSystem` SET `timestamp` = now() WHERE `uID` = $uID AND `cID` = $cID";
			$db->Execute($q);

			//Step 3. Check if VoteScore table has page id
			if( $checkVoteScore == 'true' ){

				$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
				$total = $getScore + intval($_POST['vote']);

				$q = "UPDATE `VoteScore` SET `score` = $total WHERE `cID` = $cID";
				$db->Execute($q);
				successMsg($_POST['vote']);

			}else{

				$v = array( $cID, intval($_POST['vote']));
				$q = "INSERT INTO `VoteScore` (`cID`, `score`) VALUES (?, ?)";
				$db->Execute($q, $v);
				successMsg($_POST['vote']);

			}

			successMsg($_POST['vote']);

		}else{

			//Display error message.
			errorMsg();

		}


	} else {

		$v = array( $uID, $cID, $iph->getRequestIP());
		$q = "INSERT INTO `VoteSystem` (`uID`, `cID`, `ipAddress`) VALUES (?, ?, ?)";
		$db->Execute($q, $v);

		//Step 3. Check if VoteScore table has page id
		if( $checkVoteScore == 'true' ){

			$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
			$total = $getScore + intval($_POST['vote']);

			$q = "UPDATE `VoteScore` SET `score` = $total WHERE `cID` = $cID";
			$db->Execute($q);
			successMsg($_POST['vote']);

		}else{

			$v = array( $cID, intval($_POST['vote']));
			$q = "INSERT INTO `VoteScore` (`cID`, `score`) VALUES (?, ?)";
			$db->Execute($q, $v);
			successMsg($_POST['vote']);

		}

	}

	endif; //end check loggedin


}//end submit

?>

<?php
if ($img) {
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="' . $ih->getThumbnail($img, 380, 250, false)->src . '"></div>';
}else{
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="https://placehold.it/1170x340"></div>';
}
?>

<div id="story">
	<div class="story-page">
		<div class="container">
			<div class="cover-book">
				<a class="zoom" href="<?php echo $nh->getCollectionURL($c); ?>">
					<img src="<?php if ($img) { echo $ih->getThumbnail($img, 200, 303, true)->src; } else { echo 'https://placehold.it/200x303'; } ?>" alt="<?php echo $c->getCollectionName(); ?>">
				</a>
			</div>
			<div class="all-prop">
				<h1><?php echo $c->getCollectionName(); ?></h1>
			</div>
		</div>
		<div class="meta-story clearfix">
			<div class="container">
				<div class="meta-body pull-right">
					<div class="chapters">
						<div class="dropdown">
							<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								ตอนทั้งหมด
							<span class="caret"></span>
							</button>
							<?php
								$pl = new PageList();
								$pl->filterByParentID($c->getCollectionID());
								$pages = $pl->getPage();

								echo '<ul class="dropdown-menu" aria-labelledby="dLabel">';

									if(!empty($pages)){

									foreach ($pages as $page):

									$title = $th->entities($page->getCollectionName());
									$url = $nh->getLinkToCollection($page);
									$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
									$target = empty($target) ? '_self' : $target; ?>

									<li>
										<a href="<?php echo $url ?>" target="<?php echo $target; ?>"><?php echo $title; ?></a>
									</li>

									<?php endforeach;

									} else {
										echo '<li class="text-center">ยังไม่มีการเพิ่มตอน</li>';
									}

								echo '</ul>'; ?>
						</div>
					</div>
					<div class="meta meta-status">
						<span class="meta-label">สถานะ</span>
						<span class="meta-value" style="color: <?php echo $color; ?>;">
							<?php echo $c->getAttribute('status'); ?>
						</span>
					</div>
					<div class="meta meta-view">
						<span class="meta-label">ยอดคนอ่านทั้งหมด</span>
						<span class="meta-value"><?php echo PageCounter::getTotalPageViewsForPageID($c->cID); ?></span>
					</div>
					<div class="meta meta-cate">
						<span class="meta-label">หมวด</span>
						<span class="meta-value"><a href="<?php echo $nh->getCollectionURL($category); ?>"><?php echo $category->getCollectionName(); ?></a></span>
					</div>
				</div>
			</div>
		</div><!-- /.meta-story -->


		<div class="container">
			<div class="row">
				<main id="main" class="col-sm-8 col-md-9">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="page-header"><h2>อารัมภบท</h2></div>
							<div class="prologue">
								<div class="text-right">
									<!-- Social Share -->
									<div class="fb-share-button" data-href="<?php echo $nh->getCollectionURL($c); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fniyaysociety.com%2F&amp;src=sdkpreparse">Share</a></div>
								</div>
								<br>
								<?php
									$prologue = new Area('Add Prologue Text');
									$prologue->display($c);
								?>
								<div class="text-right">
									<!-- Social Share -->
									<div class="fb-share-button" data-href="<?php echo $nh->getCollectionURL($c); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fniyaysociety.com%2F&amp;src=sdkpreparse">Share</a></div>
								</div>
							</div>
						</div>
					</div>

					<div class="guestbook"><?php

						$a = new GlobalArea('Main Guest Book');
						$a->setBlockLimit(1);
						$a->display(); ?>

					</div>
				</main><!--/main-->

				<aside id="sidebar" class="col-sm-4 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="author">
								<?php
									if($pageOwner->hasAvatar()){
										$avatarImgPath = $av->getImagePath( $pageOwner, false );
										$mw = ($maxWidth) ? $maxWidth : '200';
										$mh = ($maxHeight) ? $maxHeight : '200';
										if( substr($avatarImgPath,0,strlen(DIR_REL))==DIR_REL ) $avatarImgPath=substr($avatarImgPath,strlen(DIR_REL));
										$thumb = $ih->getThumbnail( DIR_BASE.$avatarImgPath, $mw, $mh);
										if($thumb->src){
											ob_start();
											$ih->outputThumbnail(DIR_BASE.$avatarImgPath, $mw, $mh);
											$avatarHTML=ob_get_contents();
											ob_end_clean();
										}else{
											$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$userOwner.'" class="avatar" />';
										}
										echo '<a href="/profile/view/'.$userID.'" class="thumbnail zoom">'.$avatarHTML.'</a>';
									}else{
										echo '<img src="//www.gravatar.com/avatar/187ba321a8e8d19d1ac9bac9bad760b9?s=80&amp;d=mm&amp;r=g" alt="'.$userOwner.'">';
									}
								?>
							</div><!--/.author-->

							<div class="meta meta-penname text-center">
								<?php if($pageOwner->getAttribute('penname') != ""){ ?>
									<span class="label label-danger"><?php echo $pageOwner->getAttribute('penname'); ?></span>
								<?php } else { ?>
									<span class="label label-danger"><?php echo $original_author; ?></span>
								<?php } ?>
							</div><!--/.meta-penname-->

							<div class="meta meta-vote" style="margin-top:20px">
								<div id="ranking">
									<form method="post" action="/index.php?cID=<?php echo $c->getCollectionID(); ?>">
									<fieldset>
									<span class="star-cb-group">
										<input type="radio" name="vote" style="vertical-align: middle" value="5" id="rating-1"><label for="rating-1">1</label>
										<input type="radio" name="vote" style="vertical-align: middle" value="4" id="rating-2"><label for="rating-2">2</label>
										<input type="radio" name="vote" style="vertical-align: middle" value="3" id="rating-3"><label for="rating-3">3</label>
										<input type="radio" name="vote" style="vertical-align: middle" value="2" id="rating-4"><label for="rating-4">4</label>
										<input type="radio" name="vote" style="vertical-align: middle" value="1" id="rating-5"><label for="rating-5">5</label>
									</span>
									</fieldset>
									<?php if( $u -> isLoggedIn () == false ){ ?>

										<div class="alert alert-warning">คุณจะโหวตได้เมื่อ<a data-toggle="modal" data-target="#modalLogin">เข้าสู่ระบบ</a>ค่ะ</div>

									<?php } else { ?>
										<div class="buttons"><input class="btn btn-success btn-block" type="submit" name="submit" disabled="disabled" value="ให้คะแนนเรื่องนี้"></div>
									<?php } ?>
									</form>

									<div id="voteResults">
										<div class="scroll text-center">
										<?php
											$score = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");

											if($score){
												echo 'รวม '.$score.' คะแนน';
											}else{
												echo '0 คะแนน';
											}
										?>
										</div>
									</div>
								</div>
							</div><!--/.meta-vote-->

							<div class="recent-story">
								<h3>ผลงานเรื่องอื่นๆ</h3>
								<ul><?php
									$pl = new PageList();
									$pl->filterByUserID($userID);
									$pl->filterByCollectionTypeHandle('home_fiction');
									$pl->sortByPublicDateDescending('desc');
									$pages = $pl->getPage();
									$i = 1;
									$color = "";

									foreach ($pages as $page):

									$img = $page->getAttribute('thumbnail');
									$thumb = $ih->getThumbnail($img, 390, 250, true);
									$category = Page::getByID($page->getCollectionParentID());

									$title = $th->entities($page->getCollectionName());
									$url = $nh->getLinkToCollection($page);
									$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
									$target = empty($target) ? '_self' : $target;
									$status = $page->getAttribute('status');
									if($status == 'ยังไม่จบ'){

										$color = "#E74C3C";

									}else if( $status == 'จบแล้ว' ){

										$color = "#2ECC71";

									} ?>

									<li>
										<div class="title">
											<a href="<?php echo $url ?>" target="<?php echo $target; ?>"><?php echo $i++; ?>. <?php echo mb_substr( $title , 0, 50 ); ?>...</a>
										</div>
										<div class="meta meta-cat">
											หมวด<span><a href="<?php echo $nh->getCollectionURL($category); ?>"><?php echo $category->getCollectionName(); ?></a></span>
										</div>
										<div class="meta meta-status">
											สถานะ<span class="meta-value" style="color: <?php echo $color; ?>;"><?php echo $page->getAttribute('status'); ?></span>
										</div>
									</li>

									<?php endforeach; ?>
								</ul>
							</div><!--/.recent-story-->

						</div><!--/.panel-body-->
					</div><!--/.panel-->
				</aside><!--/aside-->
			</div>
		</div>
	</div>
</div>


<!--=================================
=            Login Modal            =
==================================-->

<!-- Load Helper Form Login -->
<?php
Loader::element('system_errors', array('error' => $error));
Loader::library('authentication/open_id');
$form = Loader::helper('form'); ?>
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
				<div class="form-group">
					<input type="password" class="form-control login-field" name="uPassword" id="uPassword" placeholder="Password" />
				</div>
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
			<div class="modal-footer">
				<div class="social-login">
					<a style="background-color:#3b5998;color:#fff;" href="#" class="btn btn-block btn-lg btn-facebook btn-block"><i class="fa fa-facebook-official" aria-hidden="true"></i>  ล็อกอินด้วย Facebook</a>
					<a style="background-color:#dd4b39;color:#fff;" href="#" class="btn btn-block btn-lg btn-google btn-block"><i class="fa fa-google-plus" aria-hidden="true"></i>  ล็อกอินด้วย Google Plus</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->inc('elements/footer.php'); ?>
