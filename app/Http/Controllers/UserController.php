<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateInfo(Request $request)
    {
        $data = $request->data;
        if ($data) {
            $arr_update = [];
            foreach ($data as $k => $item) {
                if ($k == 'birthday') {
                    $date = str_replace('/', '-', $item);
                    $arr_update[$k] = date('Y-m-d', strtotime($date));
                } else {
                    $arr_update[$k] = $item;
                }
            }
            u::updateSimpleRow($arr_update, array('id' => Auth::user()->id), 'users');
        }
        $uesr_info = u::getObject(array('id' => Auth::user()->id), 'users');

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật thành công.',
            'userData' => u::transformUser($uesr_info)
        ]);
    }

    public function changePassword(Request $request)
    {
        if (password_verify($request->old_password, Auth::user()->password)) {
            u::updateSimpleRow(array(
                'password' => Hash::make($request->new_password)
            ), array('id' => Auth::user()->id), 'users');
            return response()->json([
                'status' => 1,
                'message' => 'Đổi mật khẩu thành công.'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Mật khẩu cũ không chính xác.'
            ]);
        }
    }

    public function lawSchedules(Request $request)
    {
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " s.status >= 0 AND s.user_id = ".Auth::user()->id;
        $total = u::first("SELECT count(id) AS total FROM law_schedules AS s WHERE $cond ");
        $list = u::query("SELECT s.*
            FROM law_schedules AS s 
            WHERE $cond ORDER BY s.id DESC $limitation");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function addLawSchedules(Request $request){
        if($request->id){
            $schedule_info = u::first("SELECT * FROM law_schedules WHERE `status`>=0 AND `date` = '$request->date' AND id!='$request->id' AND `open_time`='$request->open_time:00:00' AND user_id=".Auth::user()->id);
            if($schedule_info){
                $result = [
                    'status' => 0,
                    'message' => 'Đã tồn tại khung giờ'
                ];
            }else{
                u::updateSimpleRow(array(
                    'user_id' => Auth::user()->id,
                    'date' => data_get($request, 'date'),
                    'open_time' => data_get($request, 'open_time').":00:00",
                    'close_time' => (data_get($request, 'open_time')+1).":00:00",
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updator_id' => Auth::user()->id,
                ), array('id'=>$request->id), 'law_schedules');
                $result = [
                    'status' => 1,
                    'message' => 'Cập nhật thành công'
                ];
            }
        }else{
            $schedule_info = u::first("SELECT * FROM law_schedules WHERE `status`>=0 AND `date` = '$request->date' AND `open_time`='$request->open_time:00:00' AND user_id=".Auth::user()->id);
            if($schedule_info){
                $result = [
                    'status' => 0,
                    'message' => 'Đã tồn tại bản ghi'
                ];
            }else{
                u::insertSimpleRow(array(
                    'user_id' => Auth::user()->id,
                    'date' => data_get($request, 'date'),
                    'open_time' => data_get($request, 'open_time').":00:00",
                    'close_time' => (data_get($request, 'open_time')+1).":00:00",
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'creator_id' => Auth::user()->id,
                ), 'law_schedules');
                $result = [
                    'status' => 1,
                    'message' => 'Thêm mới thành công'
                ];
            }
        }

        return response()->json($result);
    }

    public function deleteLawSchedules(Request $request){
        $data = u::updateSimpleRow(array(
            'status' => -1,
            'updated_at'=> date('Y-m-d H:i:s'),
            'updator_id'=> Auth::user()->id
        ), array('id'=>$request->payment_id),'law_schedules');
        return response()->json($data);
    }
}
