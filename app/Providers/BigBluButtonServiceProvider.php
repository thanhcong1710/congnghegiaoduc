<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\GetRecordingsParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;
use BigBlueButton\Parameters\EndMeetingParameters;

class BigBluButtonServiceProvider extends ServiceProvider
{
	public static function createRoom($roomID, $meetingName,$presentation, $duration, $urlLogout,$welcomeMessage, $isRecordingTrue=true)
    {
        $bbb = new BigBlueButton();
		$meetingID = $roomID."_session_".uniqid();
        $password_attendee = $roomID."_attendee_".uniqid();
        $password_moderator = $roomID."_moderator_".uniqid();

        $createMeetingParams = new CreateMeetingParameters($meetingID, $meetingName);
        $createMeetingParams->setAttendeePassword($password_attendee);
        $createMeetingParams->setModeratorPassword($password_moderator);
        $createMeetingParams->setDuration($duration);
        $createMeetingParams->setLogoutUrl($urlLogout);
        $createMeetingParams->setWelcomeMessage($welcomeMessage);
		foreach($presentation AS $pr){
			$file_url = config('app.url')."/".data_get($pr,'file_url');
			$createMeetingParams->addPresentation($file_url);
		}
        
        if ($isRecordingTrue) {
            $createMeetingParams->setRecord(true);
            $createMeetingParams->setAllowStartStopRecording(true);
            $createMeetingParams->setAutoStartRecording(true);
        }

        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            return [
				'status' => 0,
				'message' => 'Không tạo được phòng họp. Vui lòng liên hệ với quản trị viên để được hỗ trợ.'
			];
        } else {
            return [
				'status' => 1,
				'message' => 'Ok',
				'data' => [
					'meetingID' => $meetingID,
					'password_attendee' => $password_attendee,
					'password_moderator' => $password_moderator,
				]
			];
        }
    }

	public static function joinRoom($meetingID, $name, $password)
    {
        $bbb = new BigBlueButton();

        $joinMeetingParams = new JoinMeetingParameters($meetingID, $name, $password);
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
       	return $url;
    }
}
