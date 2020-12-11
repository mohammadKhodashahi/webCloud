<?php

namespace App\Http\Controllers\Services\Permission;


use App\Models\UserFiles;

class PermissionChecker
{
    /**
     * @param int $userId
     * @param UserFiles $fileUser
     * @return bool
     */
    public function userFilePermission(int $userId, UserFiles $fileUser):bool
    {
        if ($fileUser->user_id !== $userId) {
            return false;
        }
        return true;
    }
}
