<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $userFiles = UserFile::where('user_id', $user->id)->get()->toArray();
        $files = [];

        foreach ($userFiles as $userFile) {
            $files[] = [
                'id' => $userFile['id'], 
                'name' => $userFile['name'], 
                'date' => date('d.m.Y', strtotime($userFile['created_at'])),
                'link' => $userFile['file_link'],
            ];
        }

        return response()->json($files);
    }

    /**
     * upload file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return response()->json(['error' => 'No file']);
        } 

        if($file->getSize() > '100000'){
            return response()->json(['error' => 'File max 100Mb']);
        }

        $disk = Storage::disk('local');
        $user = auth('api')->user();
        $name =  $file->getClientOriginalName();
        $path = sha1($user->id . $name . time());
        $userFile = $this->saveUserFile($file, $user->id, $name, $path);
        $disk->put(
            'uploads/'.$path,
            file_get_contents($file->getRealPath())
        );

        return response()->json(['status' => 'success']); 
    }

    public function saveUserFile($file, $userId, $name, $path) {
        $userFile = new UserFile;

        $userFile->file_link = $path;
        $userFile->name = $name;
        $userFile->user_id = $userId;
        $userFile->save();

        return true;
    }

    public function download(UserFile $file, $hash)
    {
        if ($hash == $file->file_link) {
            $path = storage_path('app/uploads/'.$file->file_link);
            $name = $file->name;
         
            return response()->download($path, $name);  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFile $file)
    {
        Storage::delete($file->file_link);
        $file->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
