<?php
    include '../userData.php';   // gives $userId, $roleId, $username, $role, $email, $gender (from session)
    include 'Citizendashboard.php';

    $user = new User();
    $userRecord = $user->getUserById($userId);

    // getUserById() returns an error array on failure instead of throwing
    if (isset($userRecord['success']) && $userRecord['success'] === false) {
        die("Unable to load profile: " . htmlspecialchars($userRecord['message']));
    }

?>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile - Post-Disaster Reporting System</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link href="../style.css" rel="stylesheet" />
</head>
<body>

<!-- SIDEBAR -->
<nav id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon"><img src="../pictures/Post-Disaster-Reporting-Logo-Notxt.png"></div>
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
  <a class="nav-item" href="CitizenTrackReportForm.php">
    <i class="bi bi-search"></i> Track Report
  </a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" href="CitizendashboardForm.php">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>
  <a class="nav-item active" href="CitizenprofileForm.php">
    <i class="bi bi-person"></i> Profile
  </a>

  <div class="sidebar-footer">
    <a class="nav-item" onclick="confirmLogout()">
      <i class="bi bi-box-arrow-left"></i> Logout
    </a>
  </div>
</nav>

<!-- ══════════════════ TOPBAR ══════════════════ -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Citizen <span class="citizen-accent">Profile</span></div>
    <button class="notif-btn" onclick="showNotifications()" title="Notifications">
        <i class="bi bi-bell"></i>
        <?php if($NotificationCount > 0):?>
        <span class="notif-badge"><?php echo $NotificationCount ?></span>
        <?php endif; ?>
    </button>
    <div class="user-pill" onclick="window.location.href='CitizenProfileForm.php';">
        <div class="user-avatar admin-avatar">
            <?php if (!empty($profilePicFile)): ?>
                <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <i class="bi bi-person-fill"></i>
            <?php endif; ?>
        </div>
        <span class="user-name"><?php echo htmlspecialchars($username) ?></span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
    </div>
</header>

