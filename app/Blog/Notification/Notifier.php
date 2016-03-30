<?php 
namespace App\Blog\Notification;

use App\Blog\Notification\Mention;
use App\Models\Reply, App\Models\Blog, App\Models\Notification, Carbon\Carbon, App\User;

class Notifier
{
    public $notifiedUsers = [];

    public function newReplyNotify($fromUser_id, Mention $mentionParser, Blog $blog, Reply $reply)
    {
        // Notify the author
        Notification::batchNotify(
                    'new_reply',
                    $fromUser_id,
                    $this->removeDuplication([$blog->user]),
                    $blog,
                    $reply);

        // Notify attented users
        /*Notification::batchNotify(
                    'attention',
                    $fromUser_id,
                    $this->removeDuplication($blog->attentedBy),
                    $blog,
                    $reply);*/

        // Notify mentioned users
        Notification::batchNotify(
                    'at',
                    $fromUser_id,
                    $this->removeDuplication($mentionParser->users),
                    $blog,
                    $reply);
    }

    // in case of a user get a lot of the same notification
    public function removeDuplication($users)
    {
        $notYetNotifyUsers = [];
        foreach ($users as $user)
        {
            if (!in_array($user->id, $this->notifiedUsers))
            {
                $notYetNotifyUsers[] = $user;
                $this->notifiedUsers[] = $user->id;
            }
        }
        return $notYetNotifyUsers;
    }
}
