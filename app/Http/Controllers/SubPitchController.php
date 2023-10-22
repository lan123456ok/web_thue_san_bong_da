<?php

namespace App\Http\Controllers;

use App\Models\SubPitch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubPitchController extends Controller
{
    use ResponseTrait;
    private object $model;

    public function __construct() {
        $this->model = SubPitch::query();
    }

    public function index(Request $request) : JsonResponse {
        $data = $this->model
            ->where('pitch_id', $request->get('pitch_id'))
            ->get();

        return $this->successResponse($data);
    }
}
