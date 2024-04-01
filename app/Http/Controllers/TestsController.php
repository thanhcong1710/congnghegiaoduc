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
        $list = u::query("SELECT t.*, (SELECT count(id) FROM  qz_test_quizs WHERE test_id=t.id AND status=1) AS total_quiz
            FROM qz_tests AS t
            WHERE $cond ORDER BY t.id DESC $limitation");
        foreach($list AS $k=>$row){
            $list[$k]->join_link = config('app.url').'/tests/join/'.$row->code;
        }
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
                'code' => Auth::user()->id."_".uniqid(),
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
            $cond = " m.status=1 AND m.test_id = ".$test_info->id;
            $total = u::first("SELECT count(m.id) AS total FROM qz_test_quizs AS m WHERE $cond ");
            $list = u::query("SELECT m.*
                FROM qz_test_quizs AS m 
                WHERE $cond ORDER BY m.id DESC $limitation");
            foreach($list AS $k=>$ques){
                if($ques->quiz_type == 1){
                    $quiz = u::first("SELECT * FROM vung_oi_question WHERE id = $ques->quiz_id");
                    $quiz_data = u::convertQuestionVungOi($quiz);
                }
                $list[$k]->quiz_info = $quiz_data;
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
                'message' => 'Bài kiểm tra không tồn tại',
            ];
        }
        return response()->json($result);
    }

    public function all(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';
        $cond = " t.status = 1 AND t.creator_id = ".Auth::user()->id;
        if ($keyword !== '') {
            $cond .= " AND (r.title LIKE '%$keyword%')";
        }
        $list = u::query("SELECT t.*
            FROM qz_tests AS t
            WHERE $cond ORDER BY t.id DESC ");
        return response()->json($list);
    }

    public function addQuizToTest(Request $request)
    {
        $list_quiz = data_get($request, 'list_quiz', []);
        $test_id = data_get($request, 'test_id');
        $type = data_get($request, 'type');
        $duplicate = 0;
        $total_add = 0;
        foreach($list_quiz AS $quiz){
            $test_quiz_info = u::first("SELECT * FROM qz_test_quizs WHERE test_id = $test_id AND quiz_type = $type AND quiz_id = $quiz");
            if($test_quiz_info){
                if($test_quiz_info->status ==1){
                    $duplicate ++;
                }else{
                    u::updateSimpleRow(array(
                        'status' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updator_id' => Auth::user()->id
                    ), array('id'=>$test_quiz_info->id), 'qz_test_quizs');
                    $total_add ++;
                }
            }else{
                u::insertSimpleRow(array(
                    'quiz_id' => $quiz,
                    'quiz_type' => $type,
                    'test_id' => $test_id,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'creator_id' => Auth::user()->id
                ), 'qz_test_quizs');
                $total_add ++;
            }
        }

        $result = [
            'status' => 1,
            'message' => 'Thêm thành công '.$total_add.' câu hỏi. '.($duplicate > 0 ? 'Bị trùng '.$duplicate.' câu hỏi' :''),
        ];
        return response()->json($result);
    }

    public function deleteQuizFromTest(Request $request){
        $quiz_map_id = data_get($request, 'quiz_map_id');
        u::updateSimpleRow(array(
            'status' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id
        ), array('id'=>$quiz_map_id), 'qz_test_quizs');
        $result = [
            'status' => 1,
            'message' => 'Xóa câu hỏi khỏi bài kiểm tra thành công',
        ];
        return response()->json($result);
    }

    public function infoByCode(Request $request){
        $test_info = u::first("SELECT q.* , 
                (SELECT count(id) FROM  qz_test_quizs WHERE test_id=q.id AND status=1) AS total_quiz
            FROM qz_tests AS q 
            WHERE q.status =1 AND q.code = '".$request->code."'");
        if($test_info){
            $result = [
                'status' => 1,
                'message' => 'Thành công',
                'data' => $test_info
            ];  
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link kiểm tra không hợp lệ',
            ];
        }
        return response()->json($result);
    }
    
    public function joinTest(Request $request){
        $test_info = u::first("SELECT * FROM qz_tests WHERE `status`=1 AND code = '".$request->code."'");
        if($test_info){
            $client_name = data_get($request, 'name');
            $client_ip = $request->ip();
            $session_info = u::first("SELECT * FROM qz_test_sessions WHERE test_id= $test_info->id AND client_ip = '$client_ip' AND client_name='$client_name' ORDER BY id DESC");
            if($session_info){
                $code = data_get($session_info, 'code');
                if($session_info->status == 1){
                    $result = [
                        'status' => 1,
                        'message' => 'Ok',
                        'redirect_url' => config('app.url')."/tests/result/".$code
                    ];
                    return response()->json($result);
                }
            }else{
                $code = $test_info->id."_".uniqid();
                u::insertSimpleRow(array(
                    'code' => $code,
                    'test_id' => $test_info->id,
                    'client_ip' => $client_ip,
                    'client_name' => $client_name,
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'start_time' => date('Y-m-d H:i:s')
                ), 'qz_test_sessions');
            }
            
            $result = [
                'status' => 1,
                'message' => 'Ok',
                'redirect_url' => config('app.url')."/tests/take/".$code
            ];
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link tham gia không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function infoSessionByCode(Request $request){
        $test_session_info = u::first("SELECT s.id AS test_session_id,s.start_time,s.total_time,s.end_time, t.id AS test_id, t.*
            FROM qz_test_sessions AS s
            LEFT JOIN qz_tests AS t ON t.id=s.test_id
            WHERE s.status=0 AND s.code = '".$request->code."'");
        if($test_session_info){
            $tmp_time = time() - strtotime($test_session_info->start_time);
            $test_session_info->left_time = (int)$test_session_info->duration * 60 - (int)$test_session_info->total_time - (int)$tmp_time;
            $test_session_info->left_time = $test_session_info->left_time > 0 ? $test_session_info->left_time : 0;
            $result = [
                'status' => 1,
                'message' => 'ok',
                'data' => $test_session_info
            ];
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link làm bài không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function getQuizSessionByTest(Request $request){
        $cond = " m.status=1 AND m.test_id = ".$request->test_id;
        $list = u::query("SELECT m.*
            FROM qz_test_quizs AS m 
            WHERE $cond ORDER BY m.stt DESC, m.id DESC");
        foreach($list AS $k=>$ques){
            if($ques->quiz_type == 1){
                $quiz = u::first("SELECT * FROM vung_oi_question WHERE id = $ques->quiz_id");
                $quiz_data = u::convertQuestionVungOi($quiz);
                unset($quiz_data['loi_giai']);
                unset($quiz_data['dap_an']);
                $answer_info = u::first("SELECT * FROM qz_test_session_quizs WHERE test_session_id = $request->test_session_id AND test_quiz_id = $ques->id");
                $quiz_data['user_answer'] = $answer_info ? data_get($answer_info, 'answer') : '';
            }
            $list[$k]->quiz_info = $quiz_data;
        }
        return response()->json($list);
    }

    public function addAnswerQuizByUser(Request $request){
        $answer_info = u::first("SELECT * FROM qz_test_session_quizs WHERE test_session_id = $request->test_session_id AND test_quiz_id = $request->test_quiz_id");
        if($answer_info){
            u::updateSimpleRow(array(
                'answer' => $request->answer,
                'updated_at' => date('Y-m-d H:i:s')
            ), array('id'=>$answer_info->id), 'qz_test_session_quizs');
        } else{
            u::insertSimpleRow(array(
                'test_session_id' => $request->test_session_id,
                'test_quiz_id' => $request->test_quiz_id,
                'quiz_id' => $request->quiz_id,
                'quiz_type' => $request->quiz_type,
                'answer' => $request->answer,
                'created_at' => date('Y-m-d H:i:s'),
            ), 'qz_test_session_quizs');
        }
        return response()->json('ok');
    }

    public function endTest(Request $request){
        $test_session_info = u::first("SELECT * FROM qz_test_sessions WHERE `status`=0 AND id = '".$request->test_session_id."'");
        if($test_session_info){
            $quizs = data_get($request, 'quizs');
            $total_correct = 0;
            foreach($quizs AS $row){
                $test_quiz_id = data_get($row, 'id');
                $test_session_quiz_info = u::first("SELECT * FROM qz_test_session_quizs WHERE test_session_id = $request->test_session_id AND test_quiz_id = $test_quiz_id");
                $user_answer = data_get(data_get($row, 'quiz_info'), 'user_answer');
                if($user_answer){
                    $answer_result = u::getResultAnswerQuiz(data_get($row, 'quiz_id'), data_get($row, 'quiz_type'), $user_answer);
                }else{
                    $answer_result = 3;
                }
                if($test_session_quiz_info){
                    u::updateSimpleRow(array(
                        'answer' => $user_answer,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'result' => $answer_result
                    ), array('id'=>$test_session_quiz_info->id), 'qz_test_session_quizs');
                }else{
                    u::insertSimpleRow(array(
                        'test_session_id' => $request->test_session_id,
                        'test_quiz_id' => data_get($row, 'id'),
                        'quiz_id' => data_get($row, 'quiz_id'),
                        'quiz_type' => data_get($row, 'quiz_type'),
                        'answer' => $user_answer,
                        'status' => 1,
                        'result' => $answer_result,
                        'created_at' => date('Y-m-d H:i:s'),
                    ), 'qz_test_session_quizs');
                }
                if($answer_result == 1){
                    $total_correct ++;
                }
            }
            u::updateSimpleRow(array(
                'end_time' => date('Y-m-d H:i:s'),
                'total_time' => time() - strtotime($test_session_info->start_time),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1,
                'total_quiz' => count($quizs),
                'total_quiz_correct' => $total_correct ++
            ), array('id'=>$test_session_info->id), 'qz_test_sessions');
            
            $result = [
                'status' => 1,
                'message' => 'Ok',
                'redirect_url' => config('app.url')."/tests/result/".$test_session_info->code
            ];
        }else{
            $result = [
                'status' => 0,
                'message' => 'Phiên kiểm tra không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function resultSessionByCode(Request $request){
        $test_session_info = u::first("SELECT s.id AS test_session_id,s.start_time, s.client_name, s.total_time,s.end_time, s.total_quiz, s.total_quiz_correct, t.id AS test_id, t.*
            FROM qz_test_sessions AS s
            LEFT JOIN qz_tests AS t ON t.id=s.test_id
            WHERE s.status=1 AND s.code = '".$request->code."'");
        if($test_session_info){
            $result = [
                'status' => 1,
                'message' => 'ok',
                'data' => $test_session_info
            ];
        }else{
            $result = [
                'status' => 0,
                'message' => 'Link kết quả không hợp lệ',
            ];
        }
        return response()->json($result);
    }

    public function getQuizSessionResultByTest(Request $request){
        $list = u::query("SELECT q.*
            FROM qz_test_session_quizs AS q
                LEFT JOIN qz_test_quizs AS m ON m.id = q.test_quiz_id 
            WHERE q.test_session_id = $request->test_session_id ORDER BY m.stt DESC, m.id DESC");
        foreach($list AS $k=>$ques){
            if($ques->quiz_type == 1){
                $quiz = u::first("SELECT * FROM vung_oi_question WHERE id = $ques->quiz_id");
                $quiz_data = u::convertQuestionVungOi($quiz);
            }
            $list[$k]->quiz_info = $quiz_data;
        }
        return response()->json($list);
    }
}
