<?php

namespace App\Http\Controllers;

use App\Http\Requests\Campaign\CheckSlugRequest;
use App\Http\Requests\Campaign\GenerateSlugRequest;
use App\Models\Campaign;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CampaignController extends Controller
{
    use ResponseTrait;
    private object $model;

    public function __construct() {
        $this->model = Campaign::query();
    }

    public function index() : JsonResponse {
        $data = $this->model->paginate();

        foreach ($data as $each) {
            $each->status = $each->status_name;
        }

//        Truoc khi hoc su dung trait
//        return response()->json([
//            'success' => true,
//            'data' => $data->getCollection(),
//            'pagination' => $data->linkCollection(),
//        ]);

        $arr['data'] = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();

        return $this->successResponse($arr);
    }

    public function generateSlug(GenerateSlugRequest $request) : JsonResponse {
        try {
            $title = $request->get('title');
            $slug = SlugService::createSlug(Campaign::class, 'slug', $title);

            return $this->successResponse($slug);
        } catch(Throwable $e) {
            return $this->errorResponse();
        }
    }

    public function checkSlug(CheckSlugRequest $request) : JsonResponse {
        return $this->successResponse();
    }
}
