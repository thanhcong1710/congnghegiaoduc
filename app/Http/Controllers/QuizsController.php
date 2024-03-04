<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\UtilityServiceProvider as u;
use App\Providers\BigBluButtonServiceProvider as bbb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizsController extends Controller
{
    public function subjects(Request $request)
    {
        $list = u::query("SELECT s.*
            FROM vung_oi_subject AS s
            WHERE s.status=1 AND s.grade_id = $request->grade_id ORDER BY s.order");
        $grade_info = u::first("SELECT * FROM vung_oi_grades WHERE id = $request->grade_id");
        $data = [
            'list' => $list,
            'grade_info' => $grade_info
        ];
        return response()->json($data);
    }
    public function chapters(Request $request)
    {
        $subject_info = u::first("SELECT s.*, (SELECT name FROM vung_oi_grades WHERE id=s.grade_id) AS grade_name FROM vung_oi_subject AS s WHERE id = $request->subject_id");
        $list = u::query("SELECT c.*
            FROM vung_oi_chapter AS c
            WHERE c.status=1 AND c.subject_id = '$subject_info->_id' AND ( c.parent_id IS NULL OR c.parent_id ='') ORDER BY c.order");
        foreach($list AS $k=>$row){
            $list[$k]->subs = u::query("SELECT * FROM vung_oi_chapter AS c WHERE c.status=1 AND c.parent_id='$row->_id' ORDER BY c.order");
        }
        $tmp = ceil(count($list)/2) > 1 ? ceil(count($list)/2) -1 : 1;
        $data = [
            'list' => $list,
            'subject_info' => $subject_info,
            'center_id' => $list[$tmp]->id
        ];
        return response()->json($data);
    }

    // public function chapterDetail(Request $request)
    // {
    //     $chapter_info = u::first("SELECT c.*, s.id AS lms_subject_id, s.name AS subject_name, s.grade_id,
    //             (SELECT name FROM vung_oi_grades WHERE id=s.grade_id) AS grade_name 
    //         FROM vung_oi_chapter AS c 
    //             LEFT JOIN vung_oi_subject AS s ON s._id=c.subject_id
    //         WHERE c.id = $request->chapter_id");
        
    //     $pagination = (object)$request->pagination;
    //     $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
    //     $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
    //     $offset = $page == 1 ? 0 : $limit * ($page - 1);
    //     $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
    //     $cond = " q.status = 1 AND q.chapter_id='$chapter_info->_id'";

    //     $total = u::first("SELECT count(q.id) AS total FROM vung_oi_question AS q WHERE $cond ");
    //     $list = u::query("SELECT q.*
    //         FROM vung_oi_question AS q 
    //         WHERE $cond ORDER BY q.difficult_degree ,q.id DESC $limitation");
    //     foreach($list AS $k=>$ques){
    //         $list[$k]= u::convertQuestionVungOi($ques);
    //     }
    //     $data = u::makingPagination($list, $total->total, $page, $limit);
    //     $data->chapter_info = $chapter_info;
    //     return response()->json($data);
    // }

    public function chapterDetail(Request $request)
    {
        $chapter_info = u::first("SELECT c.*, s.id AS lms_subject_id, s.name AS subject_name, s.grade_id,
                (SELECT name FROM vung_oi_grades WHERE id=s.grade_id) AS grade_name 
            FROM vung_oi_chapter AS c 
                LEFT JOIN vung_oi_subject AS s ON s._id=c.subject_id
            WHERE c.id = $request->chapter_id");
        
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $limit = 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " q.status = 1 AND q.question_type=3 ";

        $total = u::first("SELECT count(q.id) AS total FROM vung_oi_question AS q WHERE $cond ");
        $list = u::query("SELECT q.*
            FROM vung_oi_question AS q 
            WHERE $cond ORDER BY q.id $limitation");

        $check_parent = '';
        foreach($list AS $k=>$ques){
            $list[$k]= u::convertQuestionVungOi($ques);
            $parent = data_get($list[$k], 'parent');
            $parent_id = data_get($parent, 'id');
            if($parent_id){
                if( $check_parent != $parent_id){
                    $check_parent = $parent_id;
                }else{
                    unset($list[$k]['parent']);
                }
            }
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        $data->chapter_info = $chapter_info;
        return response()->json($data);
    }
}
