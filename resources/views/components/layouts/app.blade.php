<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMONKER - Sistem Monitoring Kinerja Dosen')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3f37c9;
            --secondary: #7209b7;
            --success: #4caf50;
            --info: #2196f3;
            --warning: #ff9800;
            --danger: #f44336;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --sidebar-bg: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --navbar-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--light);
            overflow-x: hidden;
        }

        /* ========== WRAPPER & SIDEBAR ========== */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        #sidebar {
            min-width: 280px;
            max-width: 280px;
            background: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1030;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #sidebar.active {
            margin-left: -280px;
        }

        #sidebar::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }

        #sidebar .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        #sidebar .sidebar-header .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
        }

        .logo-icon img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
            padding: 5px;
        }

        #sidebar .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        #sidebar .sidebar-header p {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-bottom: 0;
        }

        #sidebar .menu-title {
            padding: 15px 25px 8px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        #sidebar ul.components {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li a {
            padding: 12px 25px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            margin: 5px 0;
        }

        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left-color: var(--primary);
            padding-left: 30px;
        }

        #sidebar ul li.active>a {
            background: linear-gradient(90deg, rgba(67, 97, 238, 0.2), transparent);
            color: white;
            border-left-color: var(--primary);
        }

        #sidebar ul li a i {
            width: 24px;
            font-size: 1.2rem;
        }

        #sidebar .sidebar-footer {
            padding: 20px 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.7rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 30px;
        }

        /* ========== CONTENT AREA ========== */
        #content {
            width: 100%;
            margin-left: 280px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar.active~#content {
            margin-left: 0;
        }

        /* ========== TOP NAVBAR ========== */
        .top-navbar {
            background: var(--navbar-bg);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-toggle:hover {
            background: rgba(67, 97, 238, 0.1);
        }

        .sidebar-toggle span {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
        }

        .navbar-brand-custom {
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        /* Search Bar */
        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .search-input {
            background: var(--light);
            border: none;
            border-radius: 50px;
            padding: 10px 20px 10px 45px;
            width: 300px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            width: 350px;
        }

        /* Notifications */
        .notification-btn {
            position: relative;
            background: transparent;
            border: none;
            padding: 8px;
            border-radius: 10px;
            color: var(--gray);
            transition: all 0.3s;
        }

        .notification-btn:hover {
            background: var(--light);
            color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 50%;
            font-weight: bold;
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .user-menu:hover {
            background: var(--light);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0;
            line-height: 1.2;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Dropdown Custom */
        .dropdown-custom {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            padding: 10px;
            margin-top: 10px;
            min-width: 260px;
        }

        .dropdown-item-custom {
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .dropdown-item-custom:hover {
            background: var(--light);
            color: var(--primary);
            transform: translateX(5px);
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 25px 30px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.85rem;
        }

        /* Cards */
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Alerts */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--card-shadow);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item .page-link {
            border-radius: 10px;
            color: #4361ee;
            border: 1px solid #e2e8f0;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .page-item .page-link:hover {
            background: linear-gradient(135deg, #4361ee, #764ba2);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #4361ee, #764ba2);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 10px;
        }

        /* Info text */
        .pagination-info {
            background: #f8fafc;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar {
                margin-left: -280px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            .search-input {
                width: 200px;
            }

            .search-input:focus {
                width: 250px;
            }

            .user-info {
                display: none;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 1.4rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('components.layouts.sidebar')

        <!-- Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" id="sidebarCollapse" class="sidebar-toggle">
                        <i class="bi bi-list"></i>
                        <span class="d-none d-md-inline">Menu</span>
                    </button>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Search -->
                    <div class="search-wrapper d-none d-lg-block">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search-input" placeholder="Cari sesuatu...">
                    </div>

                    <!-- Notification -->
                    <div class="dropdown">
                        <button class="notification-btn" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-custom">
                            <div class="px-3 py-2 border-bottom">
                                <h6 class="mb-0 fw-bold">Notifikasi</h6>
                                <small class="text-muted">3 notifikasi baru</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item-custom">
                                <i class="bi bi-calendar-check text-primary"></i>
                                <div>
                                    <div class="small fw-bold">Periode baru dimulai</div>
                                    <div class="small text-muted">2 jam lalu</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="bi bi-person-plus text-success"></i>
                                <div>
                                    <div class="small fw-bold">Dosen baru ditambahkan</div>
                                    <div class="small text-muted">5 jam lalu</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="bi bi-file-text text-warning"></i>
                                <div>
                                    <div class="small fw-bold">Laporan bulanan siap</div>
                                    <div class="small text-muted">Kemarin</div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item-custom justify-content-center">
                                <small class="text-primary">Lihat semua</small>
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <div class="user-menu" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                            <i class="bi bi-chevron-down text-muted"></i>
                        </div>
                        <div class="dropdown-menu dropdown-menu-end dropdown-custom">
                            <a class="dropdown-item-custom" href="#">
                                <i class="bi bi-person"></i>
                                <span>Profile Saya</span>
                            </a>
                            <a class="dropdown-item-custom" href="#">
                                <i class="bi bi-gear"></i>
                                <span>Pengaturan</span>
                            </a>
                            <a class="dropdown-item-custom" href="#">
                                <i class="bi bi-question-circle"></i>
                                <span>Bantuan</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item-custom w-100 text-start text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="content-wrapper">
                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                    <div class="breadcrumb-custom">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                @endif

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Sidebar Toggle
        document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Confirm Delete
        window.confirmDelete = function(formId, title = 'Apakah Anda yakin?', text =
            'Data yang dihapus tidak dapat dikembalikan!') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        };

        // Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>

    @stack('scripts')
</body>

</html>
