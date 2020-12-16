<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DropzoneController extends Controller
{
    public function upload(Request $request){
        $request->validate([
            'csv' => 'required|file'
        ]);

        $file = new \App\Models\File();
        $file['original_name'] = $request['csv']->getClientOriginalName();
        $file['user_id'] = Auth::user()['id'];
        $file['path'] = 'files';
        $file['name'] = Str::random(32).'.'.\File::extension($file['original_name']);
        $request['csv']->storeAs($file['path'],$file['name']);
        $file->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. File processing started.',
            'location' => '/topups/bulk'
        ]);
    }
}
