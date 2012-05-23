<p>
Project: <a href="<?=$project->to();?>"><?=$project->name?></a>
</p>
<hr />
<div class="activity">
	<p>
		<?=$user->firstname?> <?=$user->lastname?> (<?=$user->email?>), <strong>re-assigned the issue</strong>: <br />
		<a href="<?=$issue->to()?>">#<?=$issue->id?> <?=$issue->title?></a>	
		
		To
		<?php if($reassigned == false): ?>no-one<?php else:?>
			<?php echo $reassigned->firstname . ' ' . $reassigned->lastname . ' ('.$reassigned->email.') '; ?>		
		<?php endif;?>.		
	</p>
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
