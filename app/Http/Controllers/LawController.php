<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class LawController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " l.status = 1 ";
        if ($keyword !== '') {
            $cond .= " AND (l.name LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(l.id) AS total FROM law_info AS l WHERE $cond ");
        $list = u::query("SELECT l.*, l.id AS objectID
            FROM law_info AS l 
            WHERE $cond ORDER BY l.id DESC $limitation");

        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }

    public function getItemDetail(Request $request)
    {
        $id = isset($request->id) ? $request->id : 0;

        $data = u::first("SELECT l.*, l.id AS objectID FROM law_info AS l WHERE id = $id ");
        $arr_law_type = explode(',', $data->law_type);
        $law_type = [];
        $all_type = u::allLawType();
        foreach ($arr_law_type as $row) {
            $law_type[] = $all_type[$row];
        }
        $data->arr_law_type = $law_type;
        return response()->json($data);
    }
}
