<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Pitch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
{
    private object $model;
    private string $table;

    public function __construct() {
        $this->model = new User();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }
    public function index(Request $request){
        $selectRole = $request->get('role');
        $selectPitch = $request->get('pitch');

        //cach 1 -- if else 3 cai request => rat lau
        $query = $this->model->clone()
            ->with('pitch:id,name')
            ->latest();
        if(!empty($selectRole) && $selectRole !== ""){
            $query->where('role', $selectRole);
        }
        if(!empty($selectPitch) && $selectPitch !== ""){
            $query->whereHas('pitch', function($q) use ($selectPitch) {
                return $q->where('id', $selectPitch);
            });
        }
        $data = $query->paginate(10);

        //Cach 2
        // $data = $this->model
        //     ->when($request->has('role'), function($q) use ($request){
        //         return $q->where('role', $request->get('role'));
        //     })
        //     ->with('pitch:id,name')
        //     ->latest()
        //     ->paginate(10);

        //cach 2 nhung viet tắt hơn
        // $data = $this->model
        //     ->when($request->has('role'), function($q) {
        //         return $q->where('role', request('role'));
        //     })
        //     ->with('pitch:id,name')
        //     ->latest()
        //     ->paginate(10);

        // $data = $this->model
        //     ->where('role', )
        //     ->with('pitch:id,name')
        //     ->latest()
        //     ->paginate(10);

        $roles = UserRoleEnum::asArray();

        $pitches = Pitch::query()
            ->get([
                'id',
                'name',
            ]);


        return view("admin.$this->table.index",[
            'data' => $data,
            'roles'=> $roles,
            'pitches' => $pitches,
            'selectedRole' => $selectRole,
            'selectedPitch' => $selectPitch,
        ]);
    }

    public function destroy($userId) {
        User::destroy($userId);

        return redirect()->back();
    }
}
