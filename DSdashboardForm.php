<?php
    session_start();
    include 'userData.php';
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

    <link href="/Post-Disaster-Reporting-System/assets/css/style.css" rel="stylesheet" />
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
      <div class="topbar-title">District Secretary <span style="color:#10b981">Dashboard</span></div>
      <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i><span class="notif-badge">2</span>
      </button>
      <div class="user-pill" onclick="showInfo('Profile')">
        <div class="user-avatar" style="background:#064e3b"><i class="bi bi-person-fill"></i></div>
        <span class="user-name"><?php echo htmlspecialchars($username);?></span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
      </div>
    </header>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

    <script src="DSdashboard.js"></script>
</body>
</html>