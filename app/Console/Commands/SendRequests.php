<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TestController;

class SendRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends multiple post requests to https://atomic.incfile.com/fakepost';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new TestController();
        $number_of_requests = 10;//You can change this number to 100K
        $controller->sendRequests($number_of_requests);
        return Command::SUCCESS;
    }
}
