<?php
    session_start();
    include 'userData.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Disaster Management Officer Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="style.css" rel="stylesheet" />
</head>
<body>

<!-- SIDEBAR -->
<nav id="sidebarDMO">
  <div class="sidebar-brand">
    <div class="brand-icon"><img src="pictures\Post-Disaster-Reporting-Logo-Notxt.png"></div>
    <div>
      <div class="brand-title">Post-Disaster</div>
      <div class="brand-sub">Reporting System</div>
    </div>
  </div>

  <div class="nav-section-label">Reviews</div>
  <a class="nav-item" onclick="showInfo('Verified Reports')"><i class="bi bi-check-square"></i> Verified Reports</a>
  <a class="nav-item active" href="#"><i class="bi bi-currency-dollar"></i> Compensation Requests</a>
  <a class="nav-item" onclick="showInfo('Approved')"><i class="bi bi-patch-check"></i> Approved</a>
  <a class="nav-item" onclick="showInfo('Rejected')"><i class="bi bi-x-square"></i> Rejected</a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" onclick="showInfo('Notifications')"><i class="bi bi-bell"></i> Notifications</a>
  <a class="nav-item" onclick="showInfo('Profile')"><i class="bi bi-person"></i> Profile</a>

  <div class="sidebar-footer">
    <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
  </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
  <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <div class="topbar-title">Disaster Management Officer <span style="color:#10b981">Dashboard</span></div>
  <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
    <i class="bi bi-bell"></i><span class="notif-badge">2</span>
  </button>
  <div class="user-pill" onclick="showInfo('Profile')">
    <div class="user-avatar" style="background:#064e3b"><i class="bi bi-person-fill"></i></div>
    <span class="user-name"><?php echo htmlspecialchars($username);?></span>
    <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
  </div>
</header>

<!-- MAIN -->
<main id="main">

  <!-- Summary Strip -->
  <div class="summary-strip">
    <div class="strip-card">
      <div class="strip-icon blue"><i class="bi bi-file-earmark-text"></i></div>
      <div><div class="strip-val" id="s-total">0</div><div class="strip-lbl">Requests Received</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon amber"><i class="bi bi-hourglass-split"></i></div>
      <div><div class="strip-val" id="s-pending">0</div><div class="strip-lbl">Awaiting Review</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon green"><i class="bi bi-patch-check"></i></div>
      <div><div class="strip-val" id="s-approved">0</div><div class="strip-lbl">Approved</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon rose"><i class="bi bi-x-circle"></i></div>
      <div><div class="strip-val" id="s-rejected">0</div><div class="strip-lbl">Rejected</div></div>
    </div>
  </div>

  <div class="row g-3">

    <!-- Compensation Requests -->
    <div class="col-lg-7">
      <div class="panel">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-currency-dollar"></i> Compensation Requests</div>
          <span class="role-tag">DMO</span>
        </div>
        <div class="d-flex flex-column gap-3">

          <div class="report-card">
            <div class="report-thumb"><i class="bi bi-house-damage"></i></div>
            <div class="report-meta">
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="report-id">RPT-2024-0011</span>
                <span class="badge-status badge-verify">Verified</span>
              </div>
              <div class="report-type">Property Damage</div>
              <div class="report-by" style="font-size:11.5px;color:var(--muted)">Recommended Amount</div>
              <div class="amount-badge">Rs. 250,000</div>
            </div>
            <button class="btn btn-success btn-sm rounded-3" onclick="approveCompensation('RPT-2024-0011','250,000')">
              <i class="bi bi-check-lg me-1"></i>Review
            </button>
          </div>

          <div class="report-card">
            <div class="report-thumb"><i class="bi bi-person-x"></i></div>
            <div class="report-meta">
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="report-id">RPT-2024-0010</span>
                <span class="badge-status badge-verify">Verified</span>
              </div>
              <div class="report-type">Missing Person</div>
              <div class="report-by" style="font-size:11.5px;color:var(--muted)">Recommended Amount</div>
              <div class="amount-badge">Rs. 500,000</div>
            </div>
            <button class="btn btn-success btn-sm rounded-3" onclick="approveCompensation('RPT-2024-0010','500,000')">
              <i class="bi bi-check-lg me-1"></i>Review
            </button>
          </div>

          <div class="report-card">
            <div class="report-thumb"><i class="bi bi-file-medical"></i></div>
            <div class="report-meta">
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="report-id">RPT-2024-0008</span>
                <span class="badge-status badge-verify">Verified</span>
              </div>
              <div class="report-type">Death Report</div>
              <div class="report-by" style="font-size:11.5px;color:var(--muted)">Recommended Amount</div>
              <div class="amount-badge">Rs. 750,000</div>
            </div>
            <button class="btn btn-success btn-sm rounded-3" onclick="approveCompensation('RPT-2024-0008','750,000')">
              <i class="bi bi-check-lg me-1"></i>Review
            </button>
          </div>

        </div>
        <div class="mt-3">
          <button class="btn btn-outline-success rounded-3 w-100" onclick="showInfo('All Requests')">View All Requests</button>
        </div>
      </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-5 d-flex flex-column gap-3">

      <!-- Compensation Chart -->
      <div class="panel">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Compensation by Type</div>
        </div>
        <div class="chart-wrap">
          <canvas id="dmo-chart"></canvas>
        </div>
      </div>

      <!-- Notifications -->
      <div class="panel">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bell"></i> Notifications</div>
          <a class="stat-link" onclick="showInfo('All Notifications')">View All</a>
        </div>
        <div class="notif-item">
          <div class="notif-icon green"><i class="bi bi-check-circle-fill"></i></div>
          <div class="notif-text"><strong>RPT-2024-0011</strong> verified and forwarded by Local Authority.</div>
          <div class="notif-time">1h ago</div>
        </div>
        <div class="notif-item">
          <div class="notif-icon blue"><i class="bi bi-info-circle-fill"></i></div>
          <div class="notif-text">3 new compensation requests are awaiting your review.</div>
          <div class="notif-time">2h ago</div>
        </div>
        <div class="notif-item">
          <div class="notif-icon amber"><i class="bi bi-bell-fill"></i></div>
          <div class="notif-text">Monthly compensation report is ready to download.</div>
          <div class="notif-time">1d ago</div>
        </div>
      </div>

    </div>
  </div>

  <footer class="mt-4">&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="DMOdashboard.js"></script>
</body>
</html>
