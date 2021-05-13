<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function postLogin(Request $request)
    {
        $aData = $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required',
            'remember' => '',
        ]);

        $blRememberMe = false;

        if (isset($aData["remember"])) {
            $blRememberMe = true;
        }

        if (Auth::attempt([
            'username' => $aData["username"],
            'password' => $aData["password"]
        ], $blRememberMe)) {
            return ReturnController::returnWithSuccess(__("messages.suc_login"), "/");
        } else {
            return ReturnController::returnWithError(__("messages.err_login"), "", true);
        }
    }

    public function getChangePassword()
    {
        return view('auth.change-password', [
            'title' => __("views.change_password")
        ]);
    }

    public function postChangePassword(Request $request)
    {
        $aData = $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $aReturn = $this->changePassword(Auth::user()->username, $aData["old_password"], $aData["new_password"]);

        if ($aReturn["status"] == "error") {
            return ReturnController::returnWithError($aReturn["message"]);
        } else {
            return ReturnController::returnWithSuccess($aReturn["message"]);
        }
    }

    public function changePassword(string $username, string $current_password, string $new_password): array
    {
        $oUser = User::where('username', $username)->first();

        if (!Hash::check($current_password, $oUser->password)) {
            return [
                "status" => "error",
                "message" => __("messages.old_password_incorrect"),
            ];
        }

        $oUser->password = Hash::make($new_password);

        try {
            $oUser->save();
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => __("messages.error_changing_password", ["error" => $e->getMessage()]),
            ];
        }

        return [
            "status" => "ok",
            "message" => __("messages.suc_changing_password"),
        ];
    }

    public function createUser(string $username, string $password): array
    {
        if (!User::where('username', $username)->get()->isEmpty()) {
            return [
                "status" => "error",
                "message" => __("messages.err_user_existing"),
            ];
        }

        $oUser = new User();
        $oUser->username = $username;
        $oUser->password = Hash::make($password);

        try {
            $oUser->save();
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => __("messages.error_creating_user", ["error" => $e->getMessage()]),
            ];
        }

        return [
            "status" => "ok",
            "message" => __("messages.suc_creating_user", ["username" => $username]),
        ];
    }

    public function deleteUser(string $username)
    {
        $oUser = User::where('username', $username);

        if ($oUser->get()->isEmpty()) {
            return [
                "status" => "error",
                "message" => __("messages.error_no_user", ["username" => $username]),
            ];
        }

        try {
            $oUser->delete();
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => __("messages.error_deleting_user", ["username" => $username, "error" => $e->getMessage()]),
            ];
        }

        return [
            "status" => "ok",
            "message" => __("messages.suc_deleting_user", ["username" => $username]),
        ];
    }

    public function getLogout()
    {
        Auth::logout();

        return ReturnController::returnWithSuccess(__("messages.suc_logout"), "/", false);
    }
}
