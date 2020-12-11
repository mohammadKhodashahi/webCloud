<?php

namespace Tests\Unit;



use App\Http\Controllers\Services\Permission\PermissionChecker;
use App\Models\User;
use App\Models\UserFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $userFile;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userFile = UserFiles::factory()->create(['user_id'=>$this->user->id]);
    }

    public function test_user_have_access_to_file()
    {

        $service = new PermissionChecker();
        $res = $service->userFilePermission($this->user->id,$this->userFile);
        $this->assertEquals(true,$res);
    }

    public function test_file_is_not_belong_to_the_user()
    {
        $user = User::factory()->create();

        $service = new PermissionChecker();
        $res = $service->userFilePermission($user->id,$this->userFile);
        $this->assertEquals(false,$res);
    }

}
