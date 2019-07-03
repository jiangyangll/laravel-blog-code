<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WelcomeMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'print welcome message';

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
        $totalUnits = 10;
        $this->output->progressStart($totalUnits);

        $i = 0;
        while($i++ < $totalUnits){
            sleep(3);
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }
}
