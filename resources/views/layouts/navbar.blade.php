<li>
    <a href="index.html" class="side-menu {{ request()->is(['dashboardadmin']) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>
<li>
    <a href="javascript:;" class="side-menu {{ request()->is(['anggota','anggota/*']) ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-feather="layers"></i> </div>
        <div class="side-menu__title"> Data Master <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{ request()->is(['anggota','anggota/*']) ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="/anggota" class="side-menu {{ request()->is(['anggota','anggota/*']) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Data Anggota</div>
            </a>
        </li>
    </ul>
</li>
