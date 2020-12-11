<?php

namespace App\Http\Controllers\Services\UploadFile;


use App\Models\UserFiles;
use Illuminate\Http\Request;

class Uploader
{
    /**
     * @param Request $request
     * @param string $fileName
     * @return bool
     */
    public function uploadFile(Request $request, string $fileName)
    {
        try {
            $request->file->move(storage_path(UserFiles::FILE_UPLOAD_FOLDER), $fileName);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
