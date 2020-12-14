<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\AuthServiceInterface;
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
    protected $description = 'Create main user with a role "Administrator"';

    private AuthServiceInterface $authService;
    private UserRepositoryInterface $userRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        AuthServiceInterface $authService,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct();

        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->userRepository->adminExists()) {
            $this->error('User with a role "Administrator" already exists');
            
            return;
        }

        // TODO validate inputs
        $name = $this->ask('Name');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $this->authService->registerAdminUser($name, $email, $password);
    }
}