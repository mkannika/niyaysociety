<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
global $u;
$av = Loader::helper('concrete/avatar');
$user = UserInfo::getByID($profile->getUserID());
$cover = $user->getAttribute('cover');


if ($cover) {
	$coverURL = $cover->getURL();
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="' . $coverURL . '"></div>';
}else{
	echo '<div class="cover-profile" data-parallax="scroll" data-image-src="http://placehold.it/1170x340"></div>';
}
?>

<div class="navbar-meta">
	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-9">
				<div class="chapters pull-left">
					<div class="dropdown">
						<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">นิยายที่แต่ง<span class="caret"></span></button>
						<?php
						echo '<ul class="dropdown-menu" aria-labelledby="dLabel">';
						$th = Loader::helper('text');
						$nh = Loader::helper('navigation');
						$page = Page::getByHandle('home_fiction');
						$pageID = $page->getCollectionID();
						$userID =  $profile->getUserID();
						$pl = new PageList();
						$pl->filterByUserID($userID);
						$pl->filterByCollectionTypeHandle('home_fiction');
						$pl->sortByPublicDateDescending('desc');
						$pages = $pl->getPage();
						if(!empty($pages)):
							foreach ($pages as $page):
								$title = $th->entities($page->getCollectionName());
								$url = $nh->getLinkToCollection($page);
								$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
								$target = empty($target) ? '_self' : $target;
								echo '<li><a href="'.$url.'">'.$title.'</a></li>';
							endforeach;
						else:
						echo '<li class="text-center">ยังไม่มีข้อมูล</li>';
						endif; echo '</ul>'; ?>
					</div>
				</div>
				<div class="meta meta-new-story pull-left">
					<a href="/dashboard/composer/write/"><i class="fa fa-pencil" aria-hidden="true"></i>สร้างผลงานใหม่</a>
				</div>
				<div class="meta meta-new-chapter pull-left">
					<a href="/dashboard/composer/write/"><i class="fa fa-file-text-o" aria-hidden="true"></i>เพิ่มตอนใหม่</a>
				</div>
				<div class="meta meta-dashboard pull-left">
					<a href="/dashboard/composer/drafts"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.navbar-default -->