<!-- ══════════════════ MAIN CONTENT ══════════════════ -->
<main id="main">

  <!-- Profile Details Panel -->
  <div class="panel mb-4">
    <div class="panel-header justify-content-center flex-column text-center py-4">

      <form action="Citizenprofile.php" method="POST" enctype="multipart/form-data" id="profilePicForm">

        <?php if(isset($_SESSION['bankMessage']) && $_SESSION['bankMessage'] == false): ?>
        <div class="alert alert-warning d-flex align-items-center" role="alert">
          <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
          <div>
            <strong>Warning!</strong> Please complete your bank details below before submitting a new report.
          </div>
        </div>
        <?php endif;?>

        <div class="profile-avatar-lg mb-3 profile-avatar-wrap">
              <?php if (!empty($profilePicFile)): ?>
                  <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>"
                       alt="Profile Picture" class="profile-avatar-img">
              <?php else: ?>
                  <i class="bi bi-person-fill"></i>
              <?php endif; ?>

              <label for="profilePicInput" class="avatar-edit-btn" title="Update profile picture">
                  <i class="bi bi-camera-fill"></i>
              </label>

              <input type="file"
                     name="profile_picture"
                     id="profilePicInput"
                     accept="image/png, image/jpeg, image/jpg, image/webp"
                     hidden>
        </div>
      </form>

      <div class="panel-title justify-content-center">
        <?php echo htmlspecialchars($userRecord['Full_Name']); ?>
      </div>
      <div class="text-muted small mt-1"><?php echo htmlspecialchars($role); ?></div>
    </div>

    <form id="profile-form" novalidate>
      <input type="hidden" id="userID" name="userID" value="<?php echo htmlspecialchars($userRecord['User_ID']); ?>">

      <div class="row g-3 p-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" id="userName" name="userName"
                 value="<?php echo htmlspecialchars($userRecord['Username']); ?>" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Role</label>
          <input type="text" class="form-control" id="roleID" name="roleID"
                 value="<?php echo htmlspecialchars($role); ?>" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Full Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="fullName" name="fullName"
                 value="<?php echo htmlspecialchars($userRecord['Full_Name']); ?>" required>
          <div class="invalid-feedback">Full name is required.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Gender <span class="text-danger">*</span></label>
          <select class="form-select" id="gender" name="gender" required>
            <option value="" disabled>Select gender</option>
            <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
              <option value="<?php echo $g; ?>" <?php echo ($userRecord['Gender'] === $g) ? 'selected' : ''; ?>>
                <?php echo $g; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please select a gender.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">NIC <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="NIC" name="NIC"
                 value="<?php echo htmlspecialchars($userRecord['NIC']); ?>" required>
          <div class="invalid-feedback">Please enter a valid NIC.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" name="email"
                 value="<?php echo htmlspecialchars($userRecord['Email']); ?>" required>
          <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" id="phoneNo" name="phoneNo"
                 value="<?php echo htmlspecialchars($userRecord['Phone_Number']); ?>" required>
          <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Address <span class="text-danger">*</span></label>
          <textarea class="form-control" id="address" name="address" rows="2" required><?php
              echo htmlspecialchars($userRecord['Address']);
          ?></textarea>
          <div class="invalid-feedback">Address is required.</div>
        </div>
      </div>

      <div class="p-3 pt-0">
        <a class="stat-link" data-bs-toggle="collapse" href="#pwdSection" role="button">
          <i class="bi bi-lock"></i> Change Password
        </a>
        <div class="collapse mt-3" id="pwdSection">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">New Password</label>
              <input type="password" class="form-control" id="newPassword" name="newPassword"
                     placeholder="Leave blank to keep current password" minlength="6">
            </div>
            <div class="col-md-6">
              <label class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                     placeholder="Re-enter new password" minlength="6">
              <div class="invalid-feedback">Passwords do not match.</div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-3 pt-0 d-flex gap-2">
        <button type="submit" class="btn btn-primary rounded-3" id="profile-submit-btn">
          <i class="bi bi-check-circle me-1"></i> Save Changes
        </button>
        <button type="reset" class="btn btn-outline-secondary rounded-3">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
        </button>
      </div>
    </form>
  </div>

  <!-- Bank Details Panel -->
  <div class="panel">
    <div class="panel-header">
      <div class="panel-title">
        <i class="bi bi-bank2 text-primary"></i> Bank Account Information
      </div>
    </div>

    <form id="bank-details-form" class="p-3" action="CitizenBank.php" method="POST">
      <input type="hidden" name="citizenID" value="<?php echo htmlspecialchars($userRecord['User_ID']); ?>">

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Beneficiary Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="accountHolderName" name="accountHolderName"
                 placeholder="e.g. A.B.C. Perera"
                 value="<?php echo htmlspecialchars($bankDetails['Account_Holder_Name'] ?? ''); ?>" required>
          <div class="invalid-feedback">Beneficiary Name is required.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Bank Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="bankName" name="bankName"
                 placeholder="e.g. Bank of Ceylon"
                 value="<?php echo htmlspecialchars($bankDetails['Bank_Name'] ?? ''); ?>" required>
          <div class="invalid-feedback">Bank Name is required.</div>
        </div>

        <div class="col-md-12">
          <label class="form-label">Account Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="accountNumber" name="accountNumber"
                 placeholder="e.g. 1234567890"
                 value="<?php echo htmlspecialchars($bankDetails['Account_Number'] ?? ''); ?>" required>
          <div class="invalid-feedback">Account Number is required.</div>
        </div>
      </div>

      <div class="pt-3 d-flex gap-2">
        <button type="submit" name="submit_bank_details" class="btn btn-primary rounded-3" id="bank-submit-btn">
          <i class="bi bi-credit-card-fill me-1"></i> Save Bank Details
        </button>
        <button type="reset" class="btn btn-outline-secondary rounded-3">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Clear
        </button>
      </div>
    </form>
  </div>

</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="Citizendashboard.js"></script>
<script src="Citizenprofile.js"></script>

</body>
</html>