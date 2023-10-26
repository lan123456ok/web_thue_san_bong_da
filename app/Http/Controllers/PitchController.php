<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class PitchController extends Controller
{
    use ResponseTrait;
    private object $model;

    public function __construct() {
        $this->model = Pitch::query();
    }

    public function index(Request $request) : JsonResponse {
        $data = $this->model
            ->where('name', 'like', '%' . $request->get('q') . '%')
            ->get();

        return $this->successResponse($data);
    }

    public function check($pitchId) : JsonResponse {
        $check = $this->model
            ->where('id', $pitchId)
            ->exists();

        return $this->successResponse($check);
    }
}
