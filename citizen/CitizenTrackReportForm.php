<?php
    include 'CitizenTrackReport.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Track Report - Post-Disaster Reporting System</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link href="../style.css" rel="stylesheet">
  <link href="Citizen.css" rel="stylesheet">
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
  <a class="nav-item" href="CitizenMyReportsForm.php">
    <i class="bi bi-file-earmark-text"></i> My Reports
  </a>
  <a class="nav-item active" href="CitizenTrackReportForm.php">
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
      <span class="user-name"><?php echo htmlspecialchars($username) ?></span>
  </div>
</header>

<!-- Main Container -->
<main id="main">

  <!-- Report Search Selector -->
  <div class="panel mb-4">
    <div class="panel-header mb-3">
      <div class="panel-title fs-5 fw-bold"><i class="bi bi-search text-primary me-2"></i> Track Your Disaster Report</div>
    </div>
    <form method="GET" action="CitizenTrackReportForm.php" class="row g-3 align-items-center">
      <div class="col-md-9">
        <select name="report_id" class="form-select rounded-3" required>
          <option value="">Select a Report to Track</option>
          <?php
            if (isset($tableResult) && $tableResult && mysqli_num_rows($tableResult) > 0) {
              mysqli_data_seek($tableResult, 0);
              while ($r = mysqli_fetch_assoc($tableResult)) {
                $selectedAttr = ($r['Report_ID'] == $selectedReportID) ? 'selected' : '';
                echo "<option value='{$r['Report_ID']}' {$selectedAttr}>Report: {$r['Report_ID']} - {$r['Report_Type']} ({$r['District']})</option>";
              }
            }
          ?>
        </select>
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100 rounded-3">
          <i class="bi bi-radar me-1"></i> Track Progress
        </button>
      </div>
    </form>
  </div>

  <?php if ($selectedReport): ?>
    <!-- 1. Road Map Process Stepper -->
    <div class="panel mb-4">
      <div class="panel-header mb-4">
        <div class="panel-title fw-bold">
          <i class="bi bi-diagram-3 me-2 text-primary"></i> Application Status Roadmap
        </div>
        <span class="badge <?php echo $isRejected ? 'bg-danger' : 'bg-primary'; ?> px-3 py-2 rounded-pill fs-6">
          Current Status: <?php echo htmlspecialchars($selectedReport['Report_Status']); ?>
        </span>
      </div>

      <div class="stepper-wrapper">
        <!-- Connecting Progress Bar calculation -->
        <?php
          $progressWidth = "0%";
          if (!$isRejected) {
            if ($currentStep == 2) $progressWidth = "16%";
            if ($currentStep == 3) $progressWidth = "32%";
            if ($currentStep == 4) $progressWidth = "48%";
            if ($currentStep == 5) $progressWidth = "64%";
            if ($currentStep == 6) $progressWidth = "80%";
          }
        ?>
        <div class="stepper-progress" style="width: <?php echo $progressWidth; ?>;"></div>

        <!-- Step 1 -->
        <div class="step-item <?php echo ($currentStep >= 1) ? ($currentStep > 1 ? 'completed' : 'active') : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep > 1) ? '<i class="bi bi-check-lg fs-4"></i>' : '1'; ?></div>
          <div class="step-title">Report Submitted</div>
          <div class="step-sub">By Citizen</div>
        </div>

        <!-- Step 2 -->
        <div class="step-item <?php echo ($currentStep >= 2) ? ($currentStep > 2 ? 'completed' : 'active') : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep > 2) ? '<i class="bi bi-check-lg fs-4"></i>' : '2'; ?></div>
          <div class="step-title">Under Verification</div>
          <div class="step-sub">Local Authority Officer</div>
        </div>

        <!-- Step 3 -->
        <div class="step-item <?php echo ($currentStep >= 3) ? ($currentStep > 3 ? 'completed' : 'active') : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep > 3) ? '<i class="bi bi-check-lg fs-4"></i>' : '3'; ?></div>
          <div class="step-title">Approval & Valuation</div>
          <div class="step-sub">DMO Officer</div>
        </div>

        <!-- Step 4 -->
        <div class="step-item <?php echo ($currentStep >= 4) ? ($currentStep > 4 ? 'completed' : 'active') : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep > 4) ? '<i class="bi bi-check-lg fs-4"></i>' : '4'; ?></div>
          <div class="step-title">District Officer Approval</div>
          <div class="step-sub">DS Officer</div>
        </div>

        <!-- Step 5 -->
        <div class="step-item <?php echo ($currentStep >= 5) ? ($currentStep > 5 ? 'completed' : 'active') : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep > 5) ? '<i class="bi bi-check-lg fs-4"></i>' : '5'; ?></div>
          <div class="step-title">Payment Handling</div>
          <div class="step-sub">Financial Officer</div>
        </div>

        <!-- Step 6 -->
        <div class="step-item <?php echo ($currentStep == 6) ? 'completed active' : ''; ?>">
          <div class="step-counter"><?php echo ($currentStep == 6) ? '<i class="bi bi-check-lg fs-4"></i>' : '6'; ?></div>
          <div class="step-title">Payment Completed</div>
          <div class="step-sub">Financial Officer</div>
        </div>
      </div>

      <!-- Rejected Message Banner -->
      <?php if ($isRejected): ?>
        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4 shadow-sm" role="alert">
          <i class="bi bi-x-circle-fill fs-3 me-3"></i>
          <div>
            <h6 class="fw-bold mb-1">Application Rejected</h6>
            <div>This disaster report has been reviewed and marked as rejected by the reviewing officer. Please review your submission details or contact your local divisional secretariat for further clarification.</div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- 2. Detailed Report Information & Uploaded Media -->
    <div class="row g-3">
      <!-- Metainfo Panel -->
      <div class="col-lg-7">
        <div class="panel h-100">
          <div class="panel-header mb-3">
            <div class="panel-title fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i> Report Details</div>
          </div>
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:30%">Report ID:</td>
                <td class="fw-bold">#<?php echo htmlspecialchars($selectedReport['Report_ID']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Type:</td>
                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($selectedReport['Report_Type']); ?></span></td>
              </tr>
              <tr>
                <td class="text-muted">District:</td>
                <td><i class="bi bi-geo-alt me-1 text-danger"></i><?php echo htmlspecialchars($selectedReport['District']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Street Address:</td>
                <td><?php echo htmlspecialchars($selectedReport['Street_Address']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Date Submitted:</td>
                <td><i class="bi bi-calendar3 me-1 text-primary"></i><?php echo htmlspecialchars($selectedReport['Report_Date']); ?></td>
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

      <!-- Uploaded Media Attachments Panel -->
      <div class="col-lg-5">
        <div class="panel h-100">
          <div class="panel-header mb-3">
            <div class="panel-title fw-bold"><i class="bi bi-paperclip me-2 text-primary"></i> Uploaded Documents & Evidence</div>
          </div>

          <?php
            $filePath = $selectedReport['File_Path'] ?? $selectedReport['Attachment'] ?? $selectedReport['Image_Path'] ?? null;
          ?>

          <?php if (!empty($filePath)): ?>
            <?php
              $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
              $fullPath = "../uploads/reports/" . htmlspecialchars($filePath);
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
                <a href="<?php echo $fullPath; ?>" target="_blank" class="btn btn-sm btn-danger mt-3">
                  <i class="bi bi-file-earmark-arrow-down me-1"></i> View / Download PDF Document
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

    <!--Property Damage (Only renders if Property Damage exists) -->
    <?php if ($type == "Property Damage" && !empty($ReportData) && is_array($ReportData)): ?>
      <div class="panel mt-4">
        <div class="panel-header mb-3">
          <div class="panel-title fw-bold text-danger">
            Property Damage Report
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:25%">Property:</td>
                <td class="fw-bold"><?php echo htmlspecialchars($ReportData['Property_Type']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Damage Level:</td>
                <td><?php echo htmlspecialchars($ReportData['Damage_Level']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Estimated Cost</td>
                <td>
                    <?php echo htmlspecialchars($ReportData['Estimated_Cost']); ?>
                </td>
              </tr>
              <tr>
                <td class="text-muted align-top">Damage Description:</td>
                <td>
                  <div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-line;">
                    <?php echo htmlspecialchars($ReportData['Damage_Description']); ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!--Missing Person Details (Only renders if death record exists) -->
    <?php if ($type == "Missing Person Record" && !empty($ReportData) && is_array($ReportData) ) : ?>
      <div class="panel mt-4">
        <div class="panel-header mb-3">
          <div class="panel-title fw-bold text-danger">
            Missing Person Record
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:25%">Full Name:</td>
                <td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Age:</td>
                <td><?php echo htmlspecialchars($ReportData['Age']); ?> years old</td>
              </tr>
              <tr>
                <td class="text-muted">Gender:</td>
                <td>
                  <span class="badge bg-secondary">
                    <?php echo htmlspecialchars($ReportData['Gender']); ?>
                  </span>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Last Seen Location:</td>
                <td><?php echo htmlspecialchars($ReportData['Last_Seen_Location']); ?></td>
              </tr>
                <tr>
                <td class="text-muted">Last Seen Date:</td>
                <td><?php echo htmlspecialchars($ReportData['Last_Seen_Date']); ?> </td>
              </tr><tr>
                <td class="text-muted">Last Seen Time:</td>
                <td><?php echo htmlspecialchars($ReportData['Last_Seen_Time']); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!--Injured Person Details (Only renders if death record exists) -->
    <?php if ($type == "Injured Person" && !empty($ReportData) && is_array($ReportData) ) : ?>
      <div class="panel mt-4">
        <div class="panel-header mb-3">
          <div class="panel-title fw-bold text-danger">
            Injured Person Record
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:25%">Full Name:</td>
                <td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Age:</td>
                <td><?php echo htmlspecialchars($ReportData['Age']); ?> years old</td>
              </tr>
              <tr>
                <td class="text-muted">Gender:</td>
                <td>
                  <span class="badge bg-secondary">
                    <?php echo htmlspecialchars($ReportData['Gender']); ?>
                  </span>
                </td>
              </tr>
              <tr>
                <td class="text-muted align-top">Injury Level:</td>
                <td>
                <span class="badge bg-warning">
                    <?php echo htmlspecialchars($ReportData['Injured_Level']); ?>
                </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!--Death Person Details (Only renders if death record exists) -->
    <?php if ($type == "Death Record" && !empty($ReportData) && is_array($ReportData) ) : ?>
      <div class="panel mt-4">
        <div class="panel-header mb-3">
          <div class="panel-title fw-bold text-danger">
            Deceased Person Record
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless fs-6 mb-0">
            <tbody>
              <tr>
                <td class="text-muted" style="width:25%">Full Name:</td>
                <td class="fw-bold"><?php echo htmlspecialchars($ReportData['Full_Name']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Age:</td>
                <td><?php echo htmlspecialchars($ReportData['Age']); ?> years old</td>
              </tr>
              <tr>
                <td class="text-muted">Gender:</td>
                <td>
                  <span class="badge bg-secondary">
                    <?php echo htmlspecialchars($ReportData['Gender']); ?>
                  </span>
                </td>
              </tr>
              <tr>
                <td class="text-muted align-top">Cause of Death:</td>
                <td>
                  <div class="p-3 bg-light rounded-3 text-dark border">
                    <?php echo htmlspecialchars($ReportData['Cause_Of_Death']); ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>



  <?php elseif (isset($_GET['report_id'])): ?>
    <div class="alert alert-warning rounded-3 shadow-sm" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i> Report: <?php echo htmlspecialchars($_GET['report_id']); ?> was not found or you do not have permission to view it.
    </div>
  <?php else: ?>
    <div class="text-center py-5 text-muted bg-white rounded-3 shadow-sm panel">
      <i class="bi bi-search-heart text-primary fs-1 d-block mb-3"></i>
      <h5>Select a report from the dropdown above to view its live status roadmap and details.</h5>
    </div>
  <?php endif; ?>

</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="Citizendashboard.js"></script>

</body>
</html>