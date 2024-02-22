<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;
use Exception;
use GuzzleHttp\Client;

class CrawlVungOiController extends Controller
{
    public function vungOiGetSubject(){
        // anv123 / abcd1234
        // subject
        for($i=1;$i<13;$i++){
            $url = "https://api.vungoi.vn/admin/v1/chapters/grade/".$i;
            $params = [];
            $headers = [
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFudjEyMyIsImlkIjoiNjVkNDc1MTYxZTczMzkyODJkYjdiMzgyIiwiaXNHdWVzdCI6ZmFsc2UsImlzX3Rlc3QiOmZhbHNlLCJpYXQiOjE3MDg0MjI0MzN9._PVyMqEVJyMZrx50xsNifoFv75ET40T6XNnYMwKnzZ4'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            foreach($data['subjects'] AS $subject){
                u::insertSimpleRow([
                    'book_id' => $subject['book']['id'],
                    'grade_id' => $i,
                    'type' => $subject['type'],
                    '_id' => $subject['_id'],
                    'name'=>$subject['name'],
                ],'vung_oi_subject');
            }   
        }
        
        return "ok";
    }

    public function vungOiGetChapter(){
        // anv123 / abcd1234
        // chapters
        $list_subject = u::query("SELECT * FROM vung_oi_subject WHERE is_crawl=0");
        foreach($list_subject AS $subject){
            $url = "https://api.vungoi.vn/admin/v1/chapters_quiz/subject/".$subject->_id;
            $params = [];
            $headers = [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFudjEyMyIsImlkIjoiNjVkNDc1MTYxZTczMzkyODJkYjdiMzgyIiwiaXNHdWVzdCI6ZmFsc2UsImlzX3Rlc3QiOmZhbHNlLCJpYXQiOjE3MDg0MjI0MzN9._PVyMqEVJyMZrx50xsNifoFv75ET40T6XNnYMwKnzZ4'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            foreach($data['chapters'] AS $chapter){
                u::insertSimpleRow([
                    '_id' => $chapter['_id'],
                    'title'=>$chapter['title'],
                    'order' => $chapter['order'],
                    'icon' => $chapter['icon'],
                    'parent_id' => $chapter['parent_id'],
                    'subject_id'=>$subject->_id
                ],'vung_oi_chapter');
                foreach($chapter['childs'] AS $child){
                    u::insertSimpleRow([
                        '_id' => $child['_id'],
                        'title'=>$child['title'],
                        'order' => $child['order'],
                        'icon' => $child['icon'],
                        'parent_id' => $child['parent_id'],
                        'subject_id'=>$subject->_id
                    ],'vung_oi_chapter');
                };
            }
            u::updateSimpleRow([
                'order'=>$data['order'],
                'data_response' =>json_encode($data),
                'is_crawl'=>1
            ],array('id'=>$subject->id),'vung_oi_subject');   
            echo $subject->id."/";
        }
        
        return "ok";
    }

    public function vungOiQuestion($chapter_id){
        try{
            // questions
            $url = "https://api.vungoi.vn/admin/v1/quiz/startNew/chapter/$chapter_id?exerciseType=0";
            $params = [];
            $headers = [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFudjEyMyIsImlkIjoiNjVkNDc1MTYxZTczMzkyODJkYjdiMzgyIiwiaXNHdWVzdCI6ZmFsc2UsImlzX3Rlc3QiOmZhbHNlLCJpYXQiOjE3MDg0MjI0MzN9._PVyMqEVJyMZrx50xsNifoFv75ET40T6XNnYMwKnzZ4'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            u::insertSimpleRow([
                '_id'=>$data['quiz']['_id'],
                'content'=>json_encode($data['quiz']),
                'difficult_degree'=>isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                'question_type'=>$data['quiz']['question_type'],
                'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                'parent_id'=>isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                'chapter_id'=>$chapter_id,
                'question_id' => data_get($data['quiz']['question'],'_id'),
                'question_content'=>json_encode($data['quiz']['question']),
            ],'vung_oi_question');
            $quiz_id = $data['quiz']['_id'];
            $session = $data['session'];
            $option = $data['quiz']['question'];
            $grade = data_get($data, 'grade');
            $subject = data_get($data, 'subject');
            $chapter = data_get($data, 'chapter');
            $run=1;
            while($run == 1) {
                $url = "https://api.vungoi.vn/admin/v1/quiz_session/$session/answer";
                $choice = [];
                if(isset($option['quiz']['option']['items'])){
                    $check = 0;
                    foreach($option['quiz']['option']['items'] AS $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> $check == 0 ? true :false
                        ];
                        $check = 1;
                    }
                }else if(isset($option['quiz']['mathquill_content']['items'])){
                    foreach($option['quiz']['mathquill_content']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>'mInputText_'.($k+1),
                            "answer"=> ""
                        ];
                    }
                }else if(isset($option['quiz']['paragraph']['items'])){
                    foreach($option['quiz']['paragraph']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> [
                                "index"=>$k+1
                            ]
                        ];
                    }
                }else if(isset($option['answers'])){
                    $i=rand(0,(count($option['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['answers'][$i]['answer_key']
                    ];
                }else{
                    $i=rand(0,(count($option['question']['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['question']['answers'][$i]['answer_key']
                    ];
                }
                $params = [
                    "grade"=> $grade,
                    "subject"=> $subject,
                    "chapter"=> $chapter,
                    "question_id"=> $quiz_id,
                    "learning_time"=> 10,
                    "choice"=> $choice
                ];
                $headers = [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFudjEyMyIsImlkIjoiNjVkNDc1MTYxZTczMzkyODJkYjdiMzgyIiwiaXNHdWVzdCI6ZmFsc2UsImlzX3Rlc3QiOmZhbHNlLCJpYXQiOjE3MDg0MjI0MzN9._PVyMqEVJyMZrx50xsNifoFv75ET40T6XNnYMwKnzZ4'
                ];
            
                $client = new Client();
                $response = $client->request('POST',$url,[
                    'headers' => $headers,
                    'verify' => false,
                    'body' =>json_encode($params)
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                u::updateSimpleRow(['answer'=>json_encode($data['answer'])],['_id'=>$quiz_id],'vung_oi_question');
                
                if(!empty($data['quiz'])){
                    $quiz_id = $data['quiz']['_id'];
                    $session = $data['session'];
                    $option = $data['quiz']['question'];
                    u::insertSimpleRow([
                        '_id'=>$data['quiz']['_id'],
                        'content'=>json_encode($data['quiz']['question']),
                        'difficult_degree'=> isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                        'question_type'=>$data['quiz']['question_type'],
                        'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                        'parent_id'=> isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                        'chapter_id'=>$chapter_id
                    ],'vung_oi_question');
                }else{
                    $run=0;
                }
            }
            u::updateSimpleRow(['is_crawl'=>1],['_id'=>$chapter_id],'vung_oi_chapter');
        }catch(Exception $e){
            u::updateSimpleRow(['is_crawl'=>2],['_id'=>$chapter_id],'vung_oi_chapter');
        }
    }
}
