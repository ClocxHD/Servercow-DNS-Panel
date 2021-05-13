<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class ReturnController extends Controller
{
    public static function returnWithSuccess($message, $target = "", $to_route = false)
    {
        Session::flash('Success_Message', $message);

        if (!empty($_POST["hash"])) {
            return redirect("/" . $_POST["hash"]);
        }

        if ($target == "") {
            return redirect()->back();
        } else {
            switch ($to_route) {
                case false:
                    return redirect($target);
                    break;
                case true:
                    return redirect()->route($target);
                    break;
            }
        }
    }

    public static function returnWithError($error, $target = "", $with_input = false)
    {
        Session::flash('Error_Message', $error);

        if (!empty($_POST["hash"])) {
            return redirect("/" . $_POST["hash"]);
        }

        if ($target == "") {
            switch ($with_input) {
                case false:
                    return redirect()->back();
                    break;
                case true:
                    return redirect()->back()->withInput();
            }
        } else {
            return redirect($target);
        }
    }
}
