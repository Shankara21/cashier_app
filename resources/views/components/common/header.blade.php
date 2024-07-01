<header>
    <div class="topbar d-flex align-items-center" style="background: #511f5a">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu text-white"><i class='bx bx-menu'></i>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">


                    <li class="nav-item dropdown dropdown-app">
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="app-container p-2 my-2">
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="header-notifications-list">
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="header-message-list">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @role('admin')
                    <img src="/assets/images/admin.png" class="user-img" alt="user avatar">
                    @endrole
                    @role('cashier')
                    <img src="/assets/images/cashier_person.png" class="user-img" alt="user avatar">
                    @endrole
                    <div class="user-info">
                        <p class="user-name mb-0" style="color: white">{{ Auth::user()->name }}</p>
                        <p class="designattion mb-0 " style="color: rgb(163, 163, 163);text-transform: capitalize;">
                            {{ Auth::user()->roles[0]->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
