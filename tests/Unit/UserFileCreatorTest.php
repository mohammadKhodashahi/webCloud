<?php

namespace Tests\Unit;


use App\Http\Controllers\Services\UploadFile\UploadFileData;
use App\Http\Controllers\Services\UploadFile\UserFileCreator;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFileCreatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_file_4_user()
    {
        $user = User::factory()->create();
        $userFile = new UploadFileData();
        $userFile->name = 'test.csv';
        $userFile->userId =  $user->id;
        $userFile->size = '200';
        $userFile->format = 'csv';

        $userFileCreator = new UserFileCreator();
        $fileRow = $userFileCreator->create($userFile);
        $this->assertEquals('test.csv',$fileRow->name);
        $this->assertEquals($user->id,$fileRow->user_id);

    }
}
