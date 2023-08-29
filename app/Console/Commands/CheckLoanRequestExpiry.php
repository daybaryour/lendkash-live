<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Admin\CronRepository;

class CheckLoanRequestExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckLoanRequestExpiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update product offer status';

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
        \Log::info("cron loan is working.");

       CronRepository::checkLoanRequestExpiry();
    }
}
