<?php
    include_once 'LAOdashboard.php';
    include 'LAOTrackReport.php';

    // Fallback if $type isn't explicitly set in LAOTrackReport.php
    $type = $type ?? $selectedReport['Report_Type'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pending Reports - Local Authority Officer</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link href="../style.css" rel="stylesheet">
  <link href="LAO.css" rel="stylesheet">
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
  <a class="nav-item active" href="LAOPendingReportsForm.php"><i class="bi bi-clock-history"></i> Pending Reports</a>
  <a class="nav-item" href="LAOVerifiedReportsForm.php"><i class="bi bi-check-square"></i> Verified Reports</a>
  <a class="nav-item" href="LAORejectedReportsForm.php"><i class="bi bi-x-square"></i> Rejected Reports</a>
  <a class="nav-item" href="LAOAllReportsForm.php"><i class="bi bi-file-earmark-text"></i> All Reports</a>

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
  <div class="user-pill" onclick="window.location.href='LAOProfileForm.php';">
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
            <i class="bi bi-hourglass-split me-2 text-warning"></i> Pending Review Reports
          </div>
          <span class="role-tagLAO">Local Authority</span>
        </div>

        <div class="table-responsive">
          <table id="pending-reports-table" class="table table-borderless align-middle" style="width:100%">
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
            <?php if (isset($pendingResult) && $pendingResult && mysqli_num_rows($pendingResult) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($pendingResult)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['Report_ID']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['Report_Type']); ?></td>
                    <td><?php echo htmlspecialchars($row['Full_Name'] ?? 'Citizen'); ?></td>
                    <td>
                      <span class="badge bg-warning text-dark px-2 py-1">
                        <?php echo htmlspecialchars($row['Report_Status']); ?>
                      </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['Report_Date']); ?></td>
                    <td>
                      <a class="btn btn-sm btn-outline-primary rounded-2"
                        href="LAOPendingReportsForm.php?report_id=<?php echo urlencode($row['Report_ID']); ?>">
                        <i class="bi bi-eye me-1"></i>View
                      </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No pending reports found for verification.</td>
                </tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty($selectedReport)): ?>
    <!-- Side-by-Side Detailed Report & Evidence Panel Container -->
    <div class="row g-3 mb-4" id="selectedReportSection">

      <!-- Left Column: Report Details (7/12 width) -->
      <div class="col-lg-7">
        <div class="panel h-100">
          <div class="panel-header d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
            <div class="panel-title fw-bold text-primary">
              <i class="bi bi-info-circle me-2"></i> Report Details — #<?php echo htmlspecialchars($selectedReport['Report_ID']); ?>
            </div>
            <a href="LAOPendingReportsForm.php" class="btn-close" aria-label="Close"></a>
          </div>
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:30%">Report ID:</td>
                <td class="fw-bold">#<?php echo htmlspecialchars($selectedReport['Report_ID']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Type:</td>
                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($selectedReport['Report_Type'] ?? '-'); ?></span></td>
              </tr>
              <tr>
                <td class="text-muted">District:</td>
                <td><i class="bi bi-geo-alt me-1 text-danger"></i><?php echo htmlspecialchars($selectedReport['District'] ?? '-'); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Street Address:</td>
                <td><?php echo htmlspecialchars($selectedReport['Street_Address'] ?? '-'); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Date Submitted:</td>
                <td><i class="bi bi-calendar3 me-1 text-primary"></i><?php echo htmlspecialchars($selectedReport['Report_Date'] ?? '-'); ?></td>
              </tr>
              <tr>
                <td class="text-muted align-top">Description:</td>
                <td>
                  <div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-line;">
                    <?php echo !empty($selectedReport['Description']) ? htmlspecialchars($selectedReport['Description']) : 'No additional description provided.'; ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Right Column: Uploaded Evidence (5/12 width) -->
      <div class="col-lg-5">
        <div class="panel h-100">
          <div class="panel-header mb-3 border-bottom pb-2">
            <div class="panel-title fw-bold text-primary"><i class="bi bi-paperclip me-2"></i> Uploaded Documents & Evidence</div>
          </div>

          <?php
            $filePath = $selectedReport['File_Path'] ?? $selectedReport['File_Name'] ?? null;
          ?>

          <?php if (!empty($filePath)): ?>
            <?php
              $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
              $fullPath = "../reports/" . htmlspecialchars($filePath);
            ?>

            <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])): ?>
              <div class="text-center">
                <img src="<?php echo $fullPath; ?>" alt="Report Evidence" class="img-fluid rounded-3 shadow-sm border mb-2" style="max-height:280px; object-fit:cover;">
                <div>
                  <a href="<?php echo $fullPath; ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                    <i class="bi bi-arrows-fullscreen me-1"></i> View Full Image
                  </a>
                </div>
              </div>

            <?php elseif ($ext === 'pdf'): ?>
              <div class="text-center p-4 border rounded-3 bg-light">
                <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 3rem;"></i>
                <div class="fw-bold mt-2"><?php echo htmlspecialchars($filePath); ?></div>
                <a href="<?php echo $fullPath; ?>" download="<?php echo htmlspecialchars($filePath); ?>" target="_blank" class="btn btn-sm btn-danger mt-3">
                  <i class="bi bi-file-earmark-arrow-down me-1"></i> Download PDF Document
                </a>
              </div>

            <?php else: ?>
              <div class="text-center p-4 border rounded-3 bg-light">
                <i class="bi bi-file-earmark-zip-fill text-secondary" style="font-size: 3rem;"></i>
                <div class="fw-bold mt-2"><?php echo htmlspecialchars($filePath); ?></div>
                <a href="<?php echo $fullPath; ?>" download class="btn btn-sm btn-secondary mt-3">
                  <i class="bi bi-download me-1"></i> Download File
                </a>
              </div>
            <?php endif; ?>

          <?php else: ?>
            <div class="text-center py-5 text-muted">
              <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
              No uploaded images or documents attached to this report.
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- Subtype Specific Panels -->
    <?php if ($type == "Property Damage" && !empty($ReportData) && is_array($ReportData)): ?>
      <div class="panel mt-3">
        <div class="panel-header mb-3 border-bottom pb-2">
          <div class="panel-title fw-bold text-danger">Property Damage Details</div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr><td class="text-muted" style="width:25%">Property:</td><td class="fw-bold"><?php echo htmlspecialchars($ReportData['Property_Type'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Damage Level:</td><td><?php echo htmlspecialchars($ReportData['Damage_Level'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Estimated Cost:</td><td><?php echo htmlspecialchars($ReportData['Estimated_Cost'] ?? '-'); ?></td></tr>
              <tr>
                <td class="text-muted align-top">Damage Description:</td>
                <td><div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-line;"><?php echo htmlspecialchars($ReportData['Damage_Description'] ?? 'None'); ?></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($type == "Missing Person Record" && !empty($ReportData) && is_array($ReportData)): ?>
      <div class="panel mt-3">
        <div class="panel-header mb-3 border-bottom pb-2">
          <div class="panel-title fw-bold text-danger">Missing Person Details</div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr><td class="text-muted" style="width:25%">Full Name:</td><td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Age:</td><td><?php echo htmlspecialchars($ReportData['Age'] ?? '-'); ?> years old</td></tr>
              <tr><td class="text-muted">Gender:</td><td><span class="badge bg-secondary"><?php echo htmlspecialchars($ReportData['Gender'] ?? '-'); ?></span></td></tr>
              <tr><td class="text-muted">Last Seen Location:</td><td><?php echo htmlspecialchars($ReportData['Last_Seen_Location'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Last Seen Date:</td><td><?php echo htmlspecialchars($ReportData['Last_Seen_Date'] ?? '-'); ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($type == "Injured Person" && !empty($ReportData) && is_array($ReportData)): ?>
      <div class="panel mt-3">
        <div class="panel-header mb-3 border-bottom pb-2">
          <div class="panel-title fw-bold text-danger">Injured Person Details</div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr><td class="text-muted" style="width:25%">Full Name:</td><td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Age:</td><td><?php echo htmlspecialchars($ReportData['Age'] ?? '-'); ?> years old</td></tr>
              <tr><td class="text-muted">Gender:</td><td><span class="badge bg-secondary"><?php echo htmlspecialchars($ReportData['Gender'] ?? '-'); ?></span></td></tr>
              <tr><td class="text-muted">Injury Level:</td><td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($ReportData['Injured_Level'] ?? '-'); ?></span></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($type == "Death Record" && !empty($ReportData) && is_array($ReportData)): ?>
      <div class="panel mt-3">
        <div class="panel-header mb-3 border-bottom pb-2">
          <div class="panel-title fw-bold text-danger">Deceased Person Details</div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr><td class="text-muted" style="width:25%">Full Name:</td><td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name'] ?? '-'); ?></td></tr>
              <tr><td class="text-muted">Age:</td><td><?php echo htmlspecialchars($ReportData['Age'] ?? '-'); ?> years old</td></tr>
              <tr><td class="text-muted">Gender:</td><td><span class="badge bg-secondary"><?php echo htmlspecialchars($ReportData['Gender'] ?? '-'); ?></span></td></tr>
              <tr><td class="text-muted">Cause of Death:</td><td><div class="p-3 bg-light rounded-3 text-dark border"><?php echo htmlspecialchars($ReportData['Cause_Of_Death'] ?? '-'); ?></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!-- accept / reject buttons -->
    <div class="panel mt-4 p-4 border-top">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div>
          <h5 class="fw-bold text-dark mb-1">Take Action on Report #<?php echo htmlspecialchars($selectedReport['Report_ID']); ?></h5>
          <p class="text-muted mb-0 fs-6">Review details thoroughly before approving or rejecting this report.</p>
        </div>
        <div class="d-flex gap-2">
          <a href="javascript:void(0)"
             onclick="processReportAction('<?php echo htmlspecialchars($selectedReport['Report_ID']); ?>', 'Accept')"
             class="btn btn-success px-4 py-2 rounded-3 shadow-sm fw-medium">
            <i class="bi bi-check-circle me-2"></i>Accept / Verify
          </a>
          <a href="javascript:void(0)"
             onclick="processReportAction('<?php echo htmlspecialchars($selectedReport['Report_ID']); ?>', 'Reject')"
             class="btn btn-outline-danger px-4 py-2 rounded-3 shadow-sm fw-medium">
            <i class="bi bi-x-circle me-2"></i>Reject Report
          </a>
        </div>
      </div>
    </div>

  <?php elseif (isset($_GET['report_id'])): ?>
    <div class="alert alert-warning rounded-3 shadow-sm" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i> Report: <?php echo htmlspecialchars($_GET['report_id']); ?> was not found.
    </div>
  <?php else: ?>
    <div class="text-center py-5 text-muted bg-white rounded-3 shadow-sm panel">
      <i class="bi bi-search text-primary fs-1 d-block mb-3"></i>
      <h5>Select a report from the table above to view its status and details.</h5>
    </div>
  <?php endif; ?>

  <footer class="mt-4">&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script src="LAOdashboard.js"></script>

<script>
  $(document).ready(function() {
      $('#pending-reports-table').DataTable({
          "pageLength": 10,
          "ordering": true
      });

      // Smooth scroll down to details when report_id parameter is set in URL
      if ($('#selectedReportSection').length) {
          $('html, body').animate({
              scrollTop: $("#selectedReportSection").offset().top - 90
          }, 500);
      }
  });

  // Action Handling Function (Accept / Reject)
  function processReportAction(reportId, action) {
      const isAccept = action === 'Accept';

      Swal.fire({
          title: isAccept ? 'Accept Report?' : 'Reject Report?',
          text: isAccept
            ? `Are you sure you want to verify Report #${reportId}?`
            : `Are you sure you want to reject Report #${reportId}?`,
          icon: isAccept ? 'question' : 'warning',
          showCancelButton: true,
          confirmButtonColor: isAccept ? '#198754' : '#dc3545',
          cancelButtonColor: '#6c757d',
          confirmButtonText: isAccept ? 'Yes, Accept' : 'Yes, Reject',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = `LAOPendingReportsForm.php?action=${action.toLowerCase()}&report_id=${reportId}`;
          }
      });
  }
</script>
</body>
</html>