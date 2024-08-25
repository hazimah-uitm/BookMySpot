<div class="sidebar-header">
    <div>
        <img src="{{ asset('public/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
    </div>
    <div>
        <h4 class="logo-text text-uppercase">Tempahan Meja Malam Gala</h4>
    </div>
    <div class="toggle-icon ms-auto" id="toggle-icon"><i class='bx bx-arrow-to-left'></i></div>

</div>
<!--navigation-->
<ul class="metismenu" id="menu">
    <li>
        <a href="{{ url('/') }}" target="_blank">
            <div class="parent-icon"><i class='bx bx-home'></i>
            </div>
            <div class="menu-title">Laman Utama</div>
        </a>
    </li>
    <li>
        <a href="{{ route('home') }}">
            <div class="parent-icon"><i class='bx bxs-dashboard' ></i>
            </div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>

    @hasanyrole('Superadmin|admin')
    <li>
        <a href="{{ route('activity-log') }}">
            <div class="parent-icon"><i class='bx bx-history'></i></div>
            <div class="menu-title">Log Aktiviti</div>
        </a>
    </li>
    <li class="menu-label">Pengurusan Pengguna</li>
    <li>
        <a href="{{ route('user') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i>
            </div>
            <div class="menu-title">Pengguna</div>
        </a>
    </li>
    <li>
        <a href="{{ route('user-role') }}">
            <div class="parent-icon"><i class='bx bx-shield'></i>
            </div>
            <div class="menu-title">Peranan Pengguna</div>
        </a>
    </li>
    @endrole

    <li class="menu-label">Pengurusan</li>
    <li>
        <a href="{{ route('attendance') }}">
            <div class="parent-icon"><i class='bx bx-check-circle'></i>
            </div>
            <div class="menu-title">Senarai Kehadiran</div>
        </a>
    </li>

    <li>
        <a href="{{ route('staff') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i>
            </div>
            <div class="menu-title">Senarai Staf</div>
        </a>
    </li>

    <li>
        <a href="{{ route('booking') }}">
            <div class="parent-icon"><i class='bx bx-calendar-check'></i>
            </div>
            <div class="menu-title">Senarai Tempahan</div>
        </a>
    </li>

    <li class="menu-label">Tetapan</li>
    <li>
        <a href="{{ route('table') }}">
            <div class="parent-icon"><i class='bx bx-table'></i> </div>
            <div class="menu-title">Meja</div>
        </a>
    </li>
    @role('Superadmin')
    <!-- <li>
        <a class="has-arrow">
            <div class="parent-icon"><i class='bx bx-location-plus'></i>
            </div>
            <div class="menu-title">Lokasi</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('campus') }}"><i class="bx bx-right-arrow-alt"></i>Kampus</a>
            </li>
        </ul>
    </li>
    <li>
        <a class="has-arrow">
            <div class="parent-icon"><i class="bx bx-cog"></i>
            </div>
            <div class="menu-title">Tetapan Umum</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('position') }}"><i class="bx bx-right-arrow-alt"></i>Jawatan</a>
            </li>
        </ul>
    </li> -->
    <li>
        <a href="{{ route('logs.debug') }}">
            <div class="parent-icon"><i class='bx bxs-bug'></i></div>
            <div class="menu-title">Debug Log</div>
        </a>
    </li>
    @endrole
</ul>
<!--end navigation-->