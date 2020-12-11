<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\Permission\PermissionChecker;
use App\Http\Controllers\Services\UploadFile\Uploader;
use App\Http\Controllers\Services\UploadFile\UploadFileData;
use App\Http\Controllers\Services\UploadFile\UserFileCreator;
use App\Http\Controllers\Services\UploadFile\UserFileRetriever;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        $userFileRetriever = new UserFileRetriever();
        $userFiles = $userFileRetriever->getAllFile4User(Auth::id());

        return view('fileUpload', ['userFiles' => $userFiles]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function fileUploadPost(Request $request)
    {

        $request->validate([
            'file' => 'required|max:8196',
        ]);

        $fileData = new UploadFileData();
        $fileData->name = $request->file->getClientOriginalName();
        $fileData->size = $request->file->getSize();
        $fileData->format = $request->file->getClientOriginalExtension();
        $fileData->userId = Auth::id();

        $userFileCreator = new UserFileCreator();
        $userFile = $userFileCreator->create($fileData);
        $uploaderService = new Uploader();
        $fileLocalName = $userFile->getServerFileName();;
        $isUploaded = $uploaderService->uploadFile($request, $fileLocalName);
        if ($isUploaded == false) {
            $userFile->delete();
            return back()
                ->withErrors('error', 'There is error on file upload please try again')
                ->with('file', $fileData->name);
        }

        return back()
            ->with('success', 'File uploaded successfully.')
            ->with('file', $fileData->name);
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function fileDownload(string $id)
    {
        $userFileRetriever = new UserFileRetriever();
        $userFile = $userFileRetriever->getOneById($id);
        if ($userFile == null) {
            return Response('File not found.', 404);
        }
        $permissionChecker = new PermissionChecker();
        $permission = $permissionChecker->userFilePermission(Auth::id(), $userFile);
        if (!$permission) {
            return Response('You are not allowed to download this file', 403);
        }

        $file = 'file/' . $userFile->getServerFileName();

        if (!Storage::disk('local')->exists($file)) {
            return Response('File not found.', 404);
        }
        return Storage::disk('local')->download($file, $userFile->name);

    }
}
