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

    public function addContact(Request $request){
        u::insertSimpleRow(array(
            'company' => $request->company,
            'phone' => $request->phone,
            'contact_name' => $request->contact_name,
            'note' => $request->note,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id'=>Auth::user()->id
        ), 'contacts');
        return response()->json([
            'status' => 1,
            'message' => 'Đăng ký tư vấn thành công. Chúng tôi sẽ liên hệ tư vấn trong thời gian sớm nhất'
        ]);
    }

    public function addPayment(Request $request){
        $id = u::insertSimpleRow(array(
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id'=>Auth::user()->id
        ), 'payments');
        $code = "V".u::genMaSo($id, 5);
        u::updateSimpleRow(array(
            'code'=> $code
        ), array('id'=>$id), 'payments');
        return response()->json([
            'status' => 1,
            'message' => 'Tạo yêu cầu nâng cấp thành công'
        ]);
    }

    public function transferPayment(Request $request){
        u::updateSimpleRow(array(
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id'=>Auth::user()->id
        ),  array('id'=>$request->id),'payments');
        return response()->json([
            'status' => 1,
            'message' => 'Xin vui lòng chờ để quản trị viên xác nhận và kích hoạt tài khoản VIP cho bạn'
        ]);
    }

    public function activePayment(Request $request){
        $payment_info = u::getObject(array('code'=>strtoupper($request->code)),'payments');
        if($payment_info){
            $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
            $end_date =  date('Y-m-d',strtotime ( '+1 month' , strtotime ( $start_date ) )) ;
            u::updateSimpleRow(array(
                'status' => 2,
                'start_date' => $start_date,
                'end_date' => $end_date
            ),  array('id'=>$payment_info->id),'payments');
            u::updateSimpleRow(array(
                'is_vip' => 1,
                'end_vip' => $end_date
            ),  array('id'=>$payment_info->user_id),'users');
        }
        return response()->json([
            'status' => 1,
            'message' => 'ok'
        ]);
    }

    public function listPayment(Request $request)
    {
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " p.status >= 0 AND p.user_id = ".Auth::user()->id;
        
        $total = u::first("SELECT count(p.id) AS total FROM payments AS p WHERE $cond ");
        $list = u::query("SELECT p.*
            FROM payments AS p
            WHERE $cond ORDER BY p.id DESC $limitation");
        foreach($list AS $k=>$row){
            $list[$k]->start_date = $row->start_date ? date('d/m/Y', strtotime($row->start_date)):'';
            $list[$k]->end_date = $row->end_date ? date('d/m/Y', strtotime($row->end_date)):'';
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function getDetailPayment(Request $request)
    {
        $data = u::first("SELECT * FROM payments AS p WHERE id=$request->id ");
        return response()->json($data);
    }

}
