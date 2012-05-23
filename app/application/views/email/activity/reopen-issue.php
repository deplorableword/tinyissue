<p>
Project: <a href="<?=$project->to();?>"><?=$project->name?></a>
</p>
<hr />
<div class="activity">
	<p>
		<?=$user->firstname?> <?=$user->lastname?> (<?=$user->email?>), <strong>re-opened the issue</strong>: <br />
		<a href="<?=$issue->to()?>">#<?=$issue->id?> <?=$issue->title?></a>	
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
