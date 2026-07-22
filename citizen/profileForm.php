<?php
    include '../userData.php';   // gives $userId, $roleId, $username, $role, $email, $gender (from session)
    include '../classes/User.php';

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

  <!-- one level up since this page lives inside /Profile -->
  <link href="../style.css" rel="stylesheet" />
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">

  <div class="sidebar-brand">
    <div class="brand-icon"><img src="../pictures/Post-Disaster-Reporting-Logo-Notxt.png"></div>
    <div>
      <div class="brand-title">Post-Disaster</div>
      <div class="brand-sub">Reporting System</div>
    </div>
  </div>

  <div class="nav-section-label">Reports</div>
  <a class="nav-item" href="../dashboardForm.php">
    <i class="bi bi-file-earmark-plus"></i> Submit New Report
  </a>
  <a class="nav-item" href="../dashboardForm.php">
    <i class="bi bi-file-earmark-text"></i> My Reports
  </a>
  <a class="nav-item" href="../dashboardForm.php">
    <i class="bi bi-search"></i> Track Report
  </a>

  <div class="nav-section-label">Notifications</div>
  <a class="nav-item" href="../dashboardForm.php">
    <i class="bi bi-bell"></i> Notifications
  </a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" href="../dashboardForm.php">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>
  <a class="nav-item active" href="profileForm.php">
    <i class="bi bi-person"></i> Profile
  </a>
  <a class="nav-item" href="../dashboardForm.php">
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
    My <span>Profile</span>
  </div>

  <div class="user-pill" href="profileForm.php">
    <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
    <span class="user-name"><?php echo htmlspecialchars($username); ?></span>
  </div>
</header>

<!-- Main content -->
<main id="main">

<div class="panel">
    <div class="panel-header justify-content-center flex-column text-center py-4">
      <div class="profile-avatar-lg mb-3">
        <i class="bi bi-person-fill"></i>
      </div>
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

</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<!-- reuse dashboard.js for toggleSidebar()/confirmLogout(), one level up -->
<script src="../dashboard.js"></script>

<script src="profile.js"></script>

</body>
</html>
