@php
    $datamaster = ['anggota','anggota/*','jenissimpanan','jenissimpanan/*','tabungan','tabungan/*'];
    $datatransaksi = [''];
@endphp

<li>
    <a href="index.html" class="side-menu {{ request()->is(['dashboardadmin']) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>
<li>
    <a href="javascript:;" class="side-menu {{ request()->is($datamaster) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="layers"></i> </div>
        <div class="side-menu__title"> Data Master <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{ request()->is($datamaster) ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="/anggota" class="side-menu {{ request()->is(['anggota','anggota/*']) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title">Anggota</div>
            </a>
        </li>
        <li>
            <a href="/jenissimpanan" class="side-menu {{ request()->is(['jenissimpanan','jenissimpanan/*']) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="shopping-bag"></i> </div>
                <div class="side-menu__title">Jenis Simpanan</div>
            </a>
        </li>
        <li>
            <a href="/tabungan" class="side-menu {{ request()->is(['tabungan','tabungan/*']) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="book"></i> </div>
                <div class="side-menu__title">Jenis Tabungan</div>
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="/simpanan" class="side-menu {{ request()->is(['simpanan','simpanan/*']) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="briefcase"></i> </div>
        <div class="side-menu__title"> Simpanan </div>
    </a>
</li>
<li>
    <a href="/tabungan" class="side-menu {{ request()->is(['dashboardadmin']) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="book-open"></i> </div>
        <div class="side-menu__title"> Tabungan </div>
    </a>
</li>
