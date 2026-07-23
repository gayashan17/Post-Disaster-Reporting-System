<?php
    include '../userData.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>All Users - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="../style.css" rel="stylesheet" />
    <style>
        /* Fallback in case badge-banned isn't defined in style.css yet */
        .badge-banned{
            background:#fde8e8; color:#c81e1e; font-weight:600; font-size:11px;
            padding:4px 10px; border-radius:20px; display:inline-block;
        }
        .filter-bar{ gap:10px; flex-wrap:wrap; }
        .filter-bar select, .filter-bar input{
            border-radius:10px; border:1px solid var(--border, #e5e7eb);
            font-size:13px; padding:8px 12px;
        }
        .search-wrap{ position:relative; max-width:320px; flex:1 1 260px; }
        .search-wrap i{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9aa1ab; }
        .search-wrap input{ padding-left:34px; width:100%; }
        .pagination-wrap{ display:flex; align-items:center; justify-content:space-between; padding:14px 4px 4px; flex-wrap:wrap; gap:10px; }
        .page-btn{
            border:1px solid var(--border, #e5e7eb); background:#fff; color:#333;
            width:32px; height:32px; border-radius:8px; font-size:13px; font-weight:600;
            display:inline-flex; align-items:center; justify-content:center;
        }
        .page-btn.active{ background:var(--admin, #b91c1c); color:#fff; border-color:var(--admin, #b91c1c); }
        .page-btn:disabled{ opacity:.4; }
        .no-results{ text-align:center; padding:40px 0; color:#9aa1ab; font-size:14px; }
    </style>
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
    <a class="nav-item active admin-active" href="AllUsersForm.php">
        <i class="bi bi-people"></i> All Users
    </a>
    <a class="nav-item" href="#" onclick="addUser()">
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
    <div class="topbar-title">All <span class="admin-accent">Users</span></div>
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

<!-- ══════════════════ MAIN ══════════════════ -->
<main id="main">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-700 mb-0">All Users</h5>
            <div class="text-muted" style="font-size:13px">Manage every registered user in the system</div>
        </div>
        <button class="btn admin-btn-primary rounded-3 px-4" onclick="addUser()">
            <i class="bi bi-person-plus me-2"></i>Add New User
        </button>
    </div>

    <div class="panel">

        <!-- Search + Filters -->
        <div class="d-flex align-items-center filter-bar mb-3">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="search-input" placeholder="Search users by name or email...">
            </div>

            <select id="status-filter">
                <option value="">Status: All</option>
                <option value="Active">Active</option>
                <option value="Banned">Banned</option>
            </select>

            <select id="role-filter">
                <option value="">User Type: All</option>
                <option value="Admin">Admin</option>
                <option value="Citizen">Citizen</option>
                <option value="Local Authority Officer">Local Authority Officer</option>
                <option value="Disaster Management Officer">Disaster Management Officer</option>
                <option value="District Secretary">District Secretary</option>
                <option value="Financial Officer">Financial Officer</option>
            </select>

            <button class="btn btn-outline-secondary rounded-3" id="clear-filters" style="font-size:13px">
                <i class="bi bi-x-circle me-1"></i>Clear
            </button>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="users-table" class="table table-borderless" style="width:100%">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>NIC</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="no-results d-none" id="no-results">No users match your filters.</div>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrap">
            <div class="text-muted" id="results-count" style="font-size:12px"></div>
            <div class="d-flex align-items-center gap-1" id="pagination"></div>
        </div>

    </div>

    <!-- ── ADD USER MODAL ── -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px;border:none">
                <div class="modal-header" style="border-bottom:1px solid var(--border);padding:20px 24px">
                    <h5 class="modal-title fw-700"><i class="bi bi-person-plus me-2" style="color:var(--admin)"></i>Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:24px">
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px">Full Name</label>
                        <input type="text" id="new-name" class="form-control admin-input" placeholder="Enter full name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px">Email Address</label>
                        <input type="email" id="new-email" class="form-control admin-input" placeholder="Enter email address" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px">Phone Number</label>
                        <input type="text" id="new-phone" class="form-control admin-input" placeholder="Enter phone number" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px">Role</label>
                        <select id="new-role" class="form-select admin-input">
                            <option value="">Select role...</option>
                            <option>Citizen</option>
                            <option>Local Authority Officer</option>
                            <option>Disaster Management Officer</option>
                            <option>Financial Officer</option>
                            <option>District Secretary</option>
                            <option>Admin</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-600" style="font-size:13px">Temporary Password</label>
                        <input type="password" id="new-password" class="form-control admin-input" placeholder="Set a temporary password" />
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);padding:16px 24px;gap:8px">
                    <button class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn admin-btn-primary rounded-3 px-4" onclick="submitNewUser()">
                        <i class="bi bi-person-check me-1"></i> Create User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer>&copy; 2024 Post-Disaster Reporting and Compensation Management System. All rights reserved.</footer>
</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script src="AdminDashboard.js"></script>
<script src="AllUsers.js"></script>

</body>
</html>
