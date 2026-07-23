<?php
    include '../userData.php'; // provides $con (DB connection), $profilePicFile, session/admin auth
    require '../DBconnection.php';


    // ── Adjust these require paths to match where your class files actually live ──
    require_once '../classes/User.php';
    require_once '../classes/Admin.php';
    require_once '../classes/Citizen.php';
    require_once '../classes/DisasterManagementOfficer.php';
    require_once '../classes/DistrictSecretary.php';
    require_once '../classes/FinancialOfficer.php';
    require_once '../classes/LocalAuthorityOfficer.php';

    // Allowed role types + labels (must match the <option> values sent from addUser() SweetAlert)
    $roleTypes = [
        'citizen' => 'Citizen',
        'admin'   => 'Admin',
        'lao'     => 'Local Authority Officer',
        'dmo'     => 'Disaster Management Officer',
        'ds'      => 'District Secretary',
        'fo'      => 'Financial Officer',
    ];

    $type = $_GET['type'] ?? '';

    if (!array_key_exists($type, $roleTypes)) {
        // Invalid or missing type -> bounce back to dashboard
        header('Location: AdminDashboard.php');
        exit;
    }

    $roleLabel = $roleTypes[$type];

    // For LAO we need the list of divisional secretariats for the dropdown.
    // NOTE: getDivisionalSecretariats($con) is a method you still need to add to
    // LocalAuthorityOfficer (see snippet provided separately). It should return
    // an array of rows like ['DS_ID' => ..., 'District' => ..., 'DS_Name' => ...]
    $divisionalSecretariats = [];
    if ($type === 'lao') {
        $localOfficer = new LocalAuthorityOfficer();
        if (method_exists($localOfficer, 'getDivisionalSecretariats')) {
            $divisionalSecretariats = $localOfficer->getDivisionalSecretariats($con);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add New User - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="../style.css" rel="stylesheet" />
</head>
<body>

<!-- ══════════════════ SIDEBAR ══════════════════ -->
<nav id="sidebar" class="sidebar-admin">
    <div class="sidebar-brand">
        <div class="brand-icon admin"><i class="bi bi-shield-lock-fill"></i></div>
        <div>
            <div class="brand-title">Post-Disaster</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="nav-section-label">Overview</div>
    <a class="nav-item" href="AdminDashboardForm.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">User Management</div>
    <a class="nav-item" href="AllUsersForm.php">
        <i class="bi bi-person"></i> All Users
    </a>
    <a class="nav-item active admin-active" href="#" onclick="addUser()">
        <i class="bi bi-person-plus"></i> Add New User
    </a>

    <div class="nav-section-label">System</div>
    <a class="nav-item" href="#" onclick="showInfo('Reports Overview')">
        <i class="bi bi-file-earmark-bar-graph"></i> Reports Overview
    </a>
    <a class="nav-item" href="#" onclick="showInfo('System Logs')">
        <i class="bi bi-journal-text"></i> System Logs
    </a>
    <a class="nav-item" href="#" onclick="showInfo('Settings')">
        <i class="bi bi-gear"></i> Settings
    </a>

    <div class="nav-section-label">Account</div>
    <a class="nav-item" href="#" onclick="showInfo('Notifications')">
        <i class="bi bi-bell"></i> Notifications
    </a>

    <a class="nav-item" href="AdminprofileForm.php">
        <i class="bi bi-person"></i> Profile
    </a>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</nav>

<!-- ══════════════════ TOPBAR ══════════════════ -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Add New <span class="admin-accent">User</span></div>
    <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i>
        <span class="notif-badge">5</span>
    </button>
    <div class="user-pill" onclick="window.location.href='AdminProfileForm.php';">
        <div class="user-avatar admin-avatar">
            <?php if (!empty($profilePicFile)): ?>
                <img src="../uploads/Profile_Pic/<?php echo htmlspecialchars($profilePicFile); ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <i class="bi bi-person-fill"></i>
            <?php endif; ?>
        </div>
        <span class="user-name">Admin</span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
    </div>
</header>

<!-- ══════════════════ MAIN CONTENT ══════════════════ -->
<main id="main">
    <div class="page-header">
        <h4>Add New User <span class="text-muted">— <?php echo htmlspecialchars($roleLabel); ?></span></h4>
    </div>

    <form id="addUserForm" method="post" action="AdminAddUser.php" novalidate>
        <input type="hidden" name="userType" value="<?php echo htmlspecialchars($type); ?>" />

        <!-- ── Common User Information ── -->
        <div class="card form-card mb-4">
            <div class="card-header">Common User Information</div>
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required minlength="8">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullName" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIC</label>
                    <input type="text" class="form-control" name="nic" required placeholder="200012345678 or 991234567V">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" required placeholder="07XXXXXXXX">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="Active">Active</option>
                        <option value="Banned">Banned</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" name="address" rows="2" required></textarea>
                </div>

            </div>
        </div>

        <!-- ── Role Specific Information ── -->
        <div class="card form-card mb-4">
            <div class="card-header">Role Specific Information — <?php echo htmlspecialchars($roleLabel); ?></div>
            <div class="card-body row g-3">

                <?php if ($type === 'citizen'): ?>
                    <!-- NOTE: these 3 fields are NOT currently persisted -
                         Citizen::addCitizen() only inserts User_ID.
                         Update the citizen table + class method to store these. -->
                    <div class="col-md-4">
                        <label class="form-label">Beneficiary Name</label>
                        <input type="text" class="form-control" name="beneficiaryName">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Beneficiary Bank</label>
                        <input type="text" class="form-control" name="beneficiaryBank">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="accountNumber">
                    </div>

                <?php elseif ($type === 'admin'): ?>
                    <div class="col-md-6">
                        <label class="form-label">Admin Role</label>
                        <input type="text" class="form-control" name="adminRole" required>
                    </div>

                <?php elseif ($type === 'lao'): ?>
                    <div class="col-md-4">
                        <label class="form-label">Local Officer ID</label>
                        <input type="text" class="form-control" name="localOfficerID" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" name="position" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Assigned Divisional Secretariat</label>
                        <select class="form-select" name="assignedDivisionalSecretariat" required>
                            <option value="">Select Divisional Secretariat</option>
                            <?php foreach ($divisionalSecretariats as $ds): ?>
                                <option value="<?php echo htmlspecialchars($ds['DS_ID']); ?>">
                                    <?php echo htmlspecialchars($ds['DS_Name'] . ' — ' . $ds['District']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php elseif ($type === 'dmo'): ?>
                    <div class="col-md-4">
                        <label class="form-label">Management Officer ID</label>
                        <input type="text" class="form-control" name="managementOfficerID" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control" name="department" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Region Assigned</label>
                        <input type="text" class="form-control" name="regionAssigned" required>
                    </div>

                <?php elseif ($type === 'ds'): ?>
                    <div class="col-md-4">
                        <label class="form-label">Secretary Officer ID</label>
                        <input type="text" class="form-control" name="secretaryOfficerID" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Office Name</label>
                        <input type="text" class="form-control" name="officeName" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Office Location</label>
                        <input type="text" class="form-control" name="officeLocation" required>
                    </div>

                <?php elseif ($type === 'fo'): ?>
                    <div class="col-md-3">
                        <label class="form-label">Financial Officer ID</label>
                        <input type="text" class="form-control" name="financialOfficerID" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control" name="department" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" class="form-control" name="bankName" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bank Account Number</label>
                        <input type="text" class="form-control" name="bankAccountNo" required>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <label class="mb-1 fw-bold" id="errorMessage" style="color:red"></label>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary" id="saveUserBtn">
                <i class="bi bi-save"></i> Save User
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='AllUsersForm.php';">
                Cancel
            </button>
        </div>
    </form>

    <footer>&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/dashboard.js"></script>
<script src="../js/AdminAddUser.js"></script>

<?php if(isset($_SESSION['message'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['icon'] ?? "error"; ?>',
        title: '<?php echo $_SESSION['message']; ?>',
        confirmButtonColor: '#2563eb'
    });
</script>
<?php
unset($_SESSION['message']);
unset($_SESSION['icon']);
endif;
?>
</body>
</html>
