<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Assorted;

class UpdateAssorteds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:assorteds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update assorteds';

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
        $controller = new \App\Orchid\Screens\AssortedListScreen();
        $controller->retrieveAssortedUrls();
    }
}
