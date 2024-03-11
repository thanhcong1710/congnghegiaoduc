<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use App\Providers\BigBluButtonServiceProvider as bbb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestsController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " t.status = 1 AND t.creator_id = ".Auth::user()->id;
        if ($keyword !== '') {
            $cond .= " AND (r.title LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(t.id) AS total FROM qz_tests AS t WHERE $cond ");
        $list = u::query("SELECT t.*
            FROM qz_tests AS t
            WHERE $cond ORDER BY t.id DESC $limitation");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        if($request->id){
            u::updateSimpleRow(array(
                'topic_id' => data_get($request, 'topic_id'),
                'title' => data_get($request, 'title'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updator_id' => Auth::user()->id,
            ), array('id'=>$request->id), 'qz_tests');
            $result = [
                'status' => 1,
                'message' => 'Cập nhật thành công'
            ];
        }else{
            u::insertSimpleRow(array(
                'topic_id' => data_get($request, 'topic_id'),
                'user_id' => Auth::user()->id,
                'title' => data_get($request, 'title'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'creator_id' => Auth::user()->id,
            ), 'qz_tests');
            $result = [
                'status' => 1,
                'message' => 'Thêm mới thành công'
            ];
        }
        return response()->json($result);
    }

    public function info(Request $request)
    {
        $test_info = u::first("SELECT * FROM qz_tests WHERE id = $request->id AND user_id=".Auth::user()->id);
        if($test_info){
            $result = [
                'status' => 1,
                'message' => 'success full',
                'data' => $test_info
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Bài kiểm tra không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function update(Request $request){
        $test_info = u::first("SELECT * FROM qz_tests WHERE id = $request->id AND user_id = ".Auth::user()->id);
        if($test_info){
            $params = $request->input();
            $data_update = array(
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            );
            foreach($params AS $k=> $row){
                if($k != 'id'){
                    $data_update[$k] = $row;
                }
            }
            u::updateSimpleRow($data_update, array('id'=>$request->id), 'qz_tests');
            $result = [
                'status' => 1,
                'message' => 'Cập nhật thông tin bài kiểm tra thành công',
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Bài kiểm tra không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function delete(Request $request){
        $test_info = u::first("SELECT * FROM qz_tests WHERE id = $request->id AND user_id = ".Auth::user()->id);
        if($test_info){
            u::updateSimpleRow(array(
                'status'=>0,
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            ), array('id'=>$request->id), 'qz_tests');
            $result = [
                'status' => 1,
                'message' => 'Xóa bài kiểm tra thành công',
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Bài kiểm tra không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function getQuizs(Request $request){
        $test_info = u::first("SELECT * FROM qz_tests WHERE id = $request->id AND user_id = ".Auth::user()->id);
        if($test_info){
            $pagination = (object)$request->pagination;
            $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
            $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
            $offset = $page == 1 ? 0 : $limit * ($page - 1);
            $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
            $cond = " m.test_id = ".$test_info->id;
            $total = u::first("SELECT count(m.id) AS total FROM qz_test_quizs AS m WHERE $cond ");
            $list = u::query("SELECT m.*
                FROM qz_test_quizs AS m 
                WHERE $cond ORDER BY m.id DESC $limitation");
            $data = u::makingPagination($list, $total->total, $page, $limit);
            $result = [
                'status' => 1,
                'message' => 'success full',
                'data' => $data
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Bài kiểm tra không tồn tại',
            ];
        }
        return response()->json($result);
    }
}
