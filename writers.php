<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>


<?php
$ih = Loader::helper('image');
$nh = Loader::helper('navigation'); 
?>
	
	<div class="all-members">
		<div class="container">
			<h2>สมาชิกในอาณาจักร</h2>
			<div class="row">
			<?php

					Loader::model('user_list');
					$av = Loader::helper('concrete/avatar');

					$userList = new UserList();
					$userList->sortBy('uID', 'desc'); 
					$users = $userList->get();

					//$count = 1;
					$name = "";

					foreach ($users as $user) { ?>

					<?php //if($count <= 12){ 

						if($user->getAttribute('penname') != "" ){
							$name = $user->getAttribute('penname');
						}else{
							$name = $user->getUserName();
						}
					?>

					<div class="member-list col-xs-3 col-sm-2">
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

					<?php //} $count++; ?>

				<?php }	?>
			</div>
		</div>
	</div>

<?php $this->inc('elements/footer.php'); ?>