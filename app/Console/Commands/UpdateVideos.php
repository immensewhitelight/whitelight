<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class UpdateVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update videos';

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
    public function handle()
    {
        $controller = new \App\Orchid\Screens\VideoListScreen();
        $controller->retrieveVideoUrls();
    }
}
