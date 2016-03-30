<?php

namespace App\Http\Controllers\Generic;

use Illuminate\Http\Request;
use Validator, Auth, Redirect;
use App\Http\Controllers\Controller;
use Image;
use App\Blog\Helpers\ViewHelpers;
class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function uploadImageAndClip(Request $request)
    {
        if(! $request->hasFile('imagefile')){
            $data['error'] = 'no file,no talk';
            return $data;
        }
		$file = $request->file('imagefile');
        $clip = $request->get('clip');
        if ($file && $file->isValid())
        {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ( $file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions) ){
                return ['error' => 'You may only upload png, jpg or gif.'];
            }

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = 'uploads/images/' . date("Ym", time()) .'/'.date("d", time()) .'/'. Auth::user()->id;
            $destinationPath = public_path() . '/' . $folderName;
            $randomName = str_random(10);
            $safeName        = $randomName .'.'.$extension;
            $clipName = $randomName . '-clip.' . $extension;
            $file->move($destinationPath, $safeName);
            
            // If is not gif file, we will try to reduse the file size
            if ($file->getClientOriginalExtension() != 'gif')
            {
                $img = Image::make($destinationPath . '/' . $safeName);
                if($img->width() < $img->height()){
                    $img->resize($clip, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $top_x = 0;
                    $top_y = round($img->height()/2 - $clip/2);
                }
                else{
                    $img->resize(null, $clip, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $top_y = 0;
                    $top_x = round($img->width()/2 - $clip/2);
                }
                $img->crop($clip, $clip, $top_x, $top_y);
                //return $img->response('jpg');
                $img->save($destinationPath . '/' . $clipName);
            }

            $data[] = ViewHelpers::getUserStaticDomain().'/'.$folderName.'/'.$safeName;
        }
        else
        {
            $data['error'] = 'Error while uploading file';
        }
        
        return $data;
    }
}