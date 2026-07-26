<?php
    include 'LAOdashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Local Authority Officer Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="../style.css" rel="stylesheet">
</head>
<body>

<!-- SIDEBAR -->
<nav id="sidebarLAO">
  <div class="sidebar-brand">
    <div class="brand-icon"><img src="../pictures/Post-Disaster-Reporting-Logo-Notxt.png" alt="Logo"></div>
    <div>
      <div class="brand-title">Post-Disaster</div>
      <div class="brand-sub">Reporting System</div>
    </div>
  </div>

  <div class="nav-section-label">Reports</div>
  <a class="nav-item" href="LAOVerifiedReportsForm.php" ><i class="bi bi-check-square"></i> Verified Reports</a>
  <a class="nav-item" href="LAORejectedReportsForm.php"><i class="bi bi-x-square"></i> Rejected Reports</a>
  <a class="nav-item" href="LAOAllReportsForm.php"><i class="bi bi-file-earmark-text"></i> All Reports</a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a class="nav-item" href="LAOProfileForm.php"><i class="bi bi-person"></i> Profile</a>

  <div class="sidebar-footer">
    <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
  </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
  <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <div class="topbar-title">Local Authority Officer <span>Dashboard</span></div>
  <button class="notif-btn" onclick="showNotifications()" title="Notifications">
    <i class="bi bi-bell"></i>
    <?php if(!empty($NotificationCount) && $NotificationCount > 0): ?>
      <span class="notif-badge"><?php echo $NotificationCount; ?></span>
    <?php endif; ?>
  </button>
  <div class="user-pill" onclick="window.location.href='LAOProfileForm.php';">
    <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
    <span class="user-name"><?php echo htmlspecialchars($username ?? '');?></span>
    <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
  </div>
</header>

