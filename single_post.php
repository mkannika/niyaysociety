<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');

//Load helper
Loader::model('page_counter');
$ih = Loader::helper('image');
$nh = Loader::helper('navigation');
$th = Loader::helper('text');

//Get story thumbnail
$parentID = Page::getByID($c->getCollectionParentID());
$img = $parentID->getAttribute('thumbnail');

//Get writer name
//$original_author = Page::getByID($parentID->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

//Get avatar
$userID = $parentID->getCollectionUserID();
$pageOwner = UserInfo::getByID($userID);
$av = Loader::helper('concrete/avatar');
$userOwner = $pageOwner->getUserName();

//Get Attribute
$status = $parentID->getAttribute('status');
$color = "";
if($status == 'ยังไม่จบ'){ $color = "#E74C3C"; }else if( $status == 'จบแล้ว' ){ $color = "#2ECC71"; }

//Get Category
$category = Page::getByID($parentID->getCollectionParentID());
?>

<?php
if ($img) {
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="' . $ih->getThumbnail($img, 380, 250, false)->src . '"></div>';
}else{
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="http://placehold.it/1170x340"></div>';
}
?>

<div id="story">
	<div class="story-page">
		<div class="container">
			<div class="cover-book">
				<a class="zoom" href="<?php echo $nh->getCollectionURL($parentID); ?>">
					<img src="<?php if ($img) { echo $ih->getThumbnail($img, 200, 303, true)->src; } else { echo 'http://placehold.it/200x303'; } ?>" alt="<?php echo $parentID->getCollectionName(); ?>">	
				</a>
			</div>
			<div class="all-prop">
				<h1><?php echo $parentID->getCollectionName(); ?></h1>
				<div class="author">ผู้แต่ง 
				<?php if($pageOwner->getAttribute('penname') != ""){ ?>
				<?php echo '<a href="/profile/view/'.$userID.'">'.$pageOwner->getAttribute('penname').'</a>'; ?>
				<? }else{ ?>
				<?php echo '<a href="/profile/view/'.$userID.'">'.$userOwner.'</a>'; ?>
				<?php } ?>
				</div>
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
								$pl->filterByParentID($c->getCollectionParentID());
								$pages = $pl->getPage();

								if($pages != ""){
								echo '<ul class="dropdown-menu" aria-labelledby="dLabel">';

								foreach ($pages as $page):

								$title = $th->entities($page->getCollectionName());
								$url = $nh->getLinkToCollection($page);
								$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
								$target = empty($target) ? '_self' : $target; ?>

								<li>
									<a href="<?php echo $url ?>" target="<?php echo $target; ?>"><?php echo $title; ?></a>
								</li>

								<?php endforeach; ?>

								<?php echo '</ul>'; ?>

							<?php } else { ?>
								<p>ยังไม่มีการเพิ่มตอน</p>
							<?php } ?>
						</div>
					</div>
					<div class="meta meta-status">
						<span class="meta-label">สถานะ</span>
						<span class="meta-value" style="color: <?php echo $color; ?>;">
							<?php echo $parentID->getAttribute('status'); ?>
						</span>
					</div>
					<div class="meta meta-view">
						<span class="meta-label">ยอดคนอ่านตอนนี้</span>
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

				<main class="col-xs-12">
					<article id="single-<?php echo $c->getCollectionID(); ?>" class="single-post">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="text-right">
									<!-- Social Share -->
									<div class="fb-share-button" data-href="<?php echo $nh->getCollectionURL($c); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fniyaysociety.com%2F&amp;src=sdkpreparse">Share</a></div>
								</div>
								<div class="post-story">
									<?php
										$a = new Area('Main');
										$a->display($c);
									?>
								</div>
								<div class="text-right">
									<!-- Social Share -->
									<div class="fb-share-button" data-href="<?php echo $nh->getCollectionURL($c); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fniyaysociety.com%2F&amp;src=sdkpreparse">Share</a></div>
								</div>
							</div>
						</div>
					</article><!--/.single-post-->

					<div class="text-center">
						<?php $a = new GlobalArea('Add Next & Previous Bottom'); $a->display(); ?>
					</div>

					<div class="guestbook">
						<?php
							$a = new GlobalArea('Guest Book');
							$a->setBlockLimit(1);
							$a->display();
						?>
					</div><!--/.guestbook-->
				</main><!--/main-->

			</div>
		</div>
	</div>
</div>

<?php $this->inc('elements/footer.php'); ?>
