<p>
Project: <a href="<?=$project->to();?>"><?=$project->name?></a>
</p>
<hr />
<div class="activity">
	<p>
		<?=$user->firstname?> <?=$user->lastname?> (<?=$user->email?>), <strong>commented on the issue</strong>: <br />
		<a href="<?=$issue->to()?>">#<?=$issue->id?> <?=$issue->title?></a>	
	</p>
	<p>
		<br />
		<?=Project\Issue\Comment::format($comment->comment)?>
	</p>
			
	<p><a href="<?=$issue->to()?>">View this issue</a></p>

	<?php if ($attachments):?>
	<strong>Attachments</strong>
		<ul class="attachments">
			<?php foreach($attachments as $attachment): ?>
			<li>
				<a href="<?=$issue->to()?>" title="<?=$attachment->filename?>"><?=$attachment->filename?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endif;?>
</div>
<hr />
<div class="sent">
	This notification was sent to:
	
	<?php if (count($recipients) > 0){?>
	<ul>
	<?php foreach($recipients as $key=>$recipient):
		echo '<li>'.$recipient->firstname . ' ' . $recipient->lastname. ' ('.$recipient->email.')</li>';
	endforeach;?>
	</ul>
	<?php } ?>
</div>