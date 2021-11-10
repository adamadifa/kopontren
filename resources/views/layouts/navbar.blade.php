 <!-- BEGIN: Main Menu-->
 <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{asset('html/ltr/vertical-menu-template/index.html')}}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">Vuexy</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="/dashboard"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            <li class=" navigation-header"><span>Data Master</span>
            <li class=" nav-item">
                <a href="#"><i class="feather icon-grid"></i><span class="menu-title">Data Master</span></a>
                <ul class="menu-content">
                    <li class="{{ request()->is(['anggota','anggota/*']) ? 'active' : '' }}"><a href="/anggota"><i class="feather icon-users"></i><span class="menu-item">Anggota</span></a></li>
                    <li class="{{ request()->is(['jenissimpanan','jenissimpanan/*']) ? 'active' : '' }}"><a href="/jenissimpanan"><i class="feather icon-book"></i><span class="menu-item">Jenis Simpanan</span></a></li>
                    <li class="{{ request()->is(['tabungan','tabungan/*']) ? 'active' : '' }}"><a href="/tabungan"><i class="feather icon-book"></i><span class="menu-item">Jenis Tabungan</span></a></li>
                </ul>
            </li>
            <li class=" navigation-header"><span>Data Transaksi</span>
            <li class=" nav-item {{ request()->is(['simpanan','simpanan/*']) ? 'active' : '' }}">
                <a href="/simpanan"><i class="fa fa-book"></i><span class="menu-title">Simpanan</span></a>
            </li>
            <li class=" nav-item {{ request()->is(['rekening','rekening/*']) ? 'active' : '' }}">
                <a href="/rekening"><i class="fa fa-book"></i><span class="menu-title">Tabungan</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
