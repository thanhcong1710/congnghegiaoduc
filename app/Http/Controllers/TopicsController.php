<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " r.status = 1 AND r.user_id = ".Auth::user()->id;
        if ($keyword !== '') {
            $cond .= " AND (r.title LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(r.id) AS total FROM qz_topics AS r WHERE $cond ");
        $list = u::query("SELECT r.*
            FROM qz_topics AS r 
            WHERE $cond ORDER BY r.id DESC $limitation");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        if($request->id){
            u::updateSimpleRow(array(
                'title' => data_get($request, 'title'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updator_id' => Auth::user()->id,
            ), array('id'=>$request->id), 'qz_topics');
            $result = [
                'status' => 1,
                'message' => 'Cập nhật thành công'
            ];
        }else{
            u::insertSimpleRow(array(
                'user_id' => Auth::user()->id,
                'title' => data_get($request, 'title'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'creator_id' => Auth::user()->id,
            ), 'qz_topics');
            $result = [
                'status' => 1,
                'message' => 'Thêm mới thành công'
            ];
        }
        return response()->json($result);
    }

    public function deleteRoom(Request $request){
        $room_info = u::first("SELECT * FROM qz_tests WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            u::updateSimpleRow(array(
                'status'=>0,
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            ), array('id'=>$request->id), 'qz_tests');
            $result = [
                'status' => 1,
                'message' => 'Xóa phòng họp thành công',
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Phòng họp không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function listAllUser(Request $request){
        $cond = " t.status = 1 AND t.user_id = ".Auth::user()->id;
        $list = u::query("SELECT t.*
            FROM qz_topics AS t 
            WHERE $cond ORDER BY t.title");
        return response()->json($list);
    }
}
