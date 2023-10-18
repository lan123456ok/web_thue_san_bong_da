<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CampaignsImport;
use App\Models\Campaign;
use App\Models\Pitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class CampaignController extends Controller
{
    private object $model;
    private string $table;

    public function __construct() {
        $this->model = new Campaign();
        $this->table = (new Campaign())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index() {
        return view('admin.campaigns.index');
    }

    public function create() {
        return view('admin.campaigns.create');
    }

    public function importCSV(Request $request) {
        Excel::import(new CampaignsImport(), $request->file('file'));
    }
}
