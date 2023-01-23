<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TestController;

class SendRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends a simple post request to https://atomic.incfile.com/fakepost';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new TestController();
        $controller->sendRequest();
        return Command::SUCCESS;
    }
}
