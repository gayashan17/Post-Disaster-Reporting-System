<?php
    include 'LAOdashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Reports - Local Authority Officer</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
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
  <a class="nav-item" href="LAOVerifiedReportsForm.php"><i class="bi bi-check-square"></i> Verified Reports</a>
  <a class="nav-item" href="LAORejectedReportsForm.php"><i class="bi bi-x-square"></i> Rejected Reports</a>
  <a class="nav-item active" href="LAOAllReportsForm.php"><i class="bi bi-file-earmark-text"></i> All Reports</a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" href="LAOdashboardForm.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
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
  <div class="user-pill" onclick="window.location.href='LAOProfileForm.php.php';">
    <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
    <span class="user-name"><?php echo htmlspecialchars($username ?? '');?></span>
    <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
  </div>
</header>

<!-- MAIN -->
<main id="main">
  <div class="row g-3 mb-4">
    <div class="col-12">
      <div class="panel">
        <div class="panel-header d-flex justify-content-between align-items-center mb-3">
          <div class="panel-title fs-5 fw-bold">
            <i class="bi bi-file-earmark-spreadsheet me-2 text-primary"></i> All Assigned Reports
          </div>
          <span class="role-tagLAO">Local Authority</span>
        </div>

        <div class="table-responsive">
          <table id="all-reports-table" class="table table-borderless align-middle" style="width:100%">
            <thead>
              <tr>
                <th>Report ID</th>
                <th>Type</th>
                <th>Reported By</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php if (isset($tableResult) && $tableResult && mysqli_num_rows($tableResult) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($tableResult)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['Report_ID']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['Report_Type']); ?></td>
                    <td><?php echo htmlspecialchars($row['Full_Name']); ?></td>
                    <td>
                      <span class="badge-status badge-pending">
                        <?php echo htmlspecialchars($row['Report_Status']); ?>
                      </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['Report_Date']); ?></td>
                    <td>
                      <button class="btn btn-sm btn-outline-primary rounded-2"
                        onclick="reviewReport(
                          'Report ID: <?php echo htmlspecialchars($row['Report_ID']); ?>',
                          '<?php echo htmlspecialchars($row['Report_Type']); ?>',
                          '<?php echo htmlspecialchars($row['Full_Name']); ?>'
                        )">
                        <i class="bi bi-eye me-1"></i>View
                      </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No reports found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer class="mt-4">&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script src="LAOdashboard.js"></script>

<script>
  $(document).ready(function() {
      $('#all-reports-table').DataTable({
          "pageLength": 10,
          "ordering": true
      });
  });
</script>
</body>
</html>