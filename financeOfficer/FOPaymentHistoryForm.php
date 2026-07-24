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
    <title>Payment History - Financial Officer</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link href="../style.css" rel="stylesheet">
    <style>
        .fo-page-wrap{padding:24px}
        .fo-card{background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.06);border:1px solid #eef0f2}
        .fo-toolbar{display:flex;gap:12px;flex-wrap:wrap;align-items:center;justify-content:space-between;margin-bottom:18px}
        .fo-toolbar .form-control{border-radius:10px}
        table.dataTable thead th{border-bottom:2px solid #e9ecef;font-size:.82rem;text-transform:uppercase;letter-spacing:.03em;color:#6b7280}
        table.dataTable tbody td{vertical-align:middle;font-size:.92rem}
        .icon-btn{border:none;background:#f1f5f9;color:#0f172a;width:34px;height:34px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center}
        .icon-btn.view{color:#10b981}
        .icon-btn:hover{opacity:.8}
        .badge-amount{background:#ecfdf5;color:#065f46;padding:4px 10px;border-radius:8px;font-weight:600}
        .badge-paid{background:#dcfce7;color:#166534;padding:4px 10px;border-radius:8px;font-weight:600;font-size:.78rem;text-transform:uppercase}
        .detail-label{font-size:.75rem;text-transform:uppercase;letter-spacing:.03em;color:#9ca3af;margin-bottom:2px}
        .detail-value{font-size:.95rem;font-weight:500;color:#111827;margin-bottom:14px}
        .detail-section-title{font-size:.85rem;font-weight:700;color:#10b981;text-transform:uppercase;letter-spacing:.04em;margin:10px 0 14px;border-bottom:1px solid #eef0f2;padding-bottom:6px}
        .receipt-link{display:inline-flex;align-items:center;gap:6px;color:#065f46;font-weight:600;text-decoration:none}
        .receipt-link:hover{text-decoration:underline}
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
    <a class="nav-item" href="FODashboardForm.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">Report Management</div>
    <a class="nav-item" href="FOVerifyReportsForm.php">
        <i class="bi bi-clipboard-check"></i> Verify Reports
    </a>
    <a class="nav-item" href="FOProcessingReportsForm.php">
        <i class="bi bi-hourglass-split"></i> Processing Reports
    </a>
    <a class="nav-item active admin-active" href="FOPaymentHistoryForm.php">
        <i class="bi bi-cash-stack"></i> Payment History
    </a>

    <div class="nav-section-label">Account</div>
    <a class="nav-item" href="#" onclick="showNotifAlert()">
        <i class="bi bi-bell"></i> Notifications
    </a>

    <a class="nav-item" href="FOprofileForm.php">
        <i class="bi bi-person"></i> Profile
    </a>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Payment <span style="color:#10b981">History</span></div>
    <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i><span class="notif-badge">2</span>
    </button>
    <div class="user-pill" onclick="window.location.href='FOProfileForm.php';">
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
<main id="main" class="fo-page-wrap">
    <div class="fo-card">

        <div class="fo-toolbar">
            <div class="input-group" style="max-width:320px">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Compensation ID, Report ID...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="paymentHistoryTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Compensation ID</th>
                        <th>Report ID</th>
                        <th>Estimate Amount (Rs.)</th>
                        <th>Approved Amount (Rs.)</th>
                        <th>Paid Amount (Rs.)</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</main>

<!-- ══════════════════ PAYMENT DETAILS MODAL ══════════════════ -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header" style="border-bottom:1px solid #eef0f2">
                <h5 class="modal-title fw-bold">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paymentDetailsBody"></div>
            <div class="modal-footer" style="border-top:1px solid #eef0f2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="FOPaymentHistory.js"></script>
</body>
</html>