<!-- MAIN -->
<main id="main">

  <!-- Summary Strip -->
  <div class="summary-strip mb-4">
    <div class="strip-card">
      <div class="strip-icon blue"><i class="bi bi-file-earmark-text"></i></div>
      <div><div class="strip-val" id="s-total">0</div><div class="strip-lbl">Total Assigned</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon amber"><i class="bi bi-hourglass-split"></i></div>
      <div><div class="strip-val" id="s-pending">0</div><div class="strip-lbl">Pending</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon green"><i class="bi bi-check-circle"></i></div>
      <div><div class="strip-val" id="s-verified">0</div><div class="strip-lbl">Verified</div></div>
    </div>
    <div class="strip-card">
      <div class="strip-icon rose"><i class="bi bi-x-circle"></i></div>
      <div><div class="strip-val" id="s-rejected">0</div><div class="strip-lbl">Rejected</div></div>
    </div>
  </div>

  <div class="row g-3">

    <!-- Left Column: Pending Reports (Expanded to fill column height) -->
    <div class="col-lg-7">
      <div class="panel h-100 d-flex flex-column justify-content-between">
        <div>
          <div class="panel-header">
            <div class="panel-title"><i class="bi bi-hourglass-split"></i> Pending Reports</div>
            <span class="role-tagLAO">Local Authority</span>
          </div>
          <div class="d-flex flex-column gap-3">

          <?php if (!empty($tableResult) && mysqli_num_rows($tableResult) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($tableResult)): ?>
                <div class="report-card">
                  <div class="report-thumb">
                      <?php if($row['Report_Type']=="Property Damage"):?>
                        <i class="bi bi-house"></i>
                      <?php elseif ($row['Report_Type']=="Missing Person Record"): ?>
                        <i class="bi bi-person-exclamation"></i>
                      <?php elseif ($row['Report_Type']=="Death Record"): ?>
                        <i class="bi bi-person-exclamation"></i>
                        <?php elseif ($row['Report_Type']=="Injured Person"): ?>
                        <i class="bi bi-hospital"></i>
                      <?php endif; ?>
                  </div>
                  <div class="report-meta">
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <span class="report-id">Report ID: <?php echo htmlspecialchars($row['Report_ID']) ?></span>
                      <span class="badge-status badge-pending"><?php echo htmlspecialchars($row['Report_Status']) ?></span>
                    </div>
                    <div class="report-type"><?php echo htmlspecialchars($row['Report_Type']) ?></div>
                    <div class="report-by">Reported by: <?php echo htmlspecialchars($row['Full_Name']) ?></div>
                    <div class="report-date"><i class="bi bi-calendar3 me-1"></i> <?php echo htmlspecialchars($row['Report_Date']) ?></div>
                  </div>
                  <div class="d-flex flex-column gap-2">
                    <button class="btn btn-primary btn-sm rounded-3"
                      onclick="reviewReport
                      ('Report ID: <?php echo htmlspecialchars($row['Report_ID']) ?>',
                      '<?php echo htmlspecialchars($row['Report_Type']) ?>',
                      '<?php echo htmlspecialchars($row['Full_Name']) ?>')">

                      <i class="bi bi-eye me-1"></i>Review
                    </button>
                  </div>
                </div>
              <?php endwhile; ?>
          <?php else: ?>
              <div class="text-center text-muted py-3">No pending reports found.</div>
          <?php endif; ?>

          </div>
        </div>

        <div class="mt-3 text-center">
          <a class="btn btn-outline-primary rounded-3 w-100" href="LAOAllReportsForm.php">View All Reports</a>
        </div>
      </div>
    </div>

    <!-- Right Column: Notifications Panel & Quick Actions -->
    <div class="col-lg-5 d-flex flex-column gap-3">

      <!-- Dynamic Notifications Panel -->
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bell"></i> Notifications</div>
          <a class="stat-link" onclick="showNotifications()">View All</a>
        </div>

        <?php
        $notificationIDs = [];
        if (!empty($Notifications) && mysqli_num_rows($Notifications) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($Notifications)): ?>
                <?php $notificationIDs[] = $row['Notification_ID']; ?>
                <div class="notif-item">
                  <?php if(in_array($row['Report_Status'], ["LAO Approved", "DMO Approved", "DS Approved", "FO Approved"])): ?>
                      <div class="notif-icon green">
                        <i class="bi bi-check-circle-fill"></i>
                      </div>
                  <?php elseif(in_array($row['Report_Status'], ["LAO Pending", "DMO Pending", "DS Pending", "FO Pending", "Submitted"])): ?>
                      <div class="notif-icon blue">
                        <i class="bi bi-info-circle-fill"></i>
                      </div>
                  <?php elseif(in_array($row['Report_Status'], ["LAO Rejected", "DMO Rejected", "DS Rejected", "FO Rejected"])): ?>
                      <div class="notif-icon red">
                        <i class="bi bi-x-circle-fill"></i>
                      </div>
                  <?php elseif($row['Report_Status'] == "FO Paid"): ?>
                      <div class="notif-icon purple">
                        <i class="bi bi-credit-card-fill"></i>
                      </div>
                  <?php else: ?>
                      <div class="notif-icon blue">
                        <i class="bi bi-info-circle-fill"></i>
                      </div>
                  <?php endif; ?>

                  <div class="notif-text">
                    Report <strong><?php echo htmlspecialchars($row['Report_ID']); ?>: </strong><br>
                    <?php echo htmlspecialchars($row['Notification_Message']); ?>
                  </div>
                  <div class="notif-time"><?php echo htmlspecialchars($row['Created_At']); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="notif-item">
              <div class="notif-icon green">
                <i class="bi bi-info-circle-fill"></i>
              </div>
              <div class="notif-text">You have No Recent Notifications</div>
            </div>
        <?php endif; ?>
      </div>

      <!-- Quick Actions -->
      <div class="panel">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-lightning-charge-fill" style="color:var(--gold)"></i> Quick Actions</div>
        </div>
        <div class="d-flex flex-column gap-2">
          <a class="qa-btn" href="LAOAllReportsForm.php"><i class="bi bi-hourglass-split"></i> View All Reports</a>
          <a class="qa-btn" href="LAOVerifiedReportsForm.php"><i class="bi bi-check-circle-fill text-primary"></i> View Verified Reports</a>
          <a class="qa-btn" href="LAORejectedReportsForm.php"><i class="bi bi-x-circle-fill text-danger"></i> View Rejected Reports</a>
          <a class="qa-btn" onclick="showNotifications()"><i class="bi bi-bell-fill color-purple"></i> Notifications</a>
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

<script src="LAOdashboard.js"></script>

<?php
$notificationsArray = [];
if (!empty($Notifications) && mysqli_num_rows($Notifications) > 0) {
    mysqli_data_seek($Notifications, 0);
    while ($row = mysqli_fetch_assoc($Notifications)) {
        $notificationsArray[] = [
            'report_id' => $row['Report_ID'] ?? '',
            'title'     => $row['Notification_Title'] ?? 'Notification',
            'message'   => $row['Notification_Message'] ?? '',
            'time'      => $row['Created_At'] ?? ''
        ];
    }
}
?>

<!-- Inject notification arrays into JavaScript -->
<script>
    const userNotifications = <?php echo json_encode($notificationsArray); ?>;
    const notificationIDs  = <?php echo json_encode($notificationIDs); ?>;
</script>

<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        if (typeof animateCounter === 'function')
        {
            animateCounter('s-total', <?php echo (int)($totReportCount ?? 0); ?>);
            animateCounter('s-pending', <?php echo (int)($submittedReportCount ?? 0); ?>);
            animateCounter('s-verified', <?php echo (int)($verifiedReportCount ?? 0); ?>);
            animateCounter('s-rejected', <?php echo (int)($rejectedReportCount ?? 0); ?>);
        }
    });
</script>
</body>
</html>