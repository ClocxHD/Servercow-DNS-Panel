<?php

namespace App\Http\Controllers;

use App\Models\Domains;
use App\Models\Records;

class HomeController extends Controller
{
    public function homeView()
    {
        $oRecords = Records::orderBy("name", "asc")->get();
        $oDomains = Domains::orderBy("name", "asc")->get();
        $aUpdated = [];
        $aRecordCountByDomain = [];

        foreach ($oRecords as $oRecord) {
            if (empty($aRecordCountByDomain[$oRecord->domains_id])) {
                $aRecordCountByDomain[$oRecord->domains_id] = 0;
            }

            $aRecordCountByDomain[$oRecord->domains_id]++;

            $last_update = $oRecord->created_at;
            $since_update = $last_update->diff(now());

            if ($since_update->h != 0) {
                $since_update_text = trans_choice("views.last_update_text_hours", $since_update->h, ["hours" => $since_update->h, "date" => $last_update]);
                #$since_update_text = $since_update->h . " Stunde" . ($since_update->h > 1 ? "n ":" ") . $since_update->i . " Minuten";
            } else {
                $since_update_text = trans_choice("views.last_update_text_minutes", $since_update->i, ["minutes" => $since_update->i, "date" => $last_update]);
                #$since_update_text = $since_update->i . " Minuten";
            }

            $aUpdated[$oRecord->domains_id] = [
                'diff' => $since_update,
                'text' => $since_update_text,
                'timestamp' => $last_update,
            ];
        }

        return view('home', [
            'title' => 'Home',
            'records' => $oRecords,
            'update' => $aUpdated,
            'domains' => $oDomains,
            'recordCount' => $aRecordCountByDomain,
        ]);
    }
}
