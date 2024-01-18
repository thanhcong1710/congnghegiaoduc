<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function add(Request $request)
    {
        $total_amount = 0;
        $cartItems = $request->cartItems;
        foreach ($cartItems as $item) {
            $total_amount += data_get($item, 'quantity') * data_get($item, 'price');
        }
        $payment_id = u::insertSimpleRow(array(
            'user_id' => Auth::user()->id,
            'amount' => $total_amount,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
        ), 'payments');
        foreach ($cartItems as $item) {
            u::insertSimpleRow(array(
                'payment_id' => $payment_id,
                'user_id' => Auth::user()->id,
                'law_user_id' => data_get($item, 'user_id'),
                'law_schedule_id' => data_get($item, 'schedule_id'),
                'quantity' => data_get($item, 'quantity'),
                'amount' => data_get($item, 'price'),
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'creator_id' => Auth::user()->id,
            ), 'payment_items');
        }

        return response()->json("ok");
    }

    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';
        $status = isset($request->status) ? $request->status : '-1';
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " p.status >= 0 ";
        if ($status != '-1') {
            $cond .= " AND p.status = $status ";
        }
        $total = u::first("SELECT count(id) AS total FROM payments AS p WHERE $cond ");
        $list = u::query("SELECT p.*
            FROM payments AS p WHERE $cond ORDER BY p.id DESC $limitation");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function delete(Request $request){
        $data = u::updateSimpleRow(array(
            'status' => -1,
            'updated_at'=> date('Y-m-d H:i:s'),
            'updator_id'=> Auth::user()->id
        ), array('id'=>$request->payment_id),'payments');
        return response()->json($data);
    }

    public function items(Request $request)
    {
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " p.status > 0 ";
        $total = u::first("SELECT count(id) AS total FROM payment_items AS p WHERE $cond ");
        $list = u::query("SELECT l.*, p.amount AS price, p.law_schedule_id ,s.date AS schedule_date, s.open_time, s.close_time, p.status AS `status`
            FROM payment_items AS p 
                LEFT JOIN law_info AS l ON l.user_id = p.law_user_id 
                LEFT JOIN law_schedules AS s ON s.id= p.law_schedule_id
            WHERE $cond ORDER BY p.id DESC $limitation");
        foreach($list AS $k=>$row){
            $list[$k]->schedule_date_time = $row->law_schedule_id ? substr($row->open_time, 0, 2)." giờ ".date('d/m/Y', strtotime($row->schedule_date)) : '';
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
}
