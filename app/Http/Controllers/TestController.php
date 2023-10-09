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
//        dd(auth()->id());
//        return DB::getSchemaBuilder()->getColumnListing('sub_pitches'); get all table's column name
        $pitchName = 'Da cap';
        $city = 'HCM';

        $pitch = Pitch::firstOrCreate([
            'name' => $pitchName,
        ], [
            'city' => $city,
            'country' => 'Vietnam',
        ]);

        $sub_pitch = SubPitch::firstOrCreate([
            'pitch_id' => $pitch->id,
           ],[
            'image' => '1',
            'name' => 'Sân',
            'number_rentered' => 1,
            'price_per_hour' => 1,
            'type_id' => 2,
        ]);
//        dd($sub_pitch->id);

        Campaign::create([
           'campaign_title' => $pitchName . '-' . $city,
            'pitch_id' => $pitch->id,
            'sub_pitch_id' => $sub_pitch->id,
            'status' => CampaignStatus::AWAITING_TO_USE,
        ]);
    }
}
