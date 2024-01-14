<nav class="navbar is-dark">

    <div class="navbar-brand">

        <a  href="/" class="navbar-item has-text-white has-background-danger-dark">
            <span class="icon has-text-dark"><x-carbon-tree-view-alt/></span>
            <span class="ml-2">{{ config('appconstants.app.name') }}</span>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar_ana">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>

    </div>

    <div id="navbar_ana" class="navbar-menu">

        <div class="navbar-start" id="navstart">

            @if(Auth::check())

                @role(['admin','company_admin'])
                <div class="navbar-item has-dropdown is-hoverable">

                    <p class="navbar-link">
                        <span class="icon has-text-warning"><x-carbon-letter-aa /></span>
                        <span class="ml-2">Adm</span>
                    </p>

                    <div class="navbar-dropdown">
                        <a href="/admin-users/list" class="navbar-item">Users</a>

                        @role('admin')
                            <a href="/admin-roles/list" class="navbar-item">Roles</a>
                            <a href="/admin-permissions/list" class="navbar-item">Permissions</a>
                            <a href="/admin-companies/list" class="navbar-item">Companies</a>
                        @endrole
                    </div>

                </div>
                @endrole


                <div class="navbar-item has-dropdown is-hoverable">

                    <a href="/projects-projects/home" class="navbar-link">
                        <span class="icon has-text-warning"><x-carbon-letter-pp /></span>
                        <span class="ml-2">Projects</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/projects-projects/list" class="navbar-item">Projects List</a>
                        <a href="/projects-eproducts/list" class="navbar-item">Project > End Products</a>
                        <a href="/projects-gates/list" class="navbar-item">Project > Milestones</a>
                        <a href="/projects-phases/list" class="navbar-item">Project > Project Phases</a>
                        <a href="/projects-witnesses/list" class="navbar-item">Project > Witnesses</a>
                    </div>
                </div>

                <a href="/requirements/list" class="navbar-item icon-text">
                    <span class="icon has-text-warning"><x-carbon-layers/></span>
                    <span>Requirements</span>
                </a>

                <a href="/projects-mocs/list" class="navbar-item icon-text">
                    <span class="icon has-text-warning"><x-carbon-rule /></span>
                    <span>MoCs</span>
                </a>

                <a href="/projects-pocs/list" class="navbar-item icon-text">
                    <span class="icon has-text-warning"><x-carbon-policy /></span>
                    <span>PoCs</span>
                </a>

                <a href="/projects-tests/list" class="navbar-item icon-text">
                    <span class="icon has-text-warning"><x-carbon-cloud-monitoring /></span>
                    <span>Tests</span>
                </a>

                <a href="/projects-chapters/list" class="navbar-item icon-text">
                    <span class="icon has-text-warning"><x-carbon-cics-system-group /></span>
                    <span>Chapters</span>
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link" href="/Admin">Export</p>
                    <div class="navbar-dropdown">
                        <a href="/all-requirements" class="navbar-item">All Requirements</a>
                        <a href="/pocs-vs-requirements" class="navbar-item">POCs vs Requirements</a>
                        <a href="/dgates-vs-pocs" class="navbar-item">Decision Gates vs POCs</a>
                        <a href="/tests-vs-reqs" class="navbar-item">Tests vs Requirements</a>
                        <a href="/compliance-matrix" class="navbar-item">Compliance Matrix</a>
                    </div>
                </div>

            @endif

        </div>


        <div class="navbar-end">

            @if(Auth::check())
                <div class="navbar-item has-dropdown is-hoverable">

                    <p class="navbar-link">
                        <span class="mx-3 has-text-right">
                            {{ Auth::user()->name }} {{ Auth::user()->lastname }} / {{ Auth::user()->company_name }}
                            <span class="block has-text-warning is-size-7">
                                {{ session('current_project_name') }}{{ session('current_eproduct_name') ? '/'.session('current_eproduct_name') :'' }}</span>
                        </span>
                    </p>

                    <div class="navbar-dropdown">

                        <a href="/product-selector" class="navbar-item">Change Project</a>
                        <a href="/profile" class="navbar-item">Change Password</a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a :href="route('logout')" class="navbar-item"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('ui.links.logout.text') }}
                            </a>
                        </form>

                    </div>
                </div>
            @else

                <div class="navbar-item">
                    <a href="{{route('login')}}" class="icon-text">
                        <span class="icon has-text-info"><x-carbon-login /></span>
                        <span class="ml-1">{{ __('ui.links.login.text')}}</span>
                    </a>
                </div>

            @endif

        </div>

    </div>

</nav>




{{--
session('current_project_id');
session('current_project_name');

session('current_eproduct_id');
session('current_eproduct_name');
--}}



{{-- @if (session('current_project_id') && session('current_project_name'))
    <section class="hero has-background-grey-lighter has-text-right">
        <p class="is-size-7 p-1">
            {{ session('current_eproduct_id') }}
            @if (session('current_eproduct_id'))
                {{ session('current_eproduct_name') }}
            @endif
        </p>
    </section>
@endif --}}

