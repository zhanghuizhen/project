<?php
/**
 * 后台小区公告
 * Date: 2019/1/8
 * Time: 15:44
 */

namespace App\Http\Controllers\Admin;

use Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice as NoticeModel;
use App\repositories\Notice as NoticeRepo;

class NoticeController extends Controller
{
    //列表
    public function index(Request $request)
    {
//        $this->validate($request, [
//            'id' => 'numeric|min:1',
//            'title' => 'string',
//            'content' => 'string',
//            'state' => 'string',
//            'user_id' => 'numeric|min:1',
//            'publish_start_time' => 'date',
//            'publish_end_time' => 'date',
//            'per_page' => 'numeric',
//        ]);
//
//        $params = $request->only(['id', 'title', 'content', 'state', 'user_id',
//            'publish_start_time', 'publish_end_time', 'per_page']);

        $params= [];
        $params['per_page'] = 5;

        $noticeRepo =new NoticeRepo();
        $list = $noticeRepo->getList($params);

        return view('admin/notice/index', ['list' => $list ]);
    }

    //展示创建页面
    public function create()
    {
        return view('admin/notice/create');
    }

    //创建
    public function store(Request $request)
    {
        $params = $request->all(['title', 'content', 'cover', 'address', 'user_id']);

        $params['state'] = 'published';
        $params['published_at'] = date('Y-m-d H:m:i');

        $noticeRepo = new NoticeRepo();
        $notice = $noticeRepo->store($params);

        if (! $notice) {
            return view('admin/notice/create');
        }

        return view('admin/notice/show', ['data' => $notice]);
    }

    //展示更新页面
    public function edit($id)
    {
        $noticeRepo = new NoticeRepo();

        $notice = $noticeRepo->getOne($id);

        if (! $notice) {
            return '数据不存在';
        }

        return view('admin/notice/edit', ['data' => $notice]);
    }

    //更新
    public function update($id, Request $request)
    {
        $params = $params = $request->all(['title', 'content', 'cover', 'address']);

        $noticeRepo = new NoticeRepo();

        $notice = $noticeRepo->getOne($id);

        if (! $notice) {
            return '数据不存在';
        }

        $result = $noticeRepo->update($notice, $params);

        if (! $result) {
            return view('admin/notice/update');
        }

        return view('admin.notice.show', ['data' => $notice]);
    }

    //删除
    public function delete($id)
    {
        $noticeRepo = new NoticeRepo();

        $notice = $noticeRepo->getOne($id);

        if (! $notice) {
            return '数据不存在';
        }

        $result = $noticeRepo->delete($notice);

        if ($result) {
            return 'ok';
        }else{
            return 'false';
        }
    }

    //详情
    public function show($id)
    {
        $noticeRepo = new NoticeRepo();
        $notice = $noticeRepo->getOne($id);

        if (! $notice) {
            return '数据不存在';
        }

        return view('admin/notice/show', ['data' => $notice]);
    }

    //发布
    public function publish($id)
    {
        $notice = NoticeModel::find($id);

        if (! $notice) {
            throw new \Exception('id为' . $id . '的数据不存在');
        }

        if (! in_array($notice->state, ['offline', 'pre_published'])) {
            throw new \Exception('id为' . $id . '的数据不是下线和待发布态，不能发布');
        }

        $result = $notice->update(['state' => 'published']);

        if (! $result) {
            throw new \Exception('id为' . $id . '的数据更新失败');
        }

        return Response::json([
            'code' => 0,
        ]);
    }

    //下线
    public function offline($id)
    {
        $notice = NoticeModel::find($id);

        if (! $notice) {
            throw new \Exception('id为' . $id . '的数据不存在');
        }

        if ($notice->state != 'published') {
            throw new \Exception('id为' . $id . '的数据不是发布态，不能下线');
        }

        $result = $notice->update(['state' => 'offline']);

        if (! $result) {
            throw new \Exception('id为' . $id . '的数据更新失败');
        }

        return Response::json([
            'code' => 0,
        ]);
    }
}