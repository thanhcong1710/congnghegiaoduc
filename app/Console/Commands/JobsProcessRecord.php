<?php

namespace App\Console\Commands;

use App\Http\Controllers\BigBluButtonController;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class JobsProcessRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessRecord:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessRecord';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $list_room_sessions = u::query("SELECT id AS room_session_id, room_id, code, bbb_record_get_num FROM room_sessions WHERE bbb_record_get_num <3 AND bbb_record_status!=1 AND status=2");
        foreach($list_room_sessions AS $row){
            $bbb = new BigBluButtonController();
            $bbb->getRecordByRoom($row);
        }
        u::query("INSERT INTO log_jobs (`action`, created_at) VALUES ('JobsProcessRecord','".date('Y-m-d H:i:s')."')");
        return "ok";
    }
    
}
