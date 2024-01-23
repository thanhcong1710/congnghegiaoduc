<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\GetRecordingsParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use Illuminate\Support\Facades\Auth;

class RoomsController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " r.status = 1 AND r.creator_id = ".Auth::user()->id;
        if ($keyword !== '') {
            $cond .= " AND (r.title LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(r.id) AS total FROM rooms AS r WHERE $cond ");
        $list = u::query("SELECT r.*
            FROM rooms AS r 
            WHERE $cond ORDER BY r.id DESC $limitation");
        foreach($list AS $k=>$row){
            $list[$k]->last_session_time = $row->last_session_time ? date('d/m/Y H:i:s', strtotime($row->last_session_time)):'';
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function info(Request $request)
    {
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        $room_info->last_session_time = $room_info->last_session_time ? date('d/m/Y H:i:s', strtotime($room_info->last_session_time)):'';
        if($room_info){
            $result = [
                'status' => 1,
                'message' => 'success full',
                'data' => $room_info
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Phòng họp không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function create(Request $request)
    {
        u::insertSimpleRow(array(
            'title' => $request->title,
            'code' => Auth::user()->id."_".uniqid(),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
        ), 'rooms');

        $result = [
            'status' => 1,
            'message' => 'Thêm mới phòng họp thành công',
        ];
        return response()->json($result);
    }

    public function uploadFile()
    {
        return response()->json("ok");
    }

}
