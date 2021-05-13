<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function setLanguage($sLangCode)
    {
        if ($this->validateLangCode($sLangCode)) {
            session(["lang" => $sLangCode]);

            return ReturnController::returnWithSuccess(__("messages.suc_lang_set"));
        }

        return ReturnController::returnWithError(__("messages.err_lang_code_not_found", ["code" => $sLangCode]));
    }

    public static function getActiveLanguage()
    {
        if (session()->has("lang")) {
            return session()->get("lang");
        }

        return env("APP_LOCALE");
    }

    public function validateLangCode($sLangCode): bool
    {
        $codes = [
            "ab", "aa", "af", "ak", "sq", "am", "ar", "an", "hy", "as", "av", "ae", "ay", "az", "bm", "ba", "eu", "be", "bn", "bh", "bi", "bs", "br", "bg", "my", "ca", "km", "ch", "ce", "ny", "zh", "cu", "cv", "kw", "co", "cr", "hr", "cs", "da", "dv", "nl", "dz", "en", "eo", "et", "ee", "fo", "fj", "fi", "fr", "ff", "gd", "gl", "lg", "ka", "de", "ki", "el", "kl", "gn", "gu", "ht", "ha", "he", "hz", "hi", "ho", "hu", "is", "io", "ig", "id", "ia", "ie", "iu", "ik", "ga", "it", "ja", "jv", "kn", "kr", "ks", "kk", "rw", "kv", "kg", "ko", "kj", "ku", "ky", "lo", "la", "lv", "lb", "li", "ln", "lt", "lu", "mk", "mg", "ms", "ml", "mt", "gv", "mi", "mr", "mh", "ro", "mn", "na", "nv", "nd", "ng", "ne", "se", "no", "nb", "nn", "ii", "oc", "oj", "or", "om", "os", "pi", "pa", "ps", "fa", "pl", "pt", "qu", "rm", "rn", "ru", "sm", "sg", "sa", "sc", "sr", "sn", "sd", "si", "sk", "sl", "so", "st", "nr", "es", "su", "sw", "ss", "sv", "tl", "ty", "tg", "ta", "tt", "te", "th", "bo", "ti", "to", "ts", "tn", "tr", "tk", "tw", "ug", "uk", "ur", "uz", "ve", "vi", "vo", "wa", "cy", "fy", "wo", "xh", "yi", "yo", "za", "zu",
        ];

        return in_array($sLangCode, $codes);
    }
}
