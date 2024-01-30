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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BigBluButtonController extends Controller
{
    public function createRoom(Request $request)
    {
        $bbb = new BigBlueButton();
        $meetingID = 'demo11';
        $meetingName = 'DEMO 10';
        $attendee_password = '123456';
        $moderator_password = 'acbd1234';
        $duration = 300;
        $urlLogout = 'https://law.dapanh.com/';
        $isRecordingTrue = true;
        $welcomeMessage = "Welcome to congnghegiaoduc.com";

        $createMeetingParams = new CreateMeetingParameters($meetingID, $meetingName);
        $createMeetingParams->setAttendeePassword($attendee_password);
        $createMeetingParams->setModeratorPassword($moderator_password);
        $createMeetingParams->setDuration($duration);
        $createMeetingParams->setLogoutUrl($urlLogout);
        $createMeetingParams->setWelcomeMessage($welcomeMessage);
        $createMeetingParams->addPresentation('https://didongviet.vn/dchannel/wp-content/uploads/2023/08/hinh-nen-3d-hinh-nen-iphone-dep-3d-didongviet@2x.jpg');
        if ($isRecordingTrue) {
            $createMeetingParams->setRecord(true);
            $createMeetingParams->setAllowStartStopRecording(true);
            $createMeetingParams->setAutoStartRecording(true);
        }

        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            return 'Can\'t create room! please contact our administrator.';
        } else {
            var_dump($this->xml2array($response->getRawXml()));die();
            die();
        }
        return response()->json($response);
    }

    public function joinRoom(Request $request)
    {
        $bbb = new BigBlueButton();
        $meetingID = 'demo9';
        $name = 'conglt';
        $password = 'acbd1234';

        $joinMeetingParams = new JoinMeetingParameters($meetingID, $name, $password);
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        var_dump($url);
        die();
        return response()->json("ok");
    }

    public function endRoom(Request $request)
    {
        $bbb = new BigBlueButton();
        $meetingID = 'demo6';
        $moderator_password = 'acbd1234';

        $endMeetingParams = new EndMeetingParameters($meetingID, $moderator_password);
        $response = $bbb->endMeeting($endMeetingParams);
        var_dump($response);die();
        return response()->json("ok");
    }

    public function getRoomInfo()
    {
        $bbb = new BigBlueButton();
        $meetingID = '6_session_65b22815038a2';
        $moderator_password = '6_moderator_65b22815038a5';

        $getMeetingInfoParams = new GetMeetingInfoParameters($meetingID, $moderator_password);
        $response = $bbb->getMeetingInfo($getMeetingInfoParams);
        var_dump($response);
        die();
        if ($response->getReturnCode() == 'FAILED') {
            // meeting not found or already closed
        } else {
            var_dump($response);
            die();
        }
        return response()->json("ok");
    }

    public function getListRoom()
    {
        $bbb = new BigBlueButton();
        $response = $bbb->getMeetings();
        if ($response->getReturnCode() == 'SUCCESS') {
            foreach ($response->getRawXml()->meetings->meeting as $meeting) {
                // process all meeting
                var_dump($meeting);die();
            }
        }
        return response()->json("ok");
    }

    public function getRecords()
    {
        $recordingParams = new GetRecordingsParameters();
        $recordingParams->setMeetingId('6_session_65b232a95d835') ;
        $bbb = new BigBlueButton();
        $response = $bbb->getRecordings($recordingParams);
        if ($response->getReturnCode() == 'SUCCESS') {
            foreach ($response->getRawXml()->recordings->recording as $recording) {
                $recording = (object)$this->xml2array($recording);
                var_dump($recording->playback);die();
                // process all recording
            }
        }
        return response()->json("ok");
    }

    public function deleteRecord()
    {
        $recordingID = 'demo4';
        $bbb = new BigBlueButton();
        $deleteRecordingsParams= new DeleteRecordingsParameters($recordingID); // get from "Get Recordings"
        $response = $bbb->deleteRecordings($deleteRecordingsParams);

        if ($response->getReturnCode() == 'SUCCESS') {
            // recording deleted
        } else {
            // something wrong
        }
    }
    
    private function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;
    
        return $out;
    }


    public function webHook(Request $request){
        $params = $request->input();
        $event = data_get($params, 'event');
        if($event){
            $event = json_decode($event,true);
            if(isset($event[0])){
                $data = data_get($event[0], 'data');
                if(data_get($data, 'id')== 'meeting-ended'){
                    $attributes = data_get($data, 'attributes');
                    $meeting = data_get($attributes, 'meeting');
                    $internal_meeting_id = data_get($meeting, 'internal-meeting-id');
                    if($internal_meeting_id){
                        $timestamp = ceil($data['event']['ts']/1000);
                        u::updateSimpleRow(array('status'=>2, 'end_time'=> date('Y-m-d H:i:s', $timestamp)), array('bbb_internal_meeting_id'=>$internal_meeting_id),'room_sessions');
                    }
                }
            }
        }
        return response()->json("ok");
    }

    public function getRecordByRoom($room_session_info){
        $recordingParams = new GetRecordingsParameters();
        $recordingParams->setMeetingId($room_session_info->code) ;
        $bbb = new BigBlueButton();
        $response = $bbb->getRecordings($recordingParams);
        if ($response->getReturnCode() == 'SUCCESS') {
            foreach ($response->getRawXml()->recordings->recording as $recording) {
                $recording = (object)$this->xml2array($recording);
                if(data_get($recording, 'recordID')){
                    $playback = data_get($recording, 'playback');
                    $format = data_get($playback, 'format');
                    $link = data_get($format, 'url');
                    if($link){
                        u::insertSimpleRow(array(
                            'room_id' =>  data_get($room_session_info, 'room_id'),
                            'room_session_id' => data_get($room_session_info, 'room_session_id'),
                            'bbb_record_id' => data_get($recording, 'recordID'),
                            'bbb_record_link' => $link,
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                        ), 'room_session_records');
                        u::updateSimpleRow(array('bbb_record_status'=>1), array('id'=>data_get($room_session_info, 'room_session_id')), 'room_sessions');
                    }
                }
            }
        }
        u::updateSimpleRow(array('bbb_record_get_num'=>(int)data_get($room_session_info, 'bbb_record_get_num') +1), array('id'=>data_get($room_session_info, 'room_session_id')), 'room_sessions');
        return true;
    }
}