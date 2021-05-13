<?php


namespace App\Http\Controllers;


use App\Models\Domains;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function getManageDomains()
    {
        return view('domain_overview', [
            'title' => __("views.domains"),
            'domains' => Domains::orderBy('name', 'asc')->get(),
        ]);
    }

    public function postAddDomain(Request $request)
    {
        $aData = $this->validate($request, [
            'name' => 'required|unique:domains,name'
        ]);

        $oDomain = new Domains();
        $oDomain->name = $aData["name"];

        try {
            $oDomain->save();
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_saving_domain", ["error" => $e->getMessage()]));
        }

        return ReturnController::returnWithSuccess(__("messages.suc_saving_domain"));
    }

    public function postDeleteDomain(Request $request)
    {
        $aData = $this->validate($request, [
            'domain_name' => 'required|exists:domains,name',
            'domain_id' => 'required|exists:domains,id',
        ]);

        try {
            Domains::find($aData["domain_id"])->delete();
        } catch (\Exception $e) {
            return ReturnController::returnWithError(__("messages.error_deleting_domain", ["error" => $e->getMessage()]));
        }

        return ReturnController::returnWithSuccess(__("messages.suc_deleting_domain", ["domain" => $aData["domain_name"]]));
    }
}
