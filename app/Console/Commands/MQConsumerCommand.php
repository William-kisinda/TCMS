<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Tcms\TokenGeneration\Config\Connection;
use App\Http\Controllers\Tcms\TokenGeneration\Api\TokenGenerateController;

class MQConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume the mq queue';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tokenGenerateMqService = app(TokenGenerateController::class);
        $tokenGenerateMqService->consumeMessages();
    }
}
