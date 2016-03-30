<?php

namespace App\Http\Controllers\Generic;

use Illuminate\Http\Request;
use Validator, Input, Redirect, Response;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('mobile.user.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->ownerOrAdminRequire($user->id);
        return view('mobile.user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {   
        $user = User::findOrFail($id);

        $this->ownerOrAdminRequire($user->id);

        $validation = $this->updateValidator($request->except('_token'));
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation);
        }
        $data = $request->only(['realname', 'telephone', 'gender', 'city', 'address', 'signature', 'avatar']);

        $user->update($data);
        return redirect()->route('user.show', [$id]);
    }

    protected function updateValidator(array $data)
    {
        return Validator::make($data, [
        //    'name' => 'required|min:2|max:32',
            'realname' => 'min:2|max:32',
            'telephone' => 'numeric',
            'gender' => 'boolean',
            'address' => 'min:2|max:255',
            'signature' => 'min:2|max:255',
            /*'avatar' => '',*/
        ]);
    }
}
