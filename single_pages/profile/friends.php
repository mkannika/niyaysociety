<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
global $u;
$user = UserInfo::getByID($u->getUserID());
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
						$userID =  $u->getUserID();
						$pl = new PageList();
						$pl->filterByUserID($userID);
						$pl->filterByCollectionTypeHandle('home_fiction');
						$pl->sortByPublicDateDescending('desc');
						$pages = $pl->getPage();
						foreach ($pages as $page):
							$title = $th->entities($page->getCollectionName());
							$url = $nh->getLinkToCollection($page);
							$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
							$target = empty($target) ? '_self' : $target;
							echo '<li><a href="'.$url.'">'.$title.'</a></li>';
						endforeach; echo '</ul>';?>
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
				$u = new User();
				$userID = $u->getUserID();
				$pageOwner = UserInfo::getByID($userID);
				$ih = Loader::helper('image');
				$av = Loader::helper('concrete/avatar');
				$userOwner = $pageOwner->getUserName();

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
						$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$userOwner.'" />';
					}
					echo '<a class="thumbnail" href="/profile/view/'.$userID.'">'.$avatarHTML.'</a>';
				}else{
					echo '<a class="thumbnail" href="/profile/view/'.$userID.'"><img src="http://placehold.it/200x200" alt="'.$userOwner.'" width="200" heoght="200"></a>';
				} ?>
			</div><!--/.avatar-->

			<h1 class="meta meta-name">
				<?php if($user->getAttribute('penname') != ""): 
					echo '<a class="penname" href="/profile/view/'.$userID.'">'.$user->getAttribute('penname').'</a>';
					echo '<div class="username">@<a href="/profile/view/'.$userID.'">'.$userOwner.'</a></div>'; ?>	
				<?php else: ?>
				<?php
					echo '<a class="penname" href="/profile/view/'.$userID.'">'.$userOwner.'</a>';
					echo '<div class="username">@<a href="/profile/view/'.$userID.'">'.$userOwner.'</a></div>'; ?>	
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
			<?php  Loader::element('profile/sidebar', array('profile'=> $profile)); ?>
		</aside><!--/aside-->

		<div id="content" class="col-sm-9">
			<h2><?php echo t('เพื่อนของฉัน')?></h2>

			<div id="ccm-profile-body"><?php
				$friendsData = UsersFriends::getUsersFriendsData( $profile->getUserID() );
				if (!$friendsData) { ?>
					<div style="padding:16px 0px;">
						<?php echo t('ยังไม่มีเพื่อน')?>
					</div>
				<?php
				}
				else {
					echo '<div class="row">';
					$dh = Loader::helper('date');
					/* @var $dh DateHelper */
					foreach($friendsData as $friendsData) {
						$friendUID = $friendsData['friendUID'];
						$friendUI = UserInfo::getById( $friendUID );
						if (!is_object($friendUI)) { ?>
							<div class="col-sm-4 col-xs-4">
								<div>
									<?php echo $av->outputNoAvatar()?>
								</div>
								<div >
									<?php echo t('Unknown User')?>
								</div>
							</div>
						<?php }
						else { ?>
							<div class="col-sm-4 col-xs-4">
								<div class="user-thumb">
									<a class="thumbnail" href="<?php echo View::url('/profile',$friendUID)?>"><?php echo $av->outputUserAvatar($friendUI)?>
										<div class="text-center">
											<?php if($friendUI->getAttribute('penname') != ""){
												echo $friendUI->getAttribute('penname');
											}else{
												echo $friendUI->getUsername();
											} ?>
										</div>
									</a>
								</div>
							</div>
						<?php }
					}
					echo '</div>';
				} ?>
			</div><!-- /#ccm-profile-body -->
		</div><!-- /#content -->
	</div><!-- /.row -->
</div><!-- /.container -->