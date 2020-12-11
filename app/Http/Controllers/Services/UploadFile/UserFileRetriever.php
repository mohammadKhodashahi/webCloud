<?php

namespace App\Http\Controllers\Services\UploadFile;

use App\Http\Controllers\Controller;
use App\Models\UserFiles;
use http\Encoding\Stream;
use Illuminate\Http\Request;

class UserFileRetriever extends Controller
{
    /**
     * @param int $userId
     * @return mixed
     */
    public function getAllFile4User(int $userId)
    {
        return UserFiles::where('user_id', $userId)->get();
    }

    public function getOneById(String $id): ?UserFiles
    {
        return UserFiles::where('id', $id)->first();
    }
}
