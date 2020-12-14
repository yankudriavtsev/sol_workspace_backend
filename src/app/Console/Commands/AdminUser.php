<?php

namespace App\Console\Commands;

use App\Services\Auth\AuthService;
use Illuminate\Console\Command;

class AdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create main user with the role "Administrator"';

    private AuthService $authService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        parent::__construct();

        $this->authService = $authService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO validate inputs
        $name = $this->ask('Name');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $this->authService->registerAdminUser($name, $email, $password);
    }
}