<?php

namespace App\Http\Controllers\Services\UploadFile;


use App\Models\UserFiles;

class UserFileCreator
{
    /**
     * @param UploadFileData $data
     * @return UserFiles
     */
    public function create(UploadFileData $data): UserFiles
    {
        $fileItem = new UserFiles();
        $fileItem->name = $data->name;
        $fileItem->size = $data->size;
        $fileItem->format = $data->format;
        $fileItem->user_id = $data->userId;
        $fileItem->save();
        return $fileItem;
    }
}
