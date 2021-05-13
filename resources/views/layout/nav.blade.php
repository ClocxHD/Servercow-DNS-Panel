<nav class="navbar is-link is-fixed-top" role="navigation" aria-label="main navigation">
    <a role="button" id="mainBurger" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
    </a>

    <div id="mainNavbar" class="navbar-menu">
        @if(Auth::check())
            <div class="navbar-start">
                <a href="/" class="navbar-item">Home</a>
                <a href="{{ Route('records.add') }}" class="navbar-item"><i class="far fa-plus-square"></i>&nbsp;{{ __("views.add_record") }}</a>
                <a href="{{ Route('domains.get') }}" class="navbar-item"><i class="fas fa-globe"></i>&nbsp;{{ __("views.domains") }}</a>
            </div>
        @endif

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    {{ __("views.language") }}
                </a>

                <div class="navbar-dropdown">
                    <a href="{{ Route("language.set", ["code" => "de"]) }}" class="navbar-item {{ \App\Http\Controllers\LanguageController::getActiveLanguage() == 'de' ? 'lang-active' : '' }}"><span class="flag flag-xs" lang="de"></span>&nbsp;{{ __("views.german") }}</a>
                    <a href="{{ Route("language.set", ["code" => "en"]) }}" class="navbar-item {{ \App\Http\Controllers\LanguageController::getActiveLanguage() == 'en' ? 'lang-active' : '' }}"><span class="flag flag-xs" lang="en"></span>&nbsp;{{ __("views.english")}}</a>
                </div>
            </div>

            @if(Auth::check())
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <i class="fas fa-user"></i>&nbsp;{{ Auth::user()->username }}
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a href="{{ Route("auth-password-change.get") }}" class="navbar-item"><i class="fas fa-key"></i>&nbsp;{{ __("views.change_password") }}</a>
                        <hr class="navbar-divider">
                        <a href="{{ Route("auth-logout.get") }}" class="navbar-item"><i class="fas fa-sign-out-alt"></i>&nbsp;{{ __("views.logout") }}</a>
                    </div>
                </div>
            @else
                <a href="{{ Route('auth-login.get') }}" class="navbar-item">Login</a>
            @endif
        </div>
    </div>
</nav>
