<?php

namespace App\Console\Commands;

use App\Http\Controllers\RecordController;
use App\Models\Domains;
use App\Models\Records;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FetchRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dns-records:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the current DNS Records';

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
        $oDomains = Domains::all();

        if ($oDomains->isEmpty()) {
            $this->warn('No Domains, exiting!');
            exit();
        }

        try {
            DB::table('records')->truncate();
        } catch (\Exception $e) {
            $this->error('Error while truncating the records table: ' . $e->getMessage());
        }

        $oRecordController = new RecordController();

        foreach ($oDomains as $oDomain) {
            $oAPIRecords = $oRecordController->fetchRecords($oDomain->name);
            $iRecords = $oAPIRecords->count();

            foreach ($oAPIRecords as $oAPIRecord) {
                $oRecord = new Records();
                $oRecord->name = $oAPIRecord["name"];
                $oRecord->ttl = $oAPIRecord["ttl"];
                $oRecord->type = $oAPIRecord["type"];
                $oRecord->content = $oAPIRecord["content"];
                $oRecord->domains_id = $oDomain->id;

                try {
                    $oRecord->save();
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            }

            $this->info("Success! Saved {$iRecords} records for Domain {$oDomain->name} to the database!");
        }
    }
}
