<nav class="navbar is-dark">

    <div class="navbar-brand">

        <a  href="/" class="navbar-item has-text-white has-background-danger-dark">
            <span class="icon has-text-dark">
                <x-carbon-tree-view-alt/>
            </span>
            <span class="ml-2">{{ env('APP_NAME') }}</span>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar_ana">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>

    </div>

    <div id="navbar_ana" class="navbar-menu">

        <div class="navbar-start" id="navstart">

            @if(!Auth::check())

                <a href="/companies" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-enterprise />
                    </span>
                    <span>Companies</span>
                </a>



                <div class="navbar-item has-dropdown is-hoverable">

                    <a href="/projects" class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-building/>
                        </span>
                        <span class="ml-2">Projects</span>
                    </a>

                    {{-- <p class="navbar-link" href="/durum/ozet">Projects</p> --}}
                    <div class="navbar-dropdown">
                        <a href="/durum/ozet" class="navbar-item">End Products</a>
                    </div>
                </div>

                <a href="/requirements" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-layers/>
                    </span>
                    <span>Requirements</span>
                </a>

                <a href="/durum/giderler" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-rule />
                    </span>
                    <span>MoCs</span>
                </a>

                <a href="/durum/verecekler" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-policy />
                    </span>
                    <span>PoCs</span>
                </a>

                <a href="/sayaclar" class="navbar-item icon-text">
                    <span class="icon">
                        {{-- <x-icon icon="reading" fill="{{config('constants.icons.color.dark')}}"/> --}}

                    </span>
                    <span>Sayaçlar</span>
                </a>


                <a href="/karar" class="navbar-item icon-text">
                    <span class="icon">
                        {{-- <x-icon icon="decision" fill="{{config('constants.icons.color.dark')}}"/> --}}

                    </span>
                    <span>Kararlar</span>
                </a>



                <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link" href="/Admin">Kayıtlar</p>
                    <div class="navbar-dropdown">

                        <a href="/kayit-form/aidat" class="navbar-item">Toplu Aidat Kaydı</a>
                        <a href="/kayit-form/alacak" class="navbar-item">Alacak Kaydı</a>
                        <a href="/kayit-form/fatura" class="navbar-item">Fatura Kaydı</a>
                        <a href="/kayit-form/gelir" class="navbar-item">Gelir Kaydı</a>
                        <a href="/kayit-form/gider" class="navbar-item">Gider Kaydı</a>
                        <a href="/okuma-form" class="navbar-item">Okuma Kaydı</a>

                    </div>
                </div>


                <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link" href="/Admin">Yazdır</p>
                    <div class="navbar-dropdown">
                        <a href="/dokum" class="navbar-item icon-text">Gelir-Gider Döküm</a>
                        <a href="/bosmakbuz" class="navbar-item icon-text">Boş Makbuz</a>
                    </div>
                </div>

            @endif

        </div>


        <div class="navbar-end">

            @if(Auth::check())

            <div class="navbar-item has-dropdown is-hoverable">

                <p class="navbar-link">
                    <span class="icon">
                        {{-- <x-icon icon="user" fill="{{config('constants.icons.color.dark')}}"/> --}}

                    </span>
                    <span class="mx-3 has-text-right">
                        {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                        <span class="block has-text-warning is-size-7">{{session('selected_bina')}}</span>
                    </span>
                </p>



                <div class="navbar-dropdown">

                    <a href="/bina-list" class="navbar-item">Binalarım</a>

                    <a  href="/help" class="navbar-item">Yardım</a>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a :href="route('logout')" class="navbar-item"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>

                </div>
            </div>
            @else
            <div class="navbar-item">

                <a href="{{route('login')}}" class="icon-text has-color-warning">
                    <span class="icon has-text-grey-light">
                        {{-- <x-icon icon="login" fill="{{config('constants.icons.color.dark')}}"/> --}}

                        <x-carbon-login/>


                    </span>
                    <span class="ml-1">Giriş</span>
                </a>
            </div>

            <div class="navbar-item">

                <a href="{{route('register')}}" class="icon-text">
                    <span class="icon has-text-grey-light">
                        {{-- <x-icon icon="user" fill="{{config('constants.icons.color.dark')}}"/> --}}
                        <x-carbon-user-follow />
                    </span>
                    <span class="ml-1">Kaydolun</span>
                </a>
            </div>
            @endif

        </div>

    </div>

</nav>
