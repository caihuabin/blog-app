<?php	
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session, App\User, App\Models\Notification;
class NotificationController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    } 

	public function show($id)
	{
		$user = User::findOrFail($id);
		$this->ownerOrAdminRequire($user->id);
		$notifications =  $user->notifications();

		return view('mobile.user.notification', ['notifications' => $notifications]);
	}

	public function destroy($id)
	{
		$noti = Notification::findOrFail($id);
		$this->ownerOrAdminRequire($noti->user_id);
        $noti->delete();
        $user = $noti->user;
        $user->decrement('notification_count', 1);
		return redirect()->route('notification.show', [ $user->id ]);
	}

    public function count()
    {
		$user = Auth::user();
        return [$user->notification_count];
    }

}
