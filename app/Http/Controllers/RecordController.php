<?php

namespace App\Http\Controllers;

use App\Models\Domains;
use App\Models\Records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RecordController extends Controller
{
    public function fetchRecords($domain): \Illuminate\Support\Collection
    {
        $response = Http::withHeaders([
            'X-Auth-Username' => env('SERVERCOW_API_USER'),
            'X-Auth-Password' => env('SERVERCOW_API_PASS'),
            'Content-Type' => 'application/json',
        ])->get(env('SERVERCOW_API_URL') . $domain);

        return $response->collect();
    }

    public function getRecordJSON($iRecordId)
    {
        $oRecord = Records::find($iRecordId);
        $oDomain = $oRecord->domain;
        $oRecord = collect($oRecord);
        $oRecord->put("domain", $oDomain->name);

        return response()->json($oRecord);
    }

    public function getAddRecords()
    {
        return view('record_add', [
            'title' => __("views.add_record"),
            'domains' => Domains::orderBy('name', 'asc')->get(),
        ]);
    }

    public function postAddRecord(Request $request)
    {
        $aData = $this->validate($request, [
            "type" => "required",
            "name" => "",
            "content" => "required",
            "ttl" => "required|integer",
            "domain" => "required|exists:domains,id",
        ]);

        if ($aData["name"] === null) {
            $aData["name"] = "";
        }

        /**
         * Records with the types specified in the array can exist multiple times with the same name, therefore the content needs to be an array so that the existing records does not get lost
         */
        $aRecords = [];
        $blRecordArray = false;

        if (in_array($aData["type"], ["mx", "txt", "caa", "tlsa"])) {
            $blRecordArray = true;

            $oRecords = Records::where([
                ['name', $aData["name"]],
                ['type', $aData["type"]],
                ['domains_id', $aData["domain"]],
            ])->get();

            foreach ($oRecords as $oRecord) {
                array_push($aRecords, $oRecord->content);
            }

            array_push($aRecords, $aData["content"]);
        }
        //--

        if ($aData["type"] == "mx" && !$this->startsWithNumber($aData["content"])) {
            $aData["content"] = "10 " . $aData["content"];
        }

        $sDomainName = Domains::find($aData["domain"])->name;

        try {
            $request = Http::withHeaders([
                'X-Auth-Username' => env('SERVERCOW_API_USER'),
                'X-Auth-Password' => env('SERVERCOW_API_PASS'),
                'Content-Type' => 'application/json',
            ])->post(env('SERVERCOW_API_URL') . $sDomainName, [
                "type" => $aData["type"],
                "name" => $aData["name"],
                "content" => $blRecordArray ? json_encode($aRecords) : $aData["content"],
                "ttl" => $aData["ttl"]
            ]);

            $aReturn = $request->json();

            if (array_key_exists("error", $aReturn)) {
                return ReturnController::returnWithError(__("messages.error_saving_record", ["error" => $aReturn["error"]]));
            }
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_saving_record", ["error" => $e->getMessage()]));
        }

        if (env('FETCH_RECORDS_AFTER_CHANGE')) {
            $this->getNewRecordsForDomain($sDomainName, $aData["domain"]);
        }

        return ReturnController::returnWithSuccess(__("messages.suc_saving_record"));
    }

    public function postDeleteRecord(Request $request)
    {
        $aData = $this->validate($request, [
            'type' => 'required',
            'name' => '',
            'domain_name' => 'required|exists:domains,name',
            'domain_id' => 'required|integer|exists:domains,id'
        ]);

        if ($aData["name"] === null) {
            $aData["name"] = "";
        }

        try {
            $request = Http::withHeaders([
                'X-Auth-Username' => env('SERVERCOW_API_USER'),
                'X-Auth-Password' => env('SERVERCOW_API_PASS'),
                'Content-Type' => 'application/json',
            ])->delete(env('SERVERCOW_API_URL') . $aData["domain_name"], $aData);

            $aReturn = $request->json();

            if (array_key_exists("error", $aReturn)) {
                return ReturnController::returnWithError(__("messages.error_deleting_record", ["error" => $aReturn["error"]]));
            }
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_deleting_record", ["error" => $e->getMessage()]));
        }

        if (env('FETCH_RECORDS_AFTER_CHANGE')) {
            $this->getNewRecordsForDomain($aData["domain_name"], $aData["domain_id"]);
        }

        return ReturnController::returnWithSuccess(__("messages.suc_deleting_record", ["record" => $aData["name"]]));
    }

    public function postEditRecord(Request $request)
    {
        $aData = $this->validate($request, [
            'record_id' => 'required|exists:records,id',
            'content' => 'required',
            'ttl' => 'required|integer'
        ]);

        $oRecord = Records::find($aData["record_id"]);

        try {
            $request = Http::withHeaders([
                'X-Auth-Username' => env('SERVERCOW_API_USER'),
                'X-Auth-Password' => env('SERVERCOW_API_PASS'),
                'Content-Type' => 'application/json',
            ])->post(env('SERVERCOW_API_URL') . $oRecord->domain->name, [
                "type" => $oRecord->type,
                "name" => $oRecord->name,
                "content" => $aData["content"],
                "ttl" => $aData["ttl"]
            ]);

            $aReturn = $request->json();

            if (array_key_exists("error", $aReturn)) {
                return ReturnController::returnWithError(__("messages.error_editing_record", ["error" => $aReturn["error"]]));
            }
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_editing_record", ["error" => $e->getMessage()]));
        }

        if (env('FETCH_RECORDS_AFTER_CHANGE')) {
            $this->getNewRecordsForDomain($oRecord->domain->name, $oRecord->domain->id);
        }

        return ReturnController::returnWithSuccess(__("messages.suc_editing_record"));
    }

    public function getNewRecords($sDomainName, $iDomainId)
    {
        try {
            $this->getNewRecordsForDomain($sDomainName, $iDomainId);
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_fetching_records", ["error" => $e->getMessage()]), "", false, $iDomainId);
        }

        return ReturnController::returnWithSuccess(__("messages.suc_fetching_records", ["domain" => $sDomainName]), "", false, $iDomainId);
    }

    public function getNewRecordsForDomain($sDomainName, $iDomainId)
    {
        try {
            DB::table('records')->where('domains_id', $iDomainId)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        $oAPIRecords = $this->fetchRecords($sDomainName);

        foreach ($oAPIRecords as $oAPIRecord) {
            $oRecord = new Records();
            $oRecord->name = $oAPIRecord["name"];
            $oRecord->ttl = $oAPIRecord["ttl"];
            $oRecord->type = $oAPIRecord["type"];
            $oRecord->content = $oAPIRecord["content"];
            $oRecord->domains_id = $iDomainId;

            try {
                $oRecord->save();
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    public function startsWithNumber($string) {
        return strlen($string) > 0 && ctype_digit(substr($string, 0, 1));
    }
}
