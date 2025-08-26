<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../modules/auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        /* Sidebar styling */
        #sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            z-index: 1000;
            padding-top: 1rem;
            overflow-y: auto;
            transition: all 0.3s;
        }
        
        #sidebar .nav-link {
            color: #495057;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin: 0.1rem 0.5rem;
        }
        
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        
        #sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        /* Main content area */
        #content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        /* When sidebar is collapsed */
        .sidebar-collapsed #sidebar {
            margin-left: -250px;
        }
        
        .sidebar-collapsed #content {
            margin-left: 0;
        }
        
        /* Navbar styling */
        .navbar-brand {
            padding: 0.5rem 1rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
                width: 250px;
            }
            
            #content {
                margin-left: 0;
            }
            
            .sidebar-mobile-show #sidebar {
                margin-left: 0;
            }
            
            .sidebar-mobile-show::before {
                content: '';
                position: fixed;
                top: 56px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler me-2" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="../dashboard/index.php">Perpustakaan Digital</a>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle me-1"></i> <?php echo $_SESSION['admin_nama']; ?>
                </span>
                <a href="../logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && basename(dirname($_SERVER['PHP_SELF'])) == 'dashboard' ? 'active' : ''; ?>" href="../dashboard/index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'kelas' ? 'active' : ''; ?>" href="../kelas/index.php">
                        <i class="bi bi-house-door"></i> Kelas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'buku' ? 'active' : ''; ?>" href="../buku/index.php">
                        <i class="bi bi-book"></i> Data Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'anggota' ? 'active' : ''; ?>" href="../anggota/index.php">
                        <i class="bi bi-people"></i> Data Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'peminjaman' ? 'active' : ''; ?>" href="../peminjaman/index.php">
                        <i class="bi bi-arrow-left-circle"></i> Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'pengembalian' ? 'active' : ''; ?>" href="../pengembalian/index.php">
                        <i class="bi bi-arrow-right-circle"></i> Pengembalian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'kartu-anggota' ? 'active' : ''; ?>" href="../kartu-anggota/cetak.php">
                        <i class="bi bi-card-text"></i> Kartu Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'riwayat' ? 'active' : ''; ?>" href="../riwayat/index.php">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'laporan' ? 'active' : ''; ?>" href="../laporan/index.php">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename(dirname($_SERVER['PHP_SELF'])) == 'pengaturan' ? 'active' : ''; ?>" href="../pengaturan/index.php">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                </li>
            </ul>
            
            <hr>
            
            <div class="px-3 py-2">
                <small class="text-muted">Coding With AI - Boim Nyok</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="content">