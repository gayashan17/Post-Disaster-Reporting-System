<?php
    session_start();
    include '../userData.php';
    include '../DBconnection.php';


    // 1. get Summary Counts
    try
    {
        $query = "SELECT COUNT(Report_ID) AS total,
        SUM(Report_Status IN ('submitted', 'under review')) AS pending,
        SUM(Report_Status IN ('compensation approved')) AS approved,
        SUM(Report_Status IN ('payment completed')) AS pCompleted
        FROM disaster_report WHERE User_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
        {
            $totReportCount = (int)$row['total'];
            $pendigReportCount = (int)$row['pending'];
            $approvedReportCount = (int)$row['approved'];
            $pCompletedReportCount = (int)$row['pCompleted'];
        }
        else
        {
            $totReportCount = 0;
            $pendigReportCount = 0;
            $approvedReportCount = 0;
            $pCompletedReportCount = 0;
        }
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $totReportCount = 0;
        $pendigReportCount = 0;
        $approvedReportCount = 0;
        $pCompletedReportCount = 0;
    }

    // Initialize Chart Count Variables
    $deathReportCount = 0;
    $injReportCount = 0;
    $missingReportCount = 0;
    $prDmgReportCount = 0;

    // 2. get Report Types Count
    try
    {
        $query = "SELECT Report_Type, COUNT(Report_ID) as type_count FROM disaster_report WHERE User_ID = ? GROUP BY Report_Type";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($result))
        {
            $count = (int)$row['type_count'];
            switch ($row['Report_Type'])
            {
                case 'Death Record':
                case 'Death Report':
                    $deathReportCount = $count;
                    break;
                case 'Injured Person':
                    $injReportCount = $count;
                    break;
                case 'Missing Person Record':
                case 'Missing Person':
                    $missingReportCount = $count;
                    break;
                case 'Property Damage':
                    $prDmgReportCount = $count;
                    break;
            }
        }
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
    }

    // 3. get Table Data
    try
    {
        $query = "SELECT Report_ID, Report_Type, District, Report_Status, Report_Date FROM disaster_report WHERE User_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $tableResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Post-Disaster Reporting System</title>

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
  <a class="nav-item" onclick="newReport()">
    <i class="bi bi-file-earmark-plus"></i> Submit New Report
  </a>
  <a class="nav-item" onclick="showInfo('My Reports')">
    <i class="bi bi-file-earmark-text"></i> My Reports
  </a>
  <a class="nav-item" onclick="showInfo('Track Report')">
    <i class="bi bi-search"></i> Track Report
  </a>

  <div class="nav-section-label">Notifications</div>
  <a class="nav-item" onclick="showInfo('Notifications')">
    <i class="bi bi-bell"></i> Notifications
  </a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item active" href="#">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>
  <a class="nav-item" href="profileForm.php">
    <i class="bi bi-person"></i> Profile
  </a>
  <a class="nav-item" onclick="showInfo('Settings')">
    <i class="bi bi-gear"></i> Settings
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
    <span class="notif-badge">3</span>
  </button>

  <a class="nav-item" href="profileForm.php">
    <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
    <span class="user-name"><?php echo htmlspecialchars($username ?? 'User'); ?></span>
    <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
  </a>
</header>

<!-- Main Dashboard Container -->
<main id="main">

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
      <div class="col-6 col-xl-3">
          <div class="stat-card">
              <div class="stat-icon blue"><i class="bi bi-file-earmark-text-fill"></i></div>
              <div>
                  <div class="stat-label">Total Reports</div>
                  <div class="stat-value" id="stat-total">0</div>
                  <a class="stat-link" onclick="showInfo('Total Reports')">View Details &rsaquo;</a>
              </div>
          </div>
      </div>

      <div class="col-6 col-xl-3">
          <div class="stat-card">
              <div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
              <div>
                  <div class="stat-label">Pending</div>
                  <div class="stat-value" id="stat-pending">0</div>
                  <a class="stat-link" onclick="showInfo('Pending Reports')">View Details &rsaquo;</a>
              </div>
          </div>
      </div>

      <div class="col-6 col-xl-3">
          <div class="stat-card">
              <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
              <div>
                  <div class="stat-label">Approved</div>
                  <div class="stat-value" id="stat-approved">0</div>
                  <a class="stat-link" onclick="showInfo('Approved Reports')">View Details &rsaquo;</a>
              </div>
          </div>
      </div>

      <div class="col-6 col-xl-3">
          <div class="stat-card">
              <div class="stat-icon purple"><i class="bi bi-credit-card-fill"></i></div>
              <div>
                  <div class="stat-label">Payments Completed</div>
                  <div class="stat-value" id="stat-payment">0</div>
                  <a class="stat-link" onclick="showInfo('Payments')">View Details &rsaquo;</a>
              </div>
          </div>
      </div>
  </div>

  <!-- Recent Reports and Notifications -->
  <div class="row g-3 mb-4">

    <!-- Reports Table -->
    <div class="col-lg-8">
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title">
            <i class="bi bi-file-earmark-spreadsheet"></i> Recent Reports
          </div>
          <button class="btn btn-primary btn-sm rounded-3" onclick="showInfo('All Reports')">
            <i class="bi bi-grid me-1"></i> View All
          </button>
        </div>

        <div class="table-responsive">
          <table id="reports-table" class="table table-borderless" style="width:100%">
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
            <?php if ($tableResult && mysqli_num_rows($tableResult) > 0): ?>
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
                        onclick="viewReport
                        (
                        '<?php echo htmlspecialchars($row['Report_ID']) ?>,',
                        '<?php echo htmlspecialchars($row['Report_Type']) ?>,',
                        '<?php echo htmlspecialchars($row['District']) ?>,',
                        '<?php echo htmlspecialchars($row['Report_Status']) ?>,',
                        '<?php echo htmlspecialchars($row['Report_Date']) ?>,',
                        )">
                        <i class="bi bi-eye"></i>
                      </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No reports found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Notifications Panel -->
    <div class="col-lg-4">
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bell"></i> Notifications</div>
          <a class="stat-link" onclick="showInfo('All Notifications')">View All</a>
        </div>

        <div class="notif-item">
          <div class="notif-icon green"><i class="bi bi-check-circle-fill"></i></div>
          <div class="notif-text">
            Report <strong>RPT-2024-0011</strong> has been approved by Disaster Management Officer.
          </div>
          <div class="notif-time">2h ago</div>
        </div>

        <div class="notif-item">
          <div class="notif-icon blue"><i class="bi bi-info-circle-fill"></i></div>
          <div class="notif-text">
            Report <strong>RPT-2024-0012</strong> is under verification.
          </div>
          <div class="notif-time">1d ago</div>
        </div>

        <div class="notif-item">
          <div class="notif-icon purple"><i class="bi bi-credit-card-fill"></i></div>
          <div class="notif-text">
            Payment for <strong>RPT-2024-0009</strong> has been completed.
          </div>
          <div class="notif-time">2d ago</div>
        </div>

        <div class="notif-item">
          <div class="notif-icon amber"><i class="bi bi-bell-fill"></i></div>
          <div class="notif-text">
            New update regarding your report <strong>RPT-2024-0010</strong>.
          </div>
          <div class="notif-time">3d ago</div>
        </div>
      </div>
    </div>

  </div>

  <!-- Status Flow, Chart, Quick Actions -->
  <div class="row g-3 mb-4">

    <!-- Status Flow -->
    <div class="col-lg-5">
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-diagram-3"></i> Report Status Flow</div>
        </div>
        <div class="flow-wrap">

          <div class="flow-step">
            <div class="flow-circle blue"><i class="bi bi-file-earmark-text"></i></div>
            <div class="flow-label">Report Submitted</div>
            <div class="flow-sub">By Citizen</div>
          </div>

          <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

          <div class="flow-step">
            <div class="flow-circle amber"><i class="bi bi-search"></i></div>
            <div class="flow-label">Under Verification</div>
            <div class="flow-sub">By Local Authority</div>
          </div>

          <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

          <div class="flow-step">
            <div class="flow-circle green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="flow-label">Compensation Approved</div>
            <div class="flow-sub">By DMO Officer</div>
          </div>

          <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

          <div class="flow-step">
            <div class="flow-circle purple"><i class="bi bi-credit-card"></i></div>
            <div class="flow-label">Payment Completed</div>
            <div class="flow-sub">By Financial Officer</div>
          </div>

        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="col-lg-4">
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Reports by Type</div>
        </div>
        <div class="chart-wrap">
          <canvas id="report-chart"></canvas>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-3">
      <div class="panel h-100">
        <div class="panel-header">
          <div class="panel-title">
            <i class="bi bi-lightning-charge-fill" style="color:var(--gold)"></i> Quick Actions
          </div>
        </div>
        <div class="d-flex flex-column gap-2">
          <a class="qa-btn" onclick="newReport()">
            <i class="bi bi-plus-circle-fill"></i> Submit New Report
          </a>
          <a class="qa-btn" onclick="showInfo('Track My Report')">
            <i class="bi bi-search"></i> Track My Report
          </a>
          <a class="qa-btn" onclick="showInfo('View Notifications')">
            <i class="bi bi-bell-fill"></i> View Notifications
          </a>
          <a class="qa-btn" onclick="showInfo('Update Profile')">
            <i class="bi bi-person-fill"></i> Update Profile
          </a>
        </div>
      </div>
    </div>

  </div>

</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="Citizendashboard.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof animateCounter === 'function') {
            animateCounter('stat-total', <?php echo (int)$totReportCount; ?>);
            animateCounter('stat-pending', <?php echo (int)$pendigReportCount; ?>);
            animateCounter('stat-approved', <?php echo (int)$approvedReportCount; ?>);
            animateCounter('stat-payment', <?php echo (int)$pCompletedReportCount; ?>);
        }

        const chartLabels = ['Property Damage', 'Missing Person', 'Death Report', 'Injured Person'];
        const chartData = [
            <?php echo (int)$prDmgReportCount; ?>,
            <?php echo (int)$missingReportCount; ?>,
            <?php echo (int)$deathReportCount; ?>,
            <?php echo (int)$injReportCount; ?>
        ];

        if (typeof renderReportChart === 'function') {
            renderReportChart(chartLabels, chartData);
        }
    });
</script>

</body>
</html>