<?php

namespace App\Console\Commands;

use App\Http\Controllers\AuthController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new backend user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        App::setLocale("en");

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->secret('What is the password?');
        $oAuthController = new AuthController();

        $aReturn = $oAuthController->createUser($username, $password);

        if ($aReturn["status"] == "error") {
            $this->error($aReturn["message"]);
        } else {
            $this->info($aReturn["message"]);
        }
    }
}
