<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private object $model;

    public function __construct() {
        $this->model = Campaign::query();
    }

    public function index() : JsonResponse {
        $data = $this->model->paginate();

        foreach ($data as $each) {
            $each->status = $each->status_name;
        }

        return response()->json([
            'success' => true,
            'data' => $data->getCollection(),
            'pagination' => $data->linkCollection(),
        ]);
    }
}
