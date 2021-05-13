<?php

namespace App\Console\Commands;

use App\Http\Controllers\AuthController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a backend user';

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
        $oAuthController = new AuthController();

        if ($this->confirm("Are you sure that you want to delete the user '{$username}'?")) {
            $aReturn = $oAuthController->deleteUser($username);

            if ($aReturn["status"] == "error") {
                $this->error($aReturn["message"]);
            } else {
                $this->info($aReturn["message"]);
            }
        }
    }
}
