<?php
    // Include user data/dashboard connections
    include 'Citizendashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Reports - Post-Disaster Reporting System</title>

  <!-- External Stylesheets -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link href="../style.css" rel="stylesheet">
</head>
<body>

<!-- Navigation Sidebar -->
<nav id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">
        <img src="../pictures/Post-Disaster-Reporting-Logo-Notxt.png" alt="Logo">
    </div>
    <div>
      <div class="brand-title">Post-Disaster</div>
      <div class="brand-sub">Reporting System</div>
    </div>
  </div>

  <div class="nav-section-label">Reports</div>
  <a class="nav-item" <?php echo !empty($isBank) ? 'onclick="newReport()"' : 'href="CitizenProfileForm.php"'; ?>>
   <i class="bi bi-file-earmark-plus"></i> Submit New Report
  </a>
  <!-- Set Active Class on My Reports -->
  <a class="nav-item active" href="CitizenMyReportsForm.php">
    <i class="bi bi-file-earmark-text"></i> My Reports
  </a>
  <a class="nav-item" href="CitizenTrackReportForm.php">
    <i class="bi bi-search"></i> Track Report
  </a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" href="CitizenDashboardForm.php">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>
  <a class="nav-item" href="CitizenprofileForm.php">
    <i class="bi bi-person"></i> Profile
  </a>

  <div class="sidebar-footer">
    <a class="nav-item" onclick="confirmLogout()">
      <i class="bi bi-box-arrow-left"></i> Logout
    </a>
  </div>
</nav>

<!-- Topbar -->
<header id="topbar">
  <button id="menu-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>

  <div class="topbar-title">
    Welcome, <span>Citizen</span>
  </div>

  <button class="notif-btn" onclick="showNotifications()" title="Notifications">
    <i class="bi bi-bell"></i>
    <?php if(!empty($NotificationCount) && $NotificationCount > 0): ?>
    <span class="notif-badge"><?php echo $NotificationCount ?></span>
    <?php endif; ?>
  </button>

  <div class="user-pill" onclick="window.location.href='CitizenprofileForm.php';">
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

<!-- Main Container -->
<main id="main">

  <!-- Full-Width My Reports Panel -->
  <div class="row g-3 mb-4">
    <div class="col-12">
      <div class="panel">
        <div class="panel-header d-flex justify-content-between align-items-center mb-3">
          <div class="panel-title fs-5 fw-bold">
            <i class="bi bi-file-earmark-spreadsheet me-2 text-primary"></i> My Submitted Reports
          </div>
          <button class="btn btn-primary btn-sm rounded-3" onclick="newReport()">
            <i class="bi bi-plus-lg me-1"></i> New Report
          </button>
        </div>

        <div class="table-responsive">
          <table id="reports-table" class="table table-borderless align-middle" style="width:100%">
            <thead>
              <tr>
                <th>Report ID</th>
                <th>Type</th>
                <th>Location</th>
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
                    <td><i class="bi bi-geo-alt text-muted me-1"></i><?php echo htmlspecialchars($row['District']); ?></td>
                    <td>
                      <span class="badge-status badge-pending">
                        <?php echo htmlspecialchars($row['Report_Status']); ?>
                      </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['Report_Date']); ?></td>
                    <td>
                      <button class="btn btn-sm btn-outline-secondary rounded-2"
                        onclick="viewReport(
                          '<?php echo htmlspecialchars($row['Report_ID']); ?>',
                          '<?php echo htmlspecialchars($row['Report_Type']); ?>',
                          '<?php echo htmlspecialchars($row['District']); ?>',
                          '<?php echo htmlspecialchars($row['Report_Status']); ?>',
                          '<?php echo htmlspecialchars($row['Report_Date']); ?>'
                        )">
                        <i class="bi bi-eye"></i>
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

</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="Citizendashboard.js"></script>

</body>
</html>