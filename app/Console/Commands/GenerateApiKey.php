<?php

namespace App\Console\Commands;

use App\Modules\Auth\ApiKey\Actions\GenerateApiKey as GenerateApiKeyAction;
use App\Modules\User\User;
use Illuminate\Console\Command;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-api-key {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API key for a user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');

        $user = User::find($userId);

        $apiKey = app(GenerateApiKeyAction::class)->execute($user);

        $this->info("Generated API Key: " . $apiKey->value);
    }
}
