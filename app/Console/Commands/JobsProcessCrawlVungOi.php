<?php

namespace App\Console\Commands;

use App\Http\Controllers\CrawlVungOiController;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class JobsProcessCrawlVungOi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessCrawlVungOi:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessCrawlVungOi';

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
        $tmp =new CrawlVungOiController();

        // $tmp->vungOiGetSubject();

        // $tmp->vungOiGetChapter();

        $chapters = u::query("SELECT  * FROM vung_oi_chapter WHERE is_crawl=0 AND parent_id IS NOT NULL AND parent_id!='' LIMIT 30");
        $list_update = '';
        foreach($chapters AS $chap){
            $list_update.= $list_update ? ",".$chap->id : $chap->id;
        }
        u::query("UPDATE vung_oi_chapter SET is_crawl = 5 WHERE id IN($list_update)");
        u::query("INSERT INTO log_jobs (`action`, created_at) VALUES ('jobsProcessCrawlVungOi','".date('Y-m-d H:i:s')."')");
        foreach($chapters AS $chap){
            $tmp->vungOiQuestion($chap->_id);
            echo $chap->id."/";
        }

        // $chapter_error =  u::query("SELECT  * FROM vung_oi_chapter WHERE is_crawl=2 AND parent_id IS NOT NULL AND parent_id!='' ");
        // foreach($chapter_error AS $chap){
        //     $tmp->vungOiQuestion($chap->_id);
        //     echo $chap->id."/";
        // }
        return "ok";
    }
    
}
