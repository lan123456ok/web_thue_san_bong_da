<?php

namespace App\Http\Controllers;

use App\Enums\CampaignStatus;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Pitch;
use App\Models\SubPitch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{
    private object $model;
    private string $table;

    public function __construct() {
        $this->model = new User();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function test() {
    }
}
