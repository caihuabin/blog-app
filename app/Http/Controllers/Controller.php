<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Auth, App\Blog\Exceptions\UserIsNotOwnerException;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    protected function ownerOrAdminRequire($id)
	{
		if ( $id != Auth::user()->id )
		{
			throw new UserIsNotOwnerException("permission-required");
		}
	}
}
