<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityServiceProvider extends ServiceProvider
{
	public static function query($query, $print = false)
	{
		$resp = null;
		$query = trim($query);
		$upperQuery = strtoupper(substr($query, 0, 6));
		if ($print) {
			dd('\n-------------------------------------------------------------\n', $query, '\n-------------------------------------------------------------\n');
		} else {
			if ($upperQuery == ('SELECT')) {
				$resp = DB::select(DB::raw($query));
			} elseif ($upperQuery == ('INSERT')) {
				$resp = DB::insert(DB::raw($query));
			} elseif ($upperQuery == ('UPDATE')) {
				$resp = DB::update(DB::raw($query));
			} elseif ($upperQuery == ('DELETE')) {
				$resp = DB::delete(DB::raw($query));
			} else {
				$resp = DB::statement(DB::raw($query));
			}
		}
		return $resp;
	}
	public static function first($query, $print = false)
	{
		$resp = self::query($query, $print);
		return $resp && is_array($resp) && count($resp) >= 1 ? $resp[0] : $resp;
	}
	public static function getOne($query)
	{
		$finalQuery = $query . " LIMIT 1";
		$resp = DB::select(DB::raw($finalQuery));
		return $resp && is_array($resp) && count($resp) >= 1 ? $resp[0] : $resp;
	}
	public static function getObject($array_input, $table, $order_by_key = '', $order_by_desc = false)
	{
		$sub_sql = '1 ';
		$sub_order = '';
		foreach ($array_input as $key => $value) {
			$sub_sql .= " AND " . $key . "= :" . $key;
		}
		if ($order_by_key != '') {
			if ($order_by_desc) {
				$sub_order = " ORDER BY $order_by_key DESC";
			} else {
				$sub_order = " ORDER BY $order_by_key ASC";
			}
		}
		$query = "SELECT * FROM " . $table . " WHERE " . $sub_sql . $sub_order . " LIMIT 1";
		$resp = DB::select(DB::raw($query), $array_input);
		return $resp && is_array($resp) && count($resp) == 1 ? $resp[0] : $resp;
	}

	public static function getMultiObject($array_input, $table, $limit = 0, $order_by_key = '', $order_by_desc = false)
	{
		$sub_sql = '1 ';
		$sub_order = '';
		$sub_limit = '';
		foreach ($array_input as $key => $value) {
			$sub_sql .= " AND " . $key . "= :" . $key;
		}
		if ($order_by_key != '') {
			if ($order_by_desc) {
				$sub_order = " ORDER BY $order_by_key DESC";
			} else {
				$sub_order = " ORDER BY $order_by_key ASC";
			}
		}
		if ($limit) {
			$sub_limit = " LIMIT $limit";
		}
		$query = "SELECT * FROM " . $table . " WHERE " . $sub_sql . $sub_order . $sub_limit;
		$resp = DB::select(DB::raw($query), $array_input);
		return $resp;
	}

	public static function insertSimpleRow($arr_params, $table)
	{
		$field = "";
		$field_value = "";
		foreach ($arr_params as $key => $value) {
			$field .= "`" . $key . "`,";
			$field_value .= ":" . $key . ",";
		}
		$field = rtrim($field, ",");
		$field_value = rtrim($field_value, ",");
		$sql = "INSERT IGNORE INTO " . $table . "(" . $field . ") VALUES (" . $field_value . ")";
		$resp = DB::insert(DB::raw($sql), $arr_params);
		return $resp ? DB::getPdo()->lastInsertId() : $resp;
	}

	public static function updateSimpleRow($arr_params, $arr_key, $table)
	{
		$set_clause = "";
		$arr_binding = array();
		foreach ($arr_params as $key => $value) {
			$set_clause .= "`" . $key . "`= :value_" . $key . ",";
			$arr_binding['value_' . $key] = $value;
		}
		$set_clause = rtrim($set_clause, ",");

		$sql_cond = '1=1';
		foreach ($arr_key as $key => $value) {
			$sql_cond .= ' AND ' . $key . "= :key_" . $key;
			$arr_binding['key_' . $key] = $value;
		}
		if ($set_clause != '') {
			$sql = 'UPDATE ' . $table . ' SET ' . $set_clause . ' WHERE ' . $sql_cond;
			$resp = DB::update(DB::raw($sql), $arr_binding);
			return $resp;
		}
	}
	public static function makingPagination($list, $total, $page, $limit)
	{
		$pagination = (object)[];
		$data = (object)[];
		$pagination->spage = 1;
		$pagination->cpage = $page;
		$pagination->total = $total;
		$pagination->limit = $limit;
		$pagination->lpage = ($total % $limit) == 0 ? (int)($total / $limit) : (int)($total / $limit) + 1;
		$pagination->ppage = $page > 0 ? $page - 1 : 0;
		$pagination->npage = $page < $pagination->lpage ? $page + 1 : $pagination->lpage;
		$data->list = $list;
		$data->paging = $pagination;
		return $data;
	}
	public static function update_file_name($file) 
	{
	  $pos = strrpos($file,'.');
	  $ext = substr($file,$pos); 
	  $dir = strrpos($file,'/');
	  $dr  = substr($file,0,($dir+1)); 
  
	  $arr = explode('/',$file);
	  $fName = self::convert_slug(trim($arr[(count($arr) - 1)],$ext));
  
	  $exist = FALSE;
	  $i = 0;
	  
	  while(!$exist)
	  {
		$file = $i > 0 ? $dr.$fName.'_'.$i.$ext : $dr.$fName.$ext;
		
		if(!file_exists($file))
		  $exist = TRUE;
		
		$i++;
	  }
  
	  return $file;
	}
	public static function convertPhoneNumber($phone_number)
	{
		if (substr($phone_number, 0, 2) == '84') {
			$phone_number = '0' + substr($phone_number, 2, strlen($phone_number));
		}
		return $phone_number;
	}
	public static function transformUser($data)
	{
		return array(
			'displayName' => data_get($data, 'name'),
			'name' => data_get($data, 'name'),
			'email' =>  data_get($data, 'email'),
			'phone' => data_get($data, 'phone'),
			'photoURL' => "/images/avatar-s-5.jpg?99691e543d9e33cf745f6ac56f5800b8",
			'providerId' => "jwt",
			'uid' => data_get($data, 'id'),
			'address' => data_get($data, 'address'),
			'birthday' => data_get($data, 'birthday') ? date('d/m/Y', strtotime(data_get($data, 'birthday'))) : null,
			'note' => data_get($data, 'note'),
			'gender' => data_get($data, 'gender'),
		);
	}
	public static function convert_slug($str) {
		
        $str = trim(mb_strtolower($str));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		$str = preg_replace('/([\s]+)/', '_', $str);
		return $str;
    }

	public static function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? self::xml2array ( $node ) : $node;
    
        return $out;
    }

	public static function genMaSo($text,$number){
		if(strlen($text)< $number){
			$tmp=$text;
			for($i=strlen($text);$i<$number;$i++){
				$tmp= '0'.$tmp;
			}
			$text=$tmp;
		}
		return $text;
    }

	public static function convertQuestionVungOi($quiz_info){
		$quiz_content = json_decode($quiz_info->content);
		$answer = json_decode($quiz_info->answer);
		$data = [
			'id'=>$quiz_info->id,
			'parent'=>[]
		];
		if($quiz_info->question_type ==1){
			$arr_content = data_get(data_get($quiz_content,'question'),'content');
			$data['noi_dung'] = self::genTextVungOi($arr_content);

			$data['lua_chon']=[];
			$arr_option = data_get(data_get($quiz_content,'question'),'answers');
			foreach($arr_option AS $op){
				$data['lua_chon'][] =[
					'answer_key' => data_get($op, 'answer_key'),
					'id' => data_get($op, 'id'),
					'noi_dung' => self::genTextVungOi(data_get($op,'text'))
				];
			}
			$data['dap_an']=data_get($answer, 'solution_key');
			$data['loi_giai']= self::genTextVungOi(data_get($answer,'solution_detail'));
		} elseif($quiz_info->question_type ==2){
			$question = data_get($quiz_content,'question');
			$parent = data_get($question, 'parent');
			$sub_question = data_get($question,'question');
			if(!empty($parent)){
				$data['parent'] =[
					'id' => data_get($parent,'id'),
					'noi_dung' => self::genTextVungOi(data_get($parent,'content'))
				];
				$data['noi_dung'] = self::genTextVungOi(data_get($sub_question, 'content'));
				$data['lua_chon']=[];
				$arr_option = data_get($sub_question,'answers');
				foreach($arr_option AS $op){
					$data['lua_chon'][] =[
						'answer_key' => data_get($op, 'answer_key'),
						'id' => data_get($op, 'id'),
						'noi_dung' => self::genTextVungOi(data_get($op,'text'))
					];
				}
				$data['dap_an']=data_get($answer, 'solution_key');
				$data['loi_giai']= self::genTextVungOi(data_get($answer,'solution_detail'));
			} else{
				dd($data);
			}
			
		}
		return $data;
	}
	
	public static function genTextVungOi($data){
		$result = '';
		foreach($data AS $row){
			if(data_get($row, 'type') == 'html'){
				$result.=data_get($row, 'content');
			} elseif(data_get($row, 'type') == 'image'){
				$result.='<div class="text-center"><img class="image-item" src="'.data_get($row, 'url').'" title="alt=" style="max-width: 100%; margin: auto;"></div>';
			}else{
				dd($data);
			}
		}
		return $result;
	}
}
