<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\Permission\PermissionChecker;
use App\Http\Controllers\Services\UploadFile\UserFileRetriever;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Controller
{
    /**
     * @param string $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(string $id)
    {
        return Response('This is not implemented.', 404);
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete(string $id)
    {
        $userFileRetriever = new UserFileRetriever();
        $userFile = $userFileRetriever->getOneById($id);
        if ($userFile == null) {
            return Response('File not found.', 404);
        }
        $permissionChecker = new PermissionChecker();
        $permission = $permissionChecker->userFilePermission(Auth::id(), $userFile);
        if (!$permission) {
            return Response('You are not allowed to delete this file', 403);
        }
        $file = 'file/' . $userFile->getServerFileName();

        if (Storage::disk('local')->exists($file)) {
            Storage::disk('local')->delete($file);
        }
        $userFile->delete();

        return Response(['message'=>'File successfully deleted.'], 200);
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(string $id)
    {
        return Response('This is not implemented.', 404);
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(string $id,Request $request)
    {
        $userFileRetriever = new UserFileRetriever();
        $userFile = $userFileRetriever->getOneById($id);
        if ($userFile == null) {
            return Response('File not found.', 404);
        }
        $permissionChecker = new PermissionChecker();
        $permission = $permissionChecker->userFilePermission(Auth::id(), $userFile);
        if (!$permission) {
            return Response('You are not allowed to delete this file', 403);
        }
        $userFile->name = $request->input('name');
        $userFile->save();
        return Response(['message'=>'File successfully renamed.'], 200);
    }
}
