<?php
    include '../userData.php';   // gives $userId, $roleId, $username, $role, $email, $gender
    include 'LAOdashboard.php';  // LAO context, notification metrics, database setup

    $user = new User();
    $userRecord = $user->getUserById($userId);

    // getUserById() returns an error array on failure instead of throwing
    if (isset($userRecord['success']) && $userRecord['success'] === false) {
        die("Unable to load profile: " . htmlspecialchars($userRecord['message']));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile - Local Authority Officer</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link href="../style.css" rel="stylesheet" />
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
  <a class="nav-item" href="LAOPendingReportsForm.php"><i class="bi bi-clock-history"></i> Pending Reports</a>
  <a class="nav-item" href="LAOVerifiedReportsForm.php"><i class="bi bi-check-square"></i> Verified Reports</a>
  <a class="nav-item" href="LAORejectedReportsForm.php"><i class="bi bi-x-square"></i> Rejected Reports</a>
  <a class="nav-item" href="LAOAllReportsForm.php"><i class="bi bi-file-earmark-text"></i> All Reports</a>

  <div class="nav-section-label">Account</div>
  <a class="nav-item" href="LAOdashboardForm.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a class="nav-item active" href="LAOprofileForm.php"><i class="bi bi-person"></i> Profile</a>

  <div class="sidebar-footer">
    <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
  </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
  <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <div class="topbar-title">Local Authority Officer <span>Profile</span></div>
  <button class="notif-btn" onclick="showNotifications()" title="Notifications">
    <i class="bi bi-bell"></i>
    <?php if(!empty($NotificationCount) && $NotificationCount > 0): ?>
      <span class="notif-badge"><?php echo $NotificationCount; ?></span>
    <?php endif; ?>
  </button>
  <div class="user-pill" onclick="window.location.href='LAOprofileForm.php';">
    <div class="user-avatar">
      <?php if (!empty($profilePicFile) && $profilePicFile !== 'default.png'): ?>
        <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>" alt="Avatar" class="rounded-circle" width="30" height="30">
      <?php else: ?>
        <i class="bi bi-person-fill"></i>
      <?php endif; ?>
    </div>
    <span class="user-name"><?php echo htmlspecialchars($username ?? '');?></span>
    <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
  </div>
</header>

<!-- MAIN CONTENT -->
<main id="main">

  <!-- Profile Details Panel -->
  <div class="panel mb-4">
    <div class="panel-header justify-content-center flex-column text-center py-4">

      <form action="LAOprofile.php" method="POST" enctype="multipart/form-data" id="profilePicForm">
        <div class="profile-avatar-lg mb-3 profile-avatar-wrap">
              <?php if (!empty($profilePicFile) && $profilePicFile !== 'default.png'): ?>
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

      <div class="panel-title justify-content-center fs-4 fw-bold">
        <?php echo htmlspecialchars($userRecord['Full_Name'] ?? $username); ?>
      </div>
      <div>
        <span class="role-tagLAO mt-2 d-inline-block">Local Authority Officer</span>
      </div>
    </div>

    <form id="profile-form" novalidate>
      <input type="hidden" id="userID" name="userID" value="<?php echo htmlspecialchars($userRecord['User_ID'] ?? $userId); ?>">

      <div class="row g-3 p-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" id="userName" name="userName"
                 value="<?php echo htmlspecialchars($userRecord['Username'] ?? $username); ?>" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Role</label>
          <input type="text" class="form-control" id="roleID" name="roleID"
                 value="Local Authority Officer" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Full Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="fullName" name="fullName"
                 value="<?php echo htmlspecialchars($userRecord['Full_Name'] ?? ''); ?>" required>
          <div class="invalid-feedback">Full name is required.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Gender <span class="text-danger">*</span></label>
          <select class="form-select" id="gender" name="gender" required>
            <option value="" disabled>Select gender</option>
            <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
              <option value="<?php echo $g; ?>" <?php echo (($userRecord['Gender'] ?? '') === $g) ? 'selected' : ''; ?>>
                <?php echo $g; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please select a gender.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">NIC <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="NIC" name="NIC"
                 value="<?php echo htmlspecialchars($userRecord['NIC'] ?? ''); ?>" required>
          <div class="invalid-feedback">Please enter a valid NIC.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" name="email"
                 value="<?php echo htmlspecialchars($userRecord['Email'] ?? ''); ?>" required>
          <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" id="phoneNo" name="phoneNo"
                 value="<?php echo htmlspecialchars($userRecord['Phone_Number'] ?? ''); ?>" required>
          <div class="invalid-feedback">Please enter a valid phone number.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Address <span class="text-danger">*</span></label>
          <textarea class="form-control" id="address" name="address" rows="2" required><?php
              echo htmlspecialchars($userRecord['Address'] ?? '');
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

  <footer class="mt-4">&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

<script src="LAOdashboard.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Auto submit profile picture upload on file selection
    const profilePicInput = document.getElementById('profilePicInput');
    if (profilePicInput) {
        profilePicInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('profilePicForm').submit();
            }
        });
    }

    // 2. Profile Pic URL Parameter Notifications
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pic') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Profile Picture Updated',
            text: 'Your profile image has been updated successfully.',
            timer: 2000,
            showConfirmButton: false
        });
    } else if (urlParams.get('pic') === 'error') {
        Swal.fire({
            icon: 'error',
            title: 'Upload Failed',
            text: urlParams.get('msg') || 'Failed to update profile picture.'
        });
    }

    // 3. Handle Profile Details Form AJAX Submission
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const newPwd = document.getElementById('newPassword').value;
            const confirmPwd = document.getElementById('confirmPassword').value;

            if (newPwd !== confirmPwd) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'New password and confirm password fields do not match.'
                });
                return;
            }

            const payload = {
                fullName: document.getElementById('fullName').value,
                gender: document.getElementById('gender').value,
                NIC: document.getElementById('NIC').value,
                email: document.getElementById('email').value,
                phoneNo: document.getElementById('phoneNo').value,
                address: document.getElementById('address').value,
                newPassword: newPwd,
                confirmPassword: confirmPwd
            };

            fetch('LAOprofile.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred while saving profile changes.'
                });
            });
        });
    }
});
</script>

</body>
</html>