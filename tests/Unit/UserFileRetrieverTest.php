<?php

namespace Tests\Unit;

use App\Http\Controllers\Services\UploadFile\UserFileRetriever;
use App\Models\User;
use App\Models\UserFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFileRetrieverTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    private $userFiles = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userFiles[] = UserFiles::factory()->create(['user_id' => $this->user->id]);
        $this->userFiles[] = UserFiles::factory()->create(['user_id' => $this->user->id]);
        $this->userFiles[] = UserFiles::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_return_all_user_files()
    {
        $userFileRetriever = new UserFileRetriever();
        $files = $userFileRetriever->getAllFile4User($this->user->id);
        $this->assertEquals(3, count($files));
    }

    public function test_user_dont_have_any_file()
    {
        $user = User::factory()->create();
        $userFileRetriever = new UserFileRetriever();
        $files = $userFileRetriever->getAllFile4User($user->id);
        $this->assertEquals(0, count($files));
    }


}
