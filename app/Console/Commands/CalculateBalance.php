<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:balance';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command calculates the balance os each user with active investment daily.';
    
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
        
    }
}
