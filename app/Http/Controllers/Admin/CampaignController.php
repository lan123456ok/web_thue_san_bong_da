<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Campaign\StoreRequest;
use App\Imports\CampaignsImport;
use App\Models\Campaign;
use App\Models\Pitch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class CampaignController extends Controller
{
    use ResponseTrait;
    private object $model;
    private string $table;

    public function __construct() {
        $this->model = new Campaign();
        $this->table = (new Campaign())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index() {
//        dd(auth()->check(), auth()->guard('admin')->check());
        return view('admin.campaigns.index');
    }

    public function create() {
        return view('admin.campaigns.create');
    }

    public function store(StoreRequest $request) {
        DB::beginTransaction();
        try {
            $arr = $request->only([
                'campaign_title',
                'pitch_id',
                'sub_pitch_id',
                'status',
                'date',
                'start_time',
                'end_time',
                'isNight',
                'total_price',
                'slug',
            ]);

            if(!$request->has('isNight')) {
                $arr['isNight'] = 0;
            }
            $arr['status'] = 0;

            Campaign::create($arr);

            DB::commit();
            return $this->successResponse();
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            return $this->errorResponse();
        }
    }

    public function importCSV(Request $request) : JsonResponse {
        try {
            Excel::import(new CampaignsImport(), $request->file('file'));

            return $this->successResponse();
        } catch (Throwable $e) {
            return $this->errorResponse();
        }
    }
}
