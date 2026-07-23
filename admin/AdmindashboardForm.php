<?php
    include '../userData.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="../style.css" rel="stylesheet" />
</head>
<body>

<!-- ══════════════════ SIDEBAR ══════════════════ -->
<nav id="sidebar" class="sidebar-admin">
    <div class="sidebar-brand">
        <div class="brand-icon admin"><i class="bi bi-shield-lock-fill"></i></div>
        <div>
            <div class="brand-title">Post-Disaster</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="nav-section-label">Overview</div>
    <a class="nav-item active admin-active" href="#" onclick="showSection('dashboard')">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">User Management</div>
    <a class="nav-item" href="AllUsersForm.php">
        <i class="bi bi-person"></i> All Users
    </a>
    <a class="nav-item" href="#" onclick="addUser()">
        <i class="bi bi-person-plus"></i> Add New User
    </a>

    <div class="nav-section-label">System</div>
    <a class="nav-item" href="#" onclick="showInfo('Reports Overview')">
        <i class="bi bi-file-earmark-bar-graph"></i> Reports Overview
    </a>
    <a class="nav-item" href="#" onclick="showInfo('System Logs')">
        <i class="bi bi-journal-text"></i> System Logs
    </a>
    <a class="nav-item" href="#" onclick="showInfo('Settings')">
        <i class="bi bi-gear"></i> Settings
    </a>

    <div class="nav-section-label">Account</div>
    <a class="nav-item" href="#" onclick="showInfo('Notifications')">
        <i class="bi bi-bell"></i> Notifications
    </a>
 
    <a class="nav-item" href="AdminprofileForm.php">
        <i class="bi bi-person"></i> Profile
    </a>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</nav>

<!-- ══════════════════ TOPBAR ══════════════════ -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Admin <span class="admin-accent">Dashboard</span></div>
    <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i>
        <span class="notif-badge">5</span>
    </button>
    <div class="user-pill" onclick="window.location.href='AdminProfileForm.php';">
        <div class="user-avatar admin-avatar">
            <?php if (!empty($profilePicFile)): ?>
                <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <i class="bi bi-person-fill"></i>
            <?php endif; ?>
        </div>
        <span class="user-name">Admin</span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
    </div>
</header>

<!-- ══════════════════ MAIN ══════════════════ -->
<main id="main">

    <!-- ── SECTION: DASHBOARD ── -->
    <div id="section-dashboard">

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon admin-icon-red"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value" id="stat-users">0</div>
                        <a class="stat-link admin-link" onclick="showSection('users')">Manage Users &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-person-check-fill"></i></div>
                    <div>
                        <div class="stat-label">Active Users</div>
                        <div class="stat-value" id="stat-active">0</div>
                        <a class="stat-link admin-link" onclick="showSection('users')">View Active &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Reports</div>
                        <div class="stat-value" id="stat-reports">0</div>
                        <a class="stat-link admin-link" onclick="showInfo('Reports Overview')">View Reports &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon admin-icon-ban"><i class="bi bi-slash-circle-fill"></i></div>
                    <div>
                        <div class="stat-label">Banned Users</div>
                        <div class="stat-value" id="stat-banned">0</div>
                        <a class="stat-link admin-link" onclick="showSection('banned')">View Banned &rsaquo;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">

            <!-- User Role Breakdown Chart -->
            <div class="col-lg-5">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-pie-chart-fill"></i> Users by Role</div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="role-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Report Activity Chart -->
            <div class="col-lg-7">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Monthly Report Activity</div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="activity-chart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-4">

            <!-- Recent User Registrations -->
            <div class="col-lg-8">
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-person-lines-fill"></i> Recent Registrations</div>
                        <button class="btn btn-sm admin-btn-primary rounded-3" onclick="addUser()">
                            <i class="bi bi-person-plus me-1"></i> Add User
                        </button>
                    </div>
                    <div class="d-flex flex-column gap-2">

                    <div id="recent-registrations" class="d-flex flex-column gap-2">
                    </div>

                    </div>
                </div>
            </div>

            <!-- System Notifications -->
            <div class="col-lg-4">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-bell"></i> System Alerts</div>
                        <a class="stat-link admin-link" onclick="showInfo('All Alerts')">View All</a>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon admin-icon-notif-red"><i class="bi bi-slash-circle-fill"></i></div>
                        <div class="notif-text">User <strong>R. Jayasuriya</strong> was banned for policy violation.</div>
                        <div class="notif-time">1h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon green"><i class="bi bi-person-check-fill"></i></div>
                        <div class="notif-text">New user <strong>Dilini Perera</strong> registered successfully.</div>
                        <div class="notif-time">3h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon amber"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="notif-text">5 reports are pending verification for over 48 hours.</div>
                        <div class="notif-time">5h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon blue"><i class="bi bi-info-circle-fill"></i></div>
                        <div class="notif-text">System backup completed successfully.</div>
                        <div class="notif-time">1d ago</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <footer>&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script src="AdminDashboard.js"></script>


<?php if(isset($_SESSION['message'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['icon'] ?? "error"; ?>',
        title: '<?php echo $_SESSION['message']; ?>',
        confirmButtonColor: '#2563eb'
    });
</script>
<?php
unset($_SESSION['message']);
unset($_SESSION['icon']);
endif;
?>

</body>
</html>