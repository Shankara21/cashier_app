<div class="sidebar-wrapper " style="background: #ec1271" data-simplebar="true">
    <div class="sidebar-header" style="background: #ec1271">
        <div>
            <img src="/assets/images/cashier-machine.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Cashier</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu textwh" id="menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label" style="color: #EEEEEE">Menu Utama</li>
        <li>
            <a class="" href="{{ route('cashier') }}">
                <div class="parent-icon"><i class='bx bx-money'></i>
                </div>
                <div class="menu-title">Transaksi</div>
            </a>
        </li>
        <li>
            <a class="" href="{{ route('orders.index') }}">
                <div class="parent-icon"><i class="bx bx-file"></i>
                </div>
                <div class="menu-title">Laporan</div>
            </a>
        </li>
        @role('admin')
        <li class="menu-label" style="color: #EEEEEE">Master Data</li>
        <li>
            <a href="{{ route('categories.index') }}">
                <div class="parent-icon"><i class='bx bx-category-alt'></i>
                </div>
                <div class="menu-title">Kategori</div>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Pengguna</div>
            </a>
            <ul class="bg-transparent">
                <li>
                    <a href="{{ route('users.index', ['role' => 'admin']) }}">
                        <i class='bx bx-radio-circle'></i>Admin
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index', ['role' => 'cashier']) }}">
                        <i class='bx bx-radio-circle'></i>Kasir
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('brands.index') }}">
                <div class="parent-icon"><i class='bx bx-receipt'></i>
                </div>
                <div class="menu-title">Merk</div>
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">
                <div class="parent-icon"><i class='bx bx-shopping-bag'></i>
                </div>
                <div class="menu-title">Produk</div>
            </a>
        </li>
        <li>
            <a href="{{ route('settings.index') }}">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
        </li>
        @endrole
        @role('cashier')
        <li class="menu-label" style="color: #EEEEEE">Master Data</li>
        <li>
            <a href="{{ route('categories.index') }}">
                <div class="parent-icon"><i class='bx bx-category-alt'></i>
                </div>
                <div class="menu-title">Kategori</div>
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">
                <div class="parent-icon"><i class='bx bx-shopping-bag'></i>
                </div>
                <div class="menu-title">Produk</div>
            </a>
        </li>
        @endrole
    </ul>
    <!--end navigation-->
</div>