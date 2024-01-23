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

    public function uploadFile(Request $request)
    {
        $total = count($_FILES['files']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
            $tmpFilePath = $_FILES['files']['tmp_name'][$i];
            if ($tmpFilePath != ""){
                $dir = __DIR__.'/../../../public/static/upload/slides/'. date('Y_m').'/';
                if(!file_exists($dir)){
                    mkdir($dir);
                }
                $newFilePath = $dir . $_FILES['files']['name'][$i];
                $newFilePath = u::update_file_name($newFilePath);
                $dir_file_insert = str_replace(__DIR__.'/../../../public/','',$newFilePath);
                $title = str_replace(__DIR__.'/../../../public/static/upload/slides/'. date('Y_m').'/','',$newFilePath);
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    u::insertSimpleRow(array(
                        'title' => $title,
                        'file_url' => $dir_file_insert,
                        'type' => 1,
                        'data_id' => $request->room_id,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'creator_id' => Auth::user()->id,
                    ), 'upload_files');
                }
            }
        }
        return response()->json("ok");
    }

    public function getSlides(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            $data = u::getMultiObject(array('data_id'=>$request->id, 'type'=>1, 'status'=>1),'upload_files', 0, 'id', true);
            foreach($data AS $k => $row){
                $data[$k]->file_url = config('app.url')."/".$row->file_url;
            }
            $result = [
                'status' => 1,
                'message' => 'success full',
                'data' => $data
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Phòng họp không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function deleteSlide(Request $request){
        u::updateSimpleRow(array(
            'status'=>0,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updator_id'=>Auth::user()->id
        ), array('id'=>$request->id), 'upload_files');
        return response()->json("ok");
    }
}
