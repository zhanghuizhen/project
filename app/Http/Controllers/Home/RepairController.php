<?php

namespace App\Http\Controllers\Home;

use App\repositories\Repair as RepairRepo;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepairController extends Controller
{
    //列表
    public function index(Request $request)
    {
        $this->validate($request, [
            'id' => 'numeric',
            'user_id' => 'numeric',
            'part' => 'string',
            'state' => 'string',
            'address' => 'string',
            'per_page' => 'numeric',
        ]);

        $params = $request->only(['id', 'user_id', 'part', 'state', 'address', 'per_page']);

        $repair_repo = new RepairRepo();
        $list = $repair_repo->getList($params);

        return Response::json([
            'code' => 0,
            'data' => $list,
        ]);
    }

    //详情
    public function show($id)
    {
        $repair_repo = new RepairRepo();
        $repair = $repair_repo->getOne($id);

        return Response::json([
            'code' => 0,
            'data' => $repair,
        ]);
    }


}
