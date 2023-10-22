<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PitchController extends Controller
{
    private object $model;
    private string $table;

    public function __construct() {
        $this->model = new Pitch();
        $this->table = (new Pitch())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index() {
        return view('admin.pitches.index');
    }

    public function create() {
        return view('admin.pitches.create');
    }
}
