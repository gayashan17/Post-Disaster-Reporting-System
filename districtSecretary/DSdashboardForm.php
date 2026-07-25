<?php
    session_start();
    include '../userData.php';
    include '../DBconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>District Secretary Dashboard</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

      <link href="../style.css" rel="stylesheet">
    <style>
        .ds-page-wrap{padding:24px}
        .stat-card{background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.06);border:1px solid #eef0f2;display:flex;align-items:center;gap:16px;height:100%}
        .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0}
        .stat-value{font-size:1.5rem;font-weight:700;color:#111827;line-height:1.1}
        .stat-label{font-size:.8rem;color:#6b7280;margin-top:2px}
        .ds-card{background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.06);border:1px solid #eef0f2}
        .card-title-sm{font-size:.95rem;font-weight:700;color:#111827;margin-bottom:16px}
        table.dataTable thead th{border-bottom:2px solid #e9ecef;font-size:.8rem;text-transform:uppercase;letter-spacing:.03em;color:#6b7280}
        table.dataTable tbody td{vertical-align:middle;font-size:.9rem}
        .badge-approved{background:#dcfce7;color:#166534;padding:4px 10px;border-radius:8px;font-weight:600;font-size:.78rem;text-transform:uppercase}
        .badge-rejected{background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:8px;font-weight:600;font-size:.78rem;text-transform:uppercase}
    </style>
</head>
<body>

<!-- ══════════════════ SIDEBAR ══════════════════ -->
<nav id="sidebar" class="sidebar-admin">
    <div class="sidebar-brand">
        <div class="brand-icon"><img src="../pictures/Post-Disaster-Reporting-Logo-Notxt.png" alt="Logo"></div>
        <div>
            <div class="brand-title">Post-Disaster</div>
            <div class="brand-sub">Reporting System</div>
        </div>
    </div>

    <div class="nav-section-label">Overview</div>
    <a class="nav-item active admin-active" href="DSDashboardForm.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">Report Management</div>
    <a class="nav-item" href="DSVerifyReportsForm.php">
        <i class="bi bi-clipboard-check"></i> Verify Reports
    </a>
    <a class="nav-item" href="DSProcessedHistoryForm.php">
        <i class="bi bi-clock-history"></i> Processed History
    </a>

    <div class="nav-section-label">Account</div>
    <a class="nav-item" href="#" onclick="showNotifAlert()">
        <i class="bi bi-bell"></i> Notifications
    </a>

    <a class="nav-item" href="DSprofileForm.php">
        <i class="bi bi-person"></i> Profile
    </a>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">District Secretary <span style="color:#2563eb">Dashboard</span></div>
    <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i><span class="notif-badge">2</span>
    </button>
    <div class="user-pill" onclick="window.location.href='DSProfileForm.php';">
        <div class="user-avatar admin-avatar">
            <?php if (!empty($profilePicFile)): ?>
                <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <i class="bi bi-person-fill"></i>
            <?php endif; ?>
        </div>
        <span class="user-name">User</span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
    </div>
</header>

<!-- ══════════════════ MAIN CONTENT ══════════════════ -->
<main id="main" class="ds-page-wrap">

    <!-- Stat Cards -->
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="stat-value" id="statPendingVerify">0</div>
                    <div class="stat-label">Awaiting Verification</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#ecfdf5;color:#059669">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="stat-value" id="statApproved">0</div>
                    <div class="stat-label">Approved Reports</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef2f2;color:#dc2626">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="stat-value" id="statRejected">0</div>
                    <div class="stat-label">Rejected Reports</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="stat-value" id="statTotalApproved">Rs. 0.00</div>
                    <div class="stat-label">Total Approved Amount</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Chart -->
        <div class="col-md-7">
            <div class="ds-card h-100">
                <div class="card-title-sm">Approvals (Last 6 Months)</div>
                <canvas id="approvalsChart" height="160"></canvas>
            </div>
        </div>

        <!-- Recent activity -->
        <div class="col-md-5">
            <div class="ds-card h-100">
                <div class="card-title-sm">Recent Activity</div>
                <div class="table-responsive">
                    <table id="recentActivityTable" class="table table-hover w-100">
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="DSDashboard.js"></script>
</body>
</html>
