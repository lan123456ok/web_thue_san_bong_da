<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private object $model;

    public function __construct() {
        $this->model = Campaign::query();
    }

    public function index() {
        return $this->model->paginate();
    }
}
