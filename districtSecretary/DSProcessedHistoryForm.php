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
    <title>Processed History - District Secretary</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link href="../style.css" rel="stylesheet">
    <style>
        .ds-page-wrap{padding:24px}
        .ds-card{background:#fff;border-radius:14px;padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.06);border:1px solid #eef0f2;margin-bottom:22px}
        .ds-toolbar{display:flex;gap:12px;flex-wrap:wrap;align-items:center;justify-content:space-between;margin-bottom:18px}
        .ds-toolbar .form-control{border-radius:10px}
        table.dataTable thead th{border-bottom:2px solid #e9ecef;font-size:.82rem;text-transform:uppercase;letter-spacing:.03em;color:#6b7280}
        table.dataTable tbody td{vertical-align:middle;font-size:.92rem}
        .icon-btn{border:none;background:#f1f5f9;color:#0f172a;width:34px;height:34px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;margin-right:6px}
        .icon-btn.view{color:#2563eb}
        .icon-btn.process{color:#f59e0b}
        .icon-btn:hover{opacity:.8}
        .badge-amount{background:#ecfdf5;color:#065f46;padding:4px 10px;border-radius:8px;font-weight:600}
        .badge-approved{background:#dcfce7;color:#166534;padding:4px 10px;border-radius:8px;font-weight:600;font-size:.78rem;text-transform:uppercase}
        .badge-rejected{background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:8px;font-weight:600;font-size:.78rem;text-transform:uppercase}
        .detail-label{font-size:.75rem;text-transform:uppercase;letter-spacing:.03em;color:#9ca3af;margin-bottom:2px}
        .detail-value{font-size:.95rem;font-weight:500;color:#111827;margin-bottom:14px}
        .detail-section-title{font-size:.85rem;font-weight:700;color:#2563eb;text-transform:uppercase;letter-spacing:.04em;margin:10px 0 14px;border-bottom:1px solid #eef0f2;padding-bottom:6px}
        .type-entry-card{background:#f8fafc;border:1px solid #eef0f2;border-radius:10px;padding:12px 14px;margin-bottom:10px}
        .evidence-item{display:flex;align-items:center;justify-content:space-between;background:#f8fafc;border:1px solid #eef0f2;border-radius:10px;padding:10px 14px;margin-bottom:8px}
        .evidence-item a{color:#2563eb;font-weight:600;text-decoration:none}
        .evidence-item a:hover{text-decoration:underline}
        .pay-summary-box{background:#f8fafc;border:1px solid #eef0f2;border-radius:12px;padding:16px;margin-bottom:18px}
        .pay-summary-box .item{text-align:center}
        .pay-summary-box .item .lbl{font-size:.72rem;text-transform:uppercase;color:#9ca3af}
        .pay-summary-box .item .val{font-size:1.05rem;font-weight:700;color:#111827}
        .section-title-lg{font-size:1.05rem;font-weight:700;color:#111827;margin-bottom:14px;display:flex;align-items:center;gap:8px}
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
    <a class="nav-item" href="DSDashboardForm.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">Report Management</div>
    <a class="nav-item" href="DSVerifyReportsForm.php">
        <i class="bi bi-clipboard-check"></i> Verify Reports
    </a>
    <a class="nav-item active admin-active" href="DSProcessedHistoryForm.php">
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
    <div class="topbar-title">Processed <span style="color:#2563eb">History</span></div>
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

    <!-- Approved Reports Table -->
    <div class="ds-card">
        <div class="section-title-lg"><i class="bi bi-check2-circle text-success"></i> Approved Reports</div>

        <div class="ds-toolbar">
            <div class="input-group" style="max-width:320px">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchApproved" class="form-control" placeholder="Search approved reports...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="approvedReportsTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Report Type</th>
                        <th>Divisional Secretariat</th>
                        <th>Approved Amount (Rs.)</th>
                        <th>Bank Account No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Rejected Reports Table -->
    <div class="ds-card">
        <div class="section-title-lg"><i class="bi bi-x-circle text-danger"></i> Rejected Reports</div>

        <div class="ds-toolbar">
            <div class="input-group" style="max-width:320px">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchRejected" class="form-control" placeholder="Search rejected reports...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="rejectedReportsTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Report Type</th>
                        <th>Divisional Secretariat</th>
                        <th>Rejection Reason</th>
                        <th>Bank Account No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</main>

<!-- ══════════════════ REPORT DETAILS MODAL (shared) ══════════════════ -->
<div class="modal fade" id="reportDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header" style="border-bottom:1px solid #eef0f2">
                <h5 class="modal-title fw-bold">Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reportDetailsBody">
                <div class="text-center text-muted py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading report details...</p>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #eef0f2" id="reportDetailsFooter">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════ APPROVE MODAL (used when Processing a Rejected report) ══════════════════ -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header" style="border-bottom:1px solid #eef0f2">
                <h5 class="modal-title fw-bold">Approve Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="pay-summary-box">
                    <div class="row">
                        <div class="col-md-4 item">
                            <div class="lbl">Report ID</div>
                            <div class="val" id="apprSummaryReportID">-</div>
                        </div>
                        <div class="col-md-4 item">
                            <div class="lbl">Report Type</div>
                            <div class="val" id="apprSummaryReportType">-</div>
                        </div>
                        <div class="col-md-4 item">
                            <div class="lbl">Estimate Amount (DMO)</div>
                            <div class="val" id="apprSummaryEstimateAmount">-</div>
                        </div>
                    </div>
                </div>

                <form id="approveForm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Approved Amount (Rs.)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="approvedAmount" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="approveDescription" rows="3" placeholder="Verification notes / remarks..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top:1px solid #eef0f2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btnConfirmApprove">
                    <i class="bi bi-check2-circle"></i> Confirm Approval
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="DSProcessedHistory.js"></script>
</body>
</html>
