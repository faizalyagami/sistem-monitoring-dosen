<nav id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">
            <i class="bi bi-graph-up"></i>
        </div>
        <h3>SIMONKER</h3>
        <p>Sistem Monitoring Kinerja Dosen</p>
    </div>

    <div class="menu-title">MAIN NAVIGATION</div>

    <ul class="components">
        <!-- Dashboard -->
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
    </ul>

    @if (Auth::user()->isAdmin())
        <div class="menu-title">DATA MASTER</div>
        <ul class="components">
            <li class="{{ request()->routeIs('admin.dosens.*') ? 'active' : '' }}">
                <a href="{{ route('admin.dosens.index') }}">
                    <i class="bi bi-people"></i> Data Dosen
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.periods.*') ? 'active' : '' }}">
                <a href="{{ route('admin.periods.index') }}">
                    <i class="bi bi-calendar"></i> Periode Akademik
                </a>
            </li>
        </ul>

        <div class="menu-title">KINERJA DOSEN</div>
        <ul class="components">
            <li class="{{ request()->routeIs('admin.pengajaran.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pengajaran.index') }}">
                    <i class="bi bi-book"></i> Pengajaran
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.riset.*') ? 'active' : '' }}">
                <a href="{{ route('admin.riset.index') }}">
                    <i class="bi bi-mortarboard"></i> Penelitian
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.pkm.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pkm.index') }}">
                    <i class="bi bi-people-fill"></i> Pengabdian Masyarakat
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.bimbingan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.bimbingan.index') }}">
                    <i class="bi bi-chat-dots"></i> Bimbingan
                </a>
            </li>
        </ul>

        <div class="menu-title">LAPORAN & EVALUASI</div>
        <ul class="components">
            <li class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan.index') }}">
                    <i class="bi bi-file-text"></i> Laporan Kinerja
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.evaluasi-kinerja.*') ? 'active' : '' }}">
                <a href="{{ route('admin.evaluasi-kinerja.index') }}">
                    <i class="bi bi-clipboard-check"></i> Evaluasi Kinerja
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <a href="{{ route('admin.activity-logs.index') }}">
                    <i class="bi bi-clock-history"></i> Activity Log
                </a>
            </li>
        </ul>
    @endif

    @if (Auth::user()->isDosen())
        <div class="menu-title">INPUT KINERJA</div>
        <ul class="components">
            <li class="{{ request()->routeIs('dosen.pengajaran.*') ? 'active' : '' }}">
                <a href="{{ route('dosen.pengajaran.index') }}">
                    <i class="bi bi-book"></i> Pengajaran
                </a>
            </li>
            <li class="{{ request()->routeIs('dosen.riset.*') ? 'active' : '' }}">
                <a href="{{ route('dosen.riset.index') }}">
                    <i class="bi bi-mortarboard"></i> Penelitian
                </a>
            </li>
            <li class="{{ request()->routeIs('dosen.pkm.*') ? 'active' : '' }}">
                <a href="{{ route('dosen.pkm.index') }}">
                    <i class="bi bi-people-fill"></i> PKM
                </a>
            </li>
            <li class="{{ request()->routeIs('dosen.bimbingan.*') ? 'active' : '' }}">
                <a href="{{ route('dosen.bimbingan.index') }}">
                    <i class="bi bi-chat-dots"></i> Bimbingan
                </a>
            </li>
        </ul>

        <div class="menu-title">LAPORAN</div>
        <ul class="components">
            <li class="{{ request()->routeIs('dosen.laporan.*') ? 'active' : '' }}">
                <a href="{{ route('dosen.laporan.index') }}">
                    <i class="bi bi-file-text"></i> Laporan Saya
                </a>
            </li>
        </ul>
    @endif

    <div class="sidebar-footer">
        <small>
            <i class="bi bi-shield-check"></i> Role: {{ ucfirst(Auth::user()->role) }}<br>
            <i class="bi bi-clock"></i> Login:
            {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Baru saja' }}
        </small>
    </div>
</nav>
