<?php namespace User;

class Activity extends \Eloquent {

	public static $table = 'users_activity';

	public static $timestamps = true;
	
	
	public function user()
	{
		return $this->belongs_to('\User');
	}
	
	
	public function other_user()
	{
		return $this->belongs_to('\User');
	}
	
	public function activity()
	{
		return $this->belongs_to('Activity', 'type_id');
	}
	
	
		
	/**
	* Add an activity action
	*
	* @param  int     $type_id
	* @param  int     $parent_id
	* @param  int     $item_id
	* @param  int     $action_id
	* @param  string  $data
	* @return bool
	*/
	public static function add($type_id, $parent_id, $item_id = null, $action_id = null, $data = null)
	{
		$insert = array(
			'type_id' => $type_id,
			'parent_id' => $parent_id,
			'user_id' => \Auth::user()->id,
		);

		if(!is_null($item_id))
		{
			$insert['item_id'] = $item_id;
		}

		if(!is_null($action_id))
		{
			$insert['action_id'] = $action_id;
		}

		if(!is_null($data))
		{
			$insert['data'] = $data;
		}
		
		$activity = new static;

		$activity->fill($insert)->save();		
		return $activity;

	}


	public function send_notification()
	{	
		$notification_list = Array();
		
		$issue = \Project\Issue::find($this->item_id);
		
		/* New Topic = Everyone currently assigned to the project */		
		if ($this->type_id == 1)
		{
			foreach(\Project::find($project->project_id)->users()->get() as $user) {
				$notification_list[$user->id] = $user;
			}

		} else {		
			/* Else -  Everyone who has interacted with the issue */	
			foreach(\User\Activity::where('item_id', '=', $this->item_id)->get() as $activity)
			{
				/* re-assigned to someone */
				if ($activity->type_id == 5)
				{
					$users[$activity->action_id] = \User::find($activity->action_id);
				}				
				$notification_list[$activity->user_id] = \User::find($activity->user_id);
			}
		}
		
		$user_info = $project_info = $comment_info = $attachment_info = null;
		
		$project_info = \Project::find($issue->project_id);
		$user_info = \User::find($this->user_id);
		
		/* Comment */
		if ($this->type_id == 2)
		{
			$comment_info = \Project\Issue\Comment::find($this->action_id);
			$attachment_info = $comment_info->attachments()->get();
		}
		
		$activity_type = \Activity::find($this->type_id);
		$view = \View::make('email.activity.'.$activity_type->activity,array(
			'activity' => $this,
			'issue' => $issue,			
			'user' => $user_info,
			'project' => $project_info,
			'comment' => $comment_info,
			'attachments' => $attachment_info,
			'recipients' => $notification_list
		));
 
		/* Send notification */
		foreach ($notification_list as $user)
		{
			\Mail::send_email($view, $user->email, 'Your Tiny Issue Account');
		} 

	}
}