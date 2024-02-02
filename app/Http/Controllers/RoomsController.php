<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use App\Providers\BigBluButtonServiceProvider as bbb;
use Illuminate\Http\Request;
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
            $list[$k]->join_link = config('app.url').'/rooms/'.$row->code;
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function info(Request $request)
    {
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            $room_info->last_session_time = $room_info->last_session_time ? date('d/m/Y H:i:s', strtotime($room_info->last_session_time)):'';
            $room_info->join_link = config('app.url').'/rooms/'.$room_info->code;
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
            'client_ip' => $request->ip()
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
                dd($tmpFilePath);
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

    public function update(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
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
            u::updateSimpleRow($data_update, array('id'=>$request->id), 'rooms');
            $result = [
                'status' => 1,
                'message' => 'Cập nhật thông tin phòn họp thành công',
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Phòng họp không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function removePass(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            $data_update = array(
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            );
            if($request->type ==2){
                $data_update['password_moderator'] = null;
            }else{
                $data_update['password_attendee'] = null;
            }
            u::updateSimpleRow($data_update, array('id'=>$request->id), 'rooms');
            $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id ");
            $result = [
                'status' => 1,
                'message' => $request->type ==2 ? 'Xóa mã truy cập cho người kiểm duyệt thành công': 'Xóa mã truy cập cho người xem thành công',
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

    public function genPass(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            $data_update = array(
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            );
            if($request->type ==2){
                $data_update['password_moderator'] = 'm'.uniqid();
            }else{
                $data_update['password_attendee'] = 'a'.uniqid();
            }
            u::updateSimpleRow($data_update, array('id'=>$request->id), 'rooms');
            $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id ");
            $result = [
                'status' => 1,
                'message' => $request->type ==2 ? 'Tạo mã truy cập cho người kiểm duyệt thành công': 'Tạo mã truy cập cho người xem thành công',
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

    public function deleteRoom(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            u::updateSimpleRow(array(
                'status'=>0,
                'updated_at'=>date('Y-m-d H:i:s'),
                'updator_id'=>Auth::user()->id
            ), array('id'=>$request->id), 'rooms');
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

    public function infoByCode(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE `status`=1 AND code = '".$request->code."'");
        if($room_info){
            $result = [
                'status' => 1,
                'message' => 'Thành công',
                'data' => [
                    'id' => $room_info->id,
                    'code' => $room_info->code,
                    'title' => $room_info->title,
                    'pass' => $room_info->password_moderator || $room_info->password_attendee ? 1 : 0
                ]
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link tham gia không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function joinRoom(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE `status`=1 AND code = '".$request->code."'");
        $init = $request->init && data_get(Auth::user(), 'id') == $room_info->creator_id ? 1 : 0; 
        if($room_info){
            if($room_info->password_attendee && ($init !=1 && $room_info->password_attendee != $request->pass && $room_info->password_moderator != $request->pass)){
                return [
                    'status' => 0,
                    'message' => 'Mã truy cập không hợp lệ.',
                ];
            }
            $presentation = u::query("SELECT file_url FROM upload_files WHERE status=1 AND type=1 AND data_id=$room_info->id");
            $session_info = u::first("SELECT * FROM room_sessions WHERE room_id= $room_info->id AND `status`=1");
            if($session_info){
                $pass_join = $init==1 || $request->pass == $room_info->password_moderator || $room_info->cf_moderator || $request->init==1 ? data_get($session_info, 'password_moderator') : data_get($session_info, 'password_attendee');
                $url_join = bbb::joinRoom(data_get($session_info, 'code'), $request->name, $pass_join);
                $result = [
                    'status' => 1,
                    'message' => 'Ok',
                    'redirect_url' => $url_join
                ];
            }else{
                if($request->pass == $room_info->password_moderator || $room_info->cf_user_start){
                    $urlLogout = config('app.url').'/pages/register';
                    $urlJoin = config('app.url')."/rooms/".$room_info->code; 
                    if($room_info->password_attendee){
                        $welcomeMessage = "Để mời ai đó tham gia cuộc họp, hãy gửi cho họ liên kết này: $urlJoin (Mã truy cập: ".$room_info->password_attendee. " )";
                    }else{
                        $welcomeMessage = "Để mời ai đó tham gia cuộc họp, hãy gửi cho họ liên kết này: $urlJoin";
                    }
                    $isRecordingTrue = $room_info->cf_record ? true : false;
                    $bbb_info = bbb::createRoom($room_info->id, $room_info->title, $presentation, 0, $urlLogout, $welcomeMessage, $isRecordingTrue);
                    if(data_get($bbb_info, 'status')){
                        $bbb_info =  data_get($bbb_info, 'data');
                        u::insertSimpleRow(array(
                            'code' => data_get($bbb_info, 'meetingID'),
                            'room_id' => $room_info->id,
                            'bbb_internal_meeting_id' =>data_get($bbb_info, 'internalMeetingID'),
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'creator_id' => data_get(Auth::user(), 'id'),
                            'start_time' => date('Y-m-d H:i:s'),
                            'password_attendee' => data_get($bbb_info, 'password_attendee'),
                            'password_moderator' => data_get($bbb_info, 'password_moderator')
                        ), 'room_sessions');

                        $pass_join = $init==1 || $request->pass == $room_info->password_moderator || $room_info->cf_moderator ? data_get($bbb_info, 'password_moderator') : data_get($bbb_info, 'password_attendee');
                        $url_join = bbb::joinRoom(data_get($bbb_info, 'meetingID'), $request->name, $pass_join);
                        
                        $result = [
                            'status' => 1,
                            'message' => 'Ok',
                            'redirect_url' => $url_join
                        ];
                    }else{
                        $result = [
                            'status' => 0,
                            'message' => data_get($bbb_info, 'message'),
                        ];
                    }
                }else{
                    $result = [
                        'status' => 0,
                        'message' => 'Cuộc họp chưa được bắt đầu.',
                    ];
                }
            }
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link tham gia không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function getSessions(Request $request){
        $room_info = u::first("SELECT * FROM rooms WHERE id = $request->id AND creator_id = ".Auth::user()->id);
        if($room_info){
            $pagination = (object)$request->pagination;
            $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
            $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
            $offset = $page == 1 ? 0 : $limit * ($page - 1);
            $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
            $cond = " r.room_id = ".$room_info->id;
            $total = u::first("SELECT count(r.id) AS total FROM room_sessions AS r WHERE $cond ");
            $list = u::query("SELECT r.*
                FROM room_sessions AS r 
                WHERE $cond ORDER BY r.id DESC $limitation");
            foreach($list AS $k=>$row){
                $list[$k]->start_time = $row->start_time ? date('d/m/Y H:i:s', strtotime($row->start_time)):'';
                $list[$k]->end_time = $row->end_time ? date('d/m/Y H:i:s', strtotime($row->end_time)):'';
            }
            $data = u::makingPagination($list, $total->total, $page, $limit);
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

    public function trialRoom(Request $request){
        $ip= $request->ip();
        $time_check = date('Y-m-d H:i:s', time()-15*60);
        $check_spam = u::first("SELECT count(id) AS total FROM rooms WHERE client_ip='$ip' AND `type`=0  AND created_at >='$time_check'");
        if($check_spam->total > 10){
            return 'Xin lỗi bạn đã gửi quá nhiều yêu cầu dùng thử, vui chờ sau 15 phút để tiếp tục sử dụng';
        }else{
            $room_title = 'Công nghệ giáo dục - phòng họp trực tuyến';
            $room_code = "trial_".uniqid();
            $room_trial_id = u::insertSimpleRow(array(
                'title' => $room_title,
                'code' => $room_code,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'creator_id' => 0,
                'client_ip' => $request->ip(),
                'type' => 0
            ), 'rooms');

            $urlLogout = config('app.url').'/pages/register';
            $urlJoin = config('app.url')."/rooms/".$room_code; 
            $welcomeMessage = "Để mời ai đó tham gia cuộc họp, hãy gửi cho họ liên kết này: $urlJoin";
            $isRecordingTrue = true;

            $bbb_info = bbb::createRoom($room_trial_id, $room_title, [], 10, $urlLogout, $welcomeMessage, $isRecordingTrue);
            if(data_get($bbb_info, 'status')){
                $bbb_info =  data_get($bbb_info, 'data');
                u::insertSimpleRow(array(
                    'code' => data_get($bbb_info, 'meetingID'),
                    'room_id' => $room_trial_id,
                    'bbb_internal_meeting_id' =>data_get($bbb_info, 'internalMeetingID'),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'creator_id' => data_get(Auth::user(), 'id'),
                    'start_time' => date('Y-m-d H:i:s'),
                    'password_attendee' => data_get($bbb_info, 'password_attendee'),
                    'password_moderator' => data_get($bbb_info, 'password_moderator')
                ), 'room_sessions');

                $url_join = bbb::joinRoom(data_get($bbb_info, 'meetingID'), 'Tài khoản dùng thử', data_get($bbb_info, 'password_moderator'));
                return redirect($url_join);
            }else{
                return data_get($bbb_info, 'message');
            }
        }
    }
}