<div class="container">
	<div class="row">
		<aside id="sidebar" class="col-sm-3">
			<div class="avatar"><?php
				//Load For Display Author
				$ih = Loader::helper('image');
				$av = Loader::helper('concrete/avatar');

				if($user->hasAvatar()){
					$avatarImgPath = $av->getImagePath( $profile, false );
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
						$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$profile->getUserName().'" />';
					}
					echo '<a class="thumbnail" href="/profile/view/'.$profile->getUserID().'">'.$avatarHTML.'</a>';
				}else{
					echo '<a class="thumbnail" href="/profile/view/'.$profile->getUserID().'"><img src="http://placehold.it/200x200" alt="'.$profile->getUserName().'" width="200" heoght="200"></a>';
				} ?>
			</div><!--/.avatar-->

			<h1 class="meta meta-name">
				<?php if($profile->getAttribute('penname') != ""): 
					echo '<a class="penname" href="/profile/view/'.$profile->getUserID().'">'.$user->getAttribute('penname').'</a>';
					echo '<div class="username">@<a href="/profile/view/'.$profile->getUserID().'">'.$profile->getUserName().'</a></div>'; ?>	
				<?php else: ?>
				<?php
					echo '<a class="penname" href="/profile/view/'.$profile->getUserID().'">'.$profile->getUserName().'</a>';
					echo '<div class="username">@<a href="/profile/view/'.$userID.'">'.$profile->getUserName().'</a></div>'; ?>	
				<?php endif; ?>
			</h1>

			<div class="meta meta-bio"><?php echo $user->getAttribute('description'); ?></div>

			<div class="meta social">
				<?php if($user->getAttribute('facebook') != ""): ?>
				<a class="btn btn-social" href="<?php echo $user->getAttribute('facebook'); ?>"><span class="fa fa-facebook"></span></a>
				<?php endif; ?>
				<?php if($user->getAttribute('twitter') != ""): ?>
				<a class="btn btn-social" href="<?php echo $user->getAttribute('twitter'); ?>"><span class="fa fa-twitter"></span></a>
				<?php endif; ?>
			</div>
			<?php Loader::element('profile/sidebar', array('profile'=> $profile)); ?>
		</aside><!--/aside-->

		<div id="content" class="col-sm-9">
			<h2><?php echo t('ผลงานของฉัน')?></h2>
			<div class="row">
			<?php 
			Loader::model('page_counter');
			$th = Loader::helper('text');
			$nh = Loader::helper('navigation');
			$page = Page::getByHandle('home_fiction');
			$pageID = $page->getCollectionID();
			$userID =  $profile->getUserID();
			$pl = new PageList();
			$pl->filterByUserID($userID);
			$pl->filterByCollectionTypeHandle('home_fiction');
			$pl->sortByPublicDateDescending('desc');
			$pages = $pl->getPage();

			foreach ($pages as $page):
				
				// Prepare data for each page being listed...
				$title = $th->entities($page->getCollectionName());
				$url = $nh->getLinkToCollection($page);
				$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
				$target = empty($target) ? '_self' : $target;
				$last_edited = $page->getCollectionDateLastModified('d.m.Y เวลา H:i น.');

				$img = $page->getAttribute('thumbnail');
				$thumb = $ih->getThumbnail($img, 290, 435, true);

				$color = "";
				$status = $page->getAttribute('status');
				if($status == 'ยังไม่จบ'){ $color = "#E74C3C"; }else if( $status == 'จบแล้ว' ){ $color = "#2ECC71"; }

				$category = Page::getByID($page->getCollectionParentID());

				?>

				<div class="listFiction col-md-3 col-sm-4 col-xs-4">
					<div class="cover displayThumbnail">
						<a href="<?php echo $url ?>" class="zoom"><img src="<?php if( $thumb->src != "" ) { echo $thumb->src; } else { echo 'http://placehold.it/290x435'; } ?>" alt="<?php echo $title ?>" /></a>
					</div>
					<h3 class="nameTitle"><a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo mb_substr( $title, 0, 50 ); ?></a></h3>
					<div class="well">
						<div class="meta meta-penname">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							<?php if($user->getAttribute('penname') != ""){ ?>
								<span><a href="/profile/view/<?php echo $userID; ?>">&nbsp;<?php echo $user->getAttribute('penname'); ?></a></span>
							<?php } else { ?>
								<span><a href="/profile/view/<?php echo $userID; ?>">&nbsp;<?php echo $userOwner; ?></a></span>
							<?php } ?>
						</div>
						<div class="meta meta-cat">
							<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
							<span class="meta-value">&nbsp;<a href="<?php echo $nh->getCollectionURL($category); ?>"><?php echo $category->getCollectionName(); ?></a></span>
						</div>
						<div class="meta mate-score">
							<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
							<span class="meta-value">&nbsp;<?php
								$db= Loader::db();
								$cID = $page->getCollectionID();
								$score = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");

								if($score){
									echo $score;
								}else{
									echo '0';
								}
							?>
								
							</span>
						</div>
						<div class="meta meta-view">
							<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
							<span class="meta-value">&nbsp;<?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?></span>
						</div>
						<div class="meta meta-update">
							<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
							<span class="meta-value">&nbsp;<?php echo $last_edited; ?></span>
						</div>
						<div class="meta meta-status">
							สถานะ : <span class="meta-value" style="color: <?php echo $color; ?>;">&nbsp;<?php echo $page->getAttribute('status'); ?></span>
						</div>
					</div>	
				</div>

			<?php endforeach;	?>
			</div>
		</div><!-- /#content -->
	</div><!-- /.row -->
</div><!-- /.container -->