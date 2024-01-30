<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use App\Providers\BigBluButtonServiceProvider as bbb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordsController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " rc.status > 0 AND r.creator_id = ".Auth::user()->id;
        if ($keyword !== '') {
            $cond .= " AND (r.title LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(rc.id) AS total FROM room_session_records AS rc
                LEFT JOIN rooms AS r ON r.id = rc.room_id
                LEFT JOIN room_sessions AS rs ON rs.id = rc.room_session_id
            WHERE $cond ");
        $list = u::query("SELECT rc.id AS record_id, r.title, rs.start_time, rs.end_time, rc.status, 
                IF(rc.status=1, rc.bbb_record_link, '') AS record_link, rc.created_at
            FROM room_session_records AS rc
                LEFT JOIN rooms AS r ON r.id = rc.room_id
                LEFT JOIN room_sessions AS rs ON rs.id = rc.room_session_id
            WHERE $cond ORDER BY rc.id DESC $limitation");
        foreach($list AS $k=>$row){
            $list[$k]->start_time = $row->start_time ? date('d/m/Y H:i:s', strtotime($row->start_time)):'';
            $list[$k]->end_time = $row->end_time ? date('d/m/Y H:i:s', strtotime($row->end_time)):'';
            $record_date = 30 - ceil((time()-strtotime($row->created_at)) / (24*3600));
            $list[$k]->record_date = $record_date > 0 ? $record_date : 0;
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function delete(Request $request){
        u::updateSimpleRow(array(
            'status'=>0,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updator_id'=>Auth::user()->id
        ), array('id'=>$request->id), 'room_session_records');
        return response()->json("ok");
    }
}
