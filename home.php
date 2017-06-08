<?php require($_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php');  ?>
<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');
?>

<div id="main" class="<?php echo $c->getCollectionTypeHandle(); ?>">
	<div id="content" class="container">
		<div id="topVote" class="listView">
			<h2><a href="#">นิยายที่ได้รับการโหวตสูงสุด</a></h2>
			<div class="displayTopVote row">

<?php
Loader::model('page_counter');
$th = Loader::helper('text');
$ih = Loader::helper('image');
$nh = Loader::helper('navigation');
$date = Loader::helper("date");
$db = Loader::db();

$pages = $db->query("SELECT * FROM `VoteScore` ORDER BY score DESC");

$i = 0;

?>
<?php foreach ($pages as $page):

		if($i != 8):

		//Get Page ID
		$getID = $page['cID'];
		$intTopID = (int)$getID;
		$pageTop = Page::getByID($intTopID);

		// Prepare data for each page being listed...
		$title = $th->entities($pageTop->getCollectionName());
		$url = $nh->getLinkToCollection($pageTop);
		$target = ($pageTop->getCollectionPointerExternalLink() != '' && $pageTop->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $pageTop->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$last_edited = $pageTop->getCollectionDateLastModified('d.m.Y เวลา H:i น.');
		$original_author = Page::getByID($pageTop->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

		$img = $pageTop->getAttribute('thumbnail');
		$thumb = $ih->getThumbnail($img, 290, 435, true);

		$category = Page::getByID($pageTop->getCollectionParentID());

		$userID = $pageTop->getCollectionUserID();
		$pageOwner = UserInfo::getByID($userID);

		$color = "";
		$status = $pageTop->getAttribute('status');
		if($status == 'ยังไม่จบ'){ $color = "#E74C3C"; }else if( $status == 'จบแล้ว' ){ $color = "#2ECC71"; }


		?>

		<div class="listFiction col-sm-3 col-md-2 col-xs-4">
			<div class="cover displayThumbnail">
				<a href="<?php echo $url ?>" class="zoom"><img src="<?php if( $thumb->src != "" ) { echo $thumb->src; } else { echo 'http://placehold.it/290x435'; } ?>" alt="<?php echo $title ?>" /></a>
			</div>
			<h3 class="nameTitle"><a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo mb_substr( $title, 0, 50 ); if(mb_strlen($title)>50) echo '...'; ?></a></h3>
			<div class="well">
				<div class="meta meta-penname">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<?php if($pageOwner->getAttribute('penname') != ""){ ?>
						<span><a href="/profile/view/<?php echo $userID; ?>"><?php echo $pageOwner->getAttribute('penname'); ?></a></span>
					<?php } else { ?>
						<span><a href="/profile/view/<?php echo $userID; ?>"><?php echo $original_author; ?></a></span>
					<?php } ?>
				</div>
				<div class="meta meta-cat">
					<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
					<span class="meta-value"><a href="<?php echo $nh->getCollectionURL($category); ?>"><?php echo $category->getCollectionName(); ?></a></span>
				</div>
				<div class="meta mate-score">
					<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
					<span class="meta-value"><?php
						$db= Loader::db();
						$cID = $pageTop->getCollectionID();
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
					<span class="meta-value"><?php echo PageCounter::getTotalPageViewsForPageID($pageTop->cID); ?></span>
				</div>
				<div class="meta meta-update">
					<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
					<span class="meta-value"><?php echo $last_edited; ?></span>
				</div>
				<div class="meta meta-status">
					สถานะ : <span class="meta-value" style="color: <?php echo $color; ?>;"><?php echo $pageTop->getAttribute('status'); ?></span>
				</div>
			</div>
		</div>

	<?php $i++; endif; endforeach; ?>
			</div>
		</div>

		<div id="lastUpdate" class="listView">
			<h2><a href="/all-niyay">นิยายอัพเดพล่าสุด</a></h2>
			<div class="displaynewFiction">
				<?php //$a = new Area('Last Update'); $a->display($c); ?>
				<?php

					$count = 0;
					$date = Loader::helper("date");
					$page_id = Page::getByID(128);
					$sub_page_ids = $page_id->getCollectionChildrenArray(1);
					$pl = new PageList();
					$pl->filterByParentID($sub_page_ids);
					$pl->sortBy('cvDateCreated', 'desc');
					$pages = $pl->getPage();
				?>

				<div class="row ccm-page-list">
					<?php foreach ($pages as $page):

						if($count != 12):

						$title = $th->entities($page->getCollectionName());
						$url = $nh->getLinkToCollection($page);
						$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
						$target = empty($target) ? '_self' : $target;
						$description = $page->getCollectionDescription();
						$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
						$description = $th->entities($description);

						$img = $page->getAttribute('thumbnail');
						$thumb = $ih->getThumbnail($img, 290, 435, true);

						//Other useful page data...
						$date = Loader::helper('date')->formatDate($page->getCollectionDatePublic(), true);
						$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();
						$last_edited = $page->getCollectionDateLastModified('d.m.Y เวลา H:i น.');
						$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
						$category = Page::getByID($page->getCollectionParentID());

						$userID = $page->getCollectionUserID();
						$pageOwner = UserInfo::getByID($userID);

						$color = "";
						$status = $page->getAttribute('status');
						if($status == 'ยังไม่จบ'){ $color = "#E74C3C"; }else if( $status == 'จบแล้ว' ){ $color = "#2ECC71"; }

						$category = Page::getByID($page->getCollectionParentID()); ?>

						<div class="listFiction col-sm-3 col-md-2 col-xs-4">
							<div class="cover displayThumbnail">
								<a href="<?php echo $url ?>" class="zoom"><img src="<?php if( $thumb->src != "" ) { echo $thumb->src; } else { echo 'http://placehold.it/290x435'; } ?>" alt="<?php echo $title ?>" /></a>
							</div>
							<h3 class="nameTitle"><a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo mb_substr( $title, 0, 30 ); if(mb_strlen($title)>30) echo '...'; ?></a></h3>
							<div class="well">
								<div class="meta meta-penname">
									<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
									<?php if($pageOwner->getAttribute('penname') != ""){ ?>
										<span><a href="/profile/view/<?php echo $userID; ?>">&nbsp;<?php echo $pageOwner->getAttribute('penname'); ?></a></span>
									<?php } else { ?>
										<span><a href="/profile/view/<?php echo $userID; ?>">&nbsp;<?php echo $original_author; ?></a></span>
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

					<?php $count++; endif; endforeach; ?>
				</div><!-- end .ccm-page-list -->
			</div>
		</div>

		<div id="newFiction" class="listView">
			<h2><a href="#">นิยายมาใหม่</a></h2>
			<div class="displaynewFiction">
				<?php $a = new Area('New'); $a->display($c); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h2><a href="/members">นักเขียน</a></h2>

				<div id="members" class="row">

				<?php

					Loader::model('user_list');
					$av = Loader::helper('concrete/avatar');

					$userList = new UserList();
					$userList->sortBy('uID', 'desc');
					$users = $userList->get();

					$count = 1;
					$name = "";

					foreach ($users as $user) { ?>

					<?php if($count <= 12){

						if($user->getAttribute('penname') != "" ){
							$name = $user->getAttribute('penname');
						}else{
							$name = $user->getUserName();
						}
					?>

					<div class="member-list col-xs-4 col-sm-3">
						<div class="member-avatar">
							<?php if($user->hasAvatar()){
								$avatarImgPath = $av->getImagePath( $user, false );
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
									$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$user->getUserName().'" class="avatar" />';
								}
								echo '<a href="/profile/view/'.$user->getUserID().'" class="zoom">'.$avatarHTML.'<div class="overlay">'.$name.'</div></a>';
							}else{
								echo '<a href="/profile/view/'.$user->getUserID().'" class="zoom"><img src="//www.gravatar.com/avatar/187ba321a8e8d19d1ac9bac9bad760b9?s=200&amp;d=mm&amp;r=g" alt="'.$user->getUserName().'"><div class="overlay">'.$name.'</div></a>';
							} ?>
						</div>
					</div>

					<?php } $count++; ?>

				<?php }	?>

				</div><!--/#members-->
			</div>

			<div id="blog" class="col-md-6">
				<h2><a href="#">บทความใหม่</a></h2>
				<?php //echo file_get_contents('https://blog.niyaysociety.com/blog'); ?>
				<?php

				$args = array(
					'paged' => $paged,
					'post_type' => 'post',
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' => 3
				);

				$wp_query = new WP_Query($args);

				while ($wp_query -> have_posts()): $wp_query -> the_post(); ?>

				<div class="blog-list row">
					<div class="col-md-4">
						<!--<a title="<?php echo the_title(); ?>" href="<?php echo get_permalink(); ?>" class="thumnail zoom">
							<?php echo get_the_post_thumbnail( $post->ID, 'blog-thumbnail'); ?>
						</a>-->
					</div>
					<div class="col-md-8">
						<div class="col-md-12">
							<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php //the_excerpt(); ?></p>
							<div class="meta-update clearfix">
								<div class="public-time pull-left label label-default">เมื่อ: <?php the_time('j F Y');?></div>
								<div class="auther-name pull-right label label-success"><?php echo get_the_author(); ?></div>
							</div>
						</div>
					</div>
				</div>

				<?php endwhile; ?>
			</div><!--/#blog-->
		</div>

	</div><!--/.container-->
</div><!--/#main-->

<?php $this->inc('elements/footer.php'); ?>
