<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Admin\CronRepository;

class UpdateTransferStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateTransferStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay Loan EMI';

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
       CronRepository::updateTransferStatus();
    }
}
