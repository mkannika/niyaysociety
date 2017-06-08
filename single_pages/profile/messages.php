<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Loader::helper('date');
/* @var $dh DateHelper */
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
			<?php  Loader::element('profile/sidebar', array('profile'=> $ui)); ?>
		</aside><!--/aside-->

		<div id="content" class="col-sm-9">
			<h2><?php echo t('ข้อความส่วนตัว')?></h2>

			<div class="private-messages">
			<?php echo $error->output(); ?>
			<?php switch($this->controller->getTask()) { 
				case 'view_message': ?>

				<div><a href="<?php echo $this->url('/profile/messages', 'view_mailbox', $box)?>">&lt;&lt; <?php echo t('Back to Mailbox')?></a></div><br/>
				
				<h1><?php echo t('Message Details')?></h1>
				<form method="post" action="<?php echo $this->action('reply', $box, $msg->getMessageID())?>">
				<div class="ccm-profile-detail">
					<div class="ccm-profile-section">
						<div class="table-responsive">
							<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top" class="ccm-profile-message-from"><a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
								<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>

								</td>
								<td valign="top">
									<h2><?php echo $subject?></h2>
									<div><?php echo $dateAdded?></div>
								</td>
							</tr>
							</table>
						</div>
					</div>
					
					<?php echo $msg->getFormattedMessageBody()?>
				</div>
				<div class="ccm-profile-buttons">
					<?php if ($msg->getMessageAuthorID() != $ui->getUserID()) { ?>
						<?php 
						$mui = $msg->getMessageRelevantUserObject();
						if (is_object($mui)) { 
							if ($mui->getUserProfilePrivateMessagesEnabled()) { ?>
								<?php echo $form->submit('button_submit', t('Reply'))?>
							<?php } 
							
						}?>
					<?php } ?>
					<?php echo $form->submit('button_delete', t('Delete'), array('onclick' => 'if(confirm(\'' . t('Delete this message?') . '\')) { window.location.href=\'' . $deleteURL . '\'}; return false'))?>
					<?php echo $form->submit('button_cancel', t('Back'), array('onclick' => 'window.location.href=\'' . $backURL . '\'; return false'))?>
				</div>
				</form>
							
				
				<?php 
					break;
				case 'view_mailbox': ?>
				
				<div><a href="<?php echo $this->url('/profile/messages')?>">&lt;&lt; <?php echo t('Back to Mailbox List')?></a></div><br/>
				<div class="pagelist-author table-responsive">
					<table class="table table-condensed">
					<tr>
						<th><?php if ($mailbox == 'sent') { ?><?php echo t('To')?><?php } else { ?><?php echo t('From')?><?php } ?></th>
						<th><?php echo t('Subject')?></th>
						<th><?php echo t('Sent At')?></th>
						<th><?php echo t('Status')?></th>
					</tr>
					
					
					
					<?php
						if (is_array($messages)) { 
							foreach($messages as $msg) { ?>
							
							<tr>
								<td class="ccm-profile-message-from">
								<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
								<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>
								</td>
								<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->url('/profile/messages', 'view_message', $mailbox, $msg->getMessageID())?>"><?php echo $msg->getFormattedMessageSubject()?></a></td>
								<td style="white-space: nowrap"><?php echo $dh->formatDateTime($msg->getMessageDateAdded(), true, false)?></td>
								<td><?php echo $msg->getMessageStatus()?></td>
							</tr>
							
							
					
						<?php } ?>
					<?php } else { ?>
						<tr>
							<Td colspan="4"><?php echo t('No messages found.')?></td>
						</tr>
					<?php } ?>
					</table>
				</div>
				
				
				<?php

					$messageList->displayPaging();
					break;
				case 'reply_complete': ?>
				
				<h2><?php echo t('Reply Sent.')?></h2>
				<a href="<?php echo $this->url('/profile/messages', 'view_message', $box, $msgID)?>"><?php echo t('Return to Message.')?></a>
				
				<?php
					break;
				case 'send_complete': ?>
				
				<h2><?php echo t('Message Sent.')?></h2>
				<a href="<?php echo $this->url('/profile', 'view', $recipient->getUserID())?>"><?php echo t('Return to Profile.')?></a>
				
				<?php
					break;
				case 'over_limit': ?>
					<h2><?php echo t('Woops!')?></h2>
					<p><?php echo t("You've sent more messages than we can handle just now, that last one didn't go out. 
					We've notified an administrator to check into this. 
					Please wait a few minutes before sending a new message."); ?></p>
					<?php break; 
				case 'send':
				case 'reply':
				case 'write': ?>

				<div id="ccm-profile-message-compose">
					<form method="post" action="<?php echo $this->action('send')?>">
					
					<?php echo $form->hidden("uID", $recipient->getUserID())?>
					<?php if ($this->controller->getTask() == 'reply') { ?>
						<?php echo $form->hidden("msgID", $msgID)?>
						<?php echo $form->hidden("box", $box)?>
					<?php 
						$subject = t('Re: %s', $text->entities($msgSubject));
					} else {
						$subject = $text->entities($msgSubject);
					}
					?>
					
					<h1><?php echo t('Send a Private Message')?></h1>
					
					<div class="ccm-profile-section">
						<label><?php echo t('To')?></label>
						<div><?php echo $recipient->getUserName()?></div>
					</div>
					
					<div class="ccm-profile-detail">
						<div class="ccm-profile-section">
							<?php echo $form->label('subject', t('Subject'))?>
							<div><?php echo $form->text('msgSubject', $subject)?></div>
						</div>
						
						<div class="ccm-profile-section-bare">
							<?php echo $form->label('body', t('Message'))?> <span class="ccm-required">*</span>
							<div><?php echo $form->textarea('msgBody', $msgBody)?></div>
						</div>
					</div>
					
					<div class="ccm-profile-buttons">
						<?php echo $form->submit('button_submit', t('Send Message'))?>
						<?php echo $form->submit('button_cancel', t('Cancel'), array('onclick' => 'window.location.href=\'' . $backURL . '\'; return false'))?>
					</div>
					
					<?php echo $vt->output('validate_send_message');?>
					
					</form>
					
				</div>                  
				
				
				<?php break; 
				
				default: 
					// the inbox and sent box and other controls ?>
				<div class="pagelist-author table-responsive">
					<table class="table table-condensed">
					<tr>
						<th><?php echo t('Mailbox')?></th>
						<th><?php echo t('Messages')?></th>
						<th><?php echo t('Latest Message')?></th>
					</tr>
					<tr>
						<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->action('view_mailbox', 'inbox')?>"><?php echo t('Inbox')?></a></td>
						<td><?php echo $inbox->getTotalMessages()?></td>
						<td class="ccm-profile-mailbox-last-message"><?php
						$msg = $inbox->getLastMessageObject();
						if (is_object($msg)) {
							print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true, false));
						}
						?></td>
					</tr>
					<tr>
						<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->action('view_mailbox', 'sent')?>"><?php echo t('Sent Messages')?></a></td>
						<td><?php echo $sent->getTotalMessages()?></td>
						<td class="ccm-profile-mailbox-last-message"><?php
						$msg = $sent->getLastMessageObject();
						if (is_object($msg)) {
							print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true, false));
						}
						?>
					</td>
					</tr>
					</table>
				</div>
				
				<?php
					break;
			} ?>
			
			
		</div>
			
		</div><!-- /#content -->
	</div><!-- /.row -->
</div><!-- /.container -->