<?php  
namespace App\Blog\Notification;

use App\User;

class Mention
{
    public $body_parsed;
    public $users = [];
    public $usernames;
    public $body_original;

	public function getMentionedUsername() 
	{
		preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $this->body_original, $atlist_tmp);
		$usernames = [];
		foreach($atlist_tmp[2] as $k=>$v) {
			
		    if($atlist_tmp[1][$k] || strlen($v) >25) {
				continue;
			}
			$usernames[] = $v;
		}
		return array_unique($usernames);
	}

	public function replace()
	{
		$this->body_parsed = $this->body_original;
		foreach ($this->users as $user) {
			$search = '@' . $user->first_name;
			/*$place = '<a href="'.route('userinfo.show', $user->hash).'" data-ignore="push">['.$search.']</a>';*/
			$place = "[$search]";
			$this->body_parsed = str_replace($search, $place, $this->body_parsed);
		}
	}

	public function parse($body) 
	{
		$this->body_original = $body;

		$this->usernames = $this->getMentionedUsername();
		count($this->usernames) > 0 && $this->users = User::whereIn('name', $this->usernames)->get();
			
		$this->replace();
		return $this->body_parsed;
	}
}