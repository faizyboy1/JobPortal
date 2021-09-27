<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Job;
use Carbon\Carbon;


class ExpiredJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $current_date = Carbon::now();
        $job = Job::where('end_date', '<', $current_date)->update([
            'status' => 'expired',
        ]);
        $this->info('status update Successfully.');
    }
}
