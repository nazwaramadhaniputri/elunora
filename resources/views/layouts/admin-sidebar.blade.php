<!-- Sidebar Navigation -->
<ul class="nav flex-column">
    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Berita -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/berita*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
            <i class="fas fa-newspaper"></i>
            <span>Berita</span>
        </a>
    </li>

    <!-- Galeri -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}">
            <i class="fas fa-images"></i>
            <span>Galeri</span>
        </a>
    </li>



    <!-- Agenda -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/agenda*') ? 'active' : '' }}" href="{{ route('admin.agenda.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Agenda</span>
        </a>
    </li>

    <!-- Guru & Staff -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/guru*') ? 'active' : '' }}" href="{{ route('admin.guru.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Guru & Staff</span>
        </a>
    </li>

    <!-- Fasilitas -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/fasilitas*') ? 'active' : '' }}" href="{{ route('admin.fasilitas.index') }}">
            <i class="fas fa-building"></i>
            <span>Fasilitas</span>
        </a>
    </li>

    <!-- Profil Sekolah -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/profil*') ? 'active' : '' }}" href="{{ route('admin.profil.index') }}">
            <i class="fas fa-school"></i>
            <span>Profil Sekolah</span>
        </a>
    </li>

    <!-- Log Aktivitas -->
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/activity-logs*') ? 'active' : '' }}" href="{{ route('admin.activity-logs.index') }}">
            <i class="fas fa-history"></i>
            <span>Log Aktivitas</span>
        </a>
    </li>
</ul>