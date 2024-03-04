<?php

namespace App\Console\Commands;

use App\Http\Controllers\CrawlVungOiController;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class JobsConvertContentVungOi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'JobsConvertContentVungOi:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JobsConvertContentVungOi';

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
        $list_data = u::query("SELECT id, content FROM vung_oi_question WHERE is_convert=0 LIMIT 10000");
        foreach($list_data AS $row){
            $content = json_decode($row->content);
            $type = data_get(data_get($content, 'question'), 'type');
            u::updateSimpleRow(array('type'=>$type,'is_convert'=>1), array('id'=>$row->id), 'vung_oi_question');
            echo $row->id."/";
        }
        return "ok";
    }
    
}
