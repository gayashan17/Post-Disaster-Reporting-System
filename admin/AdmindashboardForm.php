<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
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
    <a class="nav-item active admin-active" href="#" onclick="showSection('dashboard')">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section-label">User Management</div>
    <a class="nav-item" href="#" onclick="showSection('users')">
        <i class="bi bi-people"></i> All Users
    </a>
    <a class="nav-item" href="#" onclick="addUser()">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
    <a class="nav-item" href="#" onclick="showSection('banned')">
        <i class="bi bi-slash-circle"></i> Banned Users
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
    <a class="nav-item" href="#" onclick="showInfo('Profile')">
        <i class="bi bi-person"></i> Profile
    </a>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</nav>

<!-- ══════════════════ TOPBAR ══════════════════ -->
<header id="topbar">
    <button id="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Admin <span class="admin-accent">Dashboard</span></div>
    <button class="notif-btn" onclick="showNotifAlert()" title="Notifications">
        <i class="bi bi-bell"></i>
        <span class="notif-badge">5</span>
    </button>
    <div class="user-pill" onclick="showInfo('Profile')">
        <div class="user-avatar admin-avatar"><i class="bi bi-person-fill"></i></div>
        <span class="user-name">Super Admin</span>
        <i class="bi bi-chevron-down text-muted" style="font-size:11px"></i>
    </div>
</header>

<!-- ══════════════════ MAIN ══════════════════ -->
<main id="main">

    <!-- ── SECTION: DASHBOARD ── -->
    <div id="section-dashboard">

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon admin-icon-red"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value" id="stat-users">0</div>
                        <a class="stat-link admin-link" onclick="showSection('users')">Manage Users &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-person-check-fill"></i></div>
                    <div>
                        <div class="stat-label">Active Users</div>
                        <div class="stat-value" id="stat-active">0</div>
                        <a class="stat-link admin-link" onclick="showSection('users')">View Active &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Reports</div>
                        <div class="stat-value" id="stat-reports">0</div>
                        <a class="stat-link admin-link" onclick="showInfo('Reports Overview')">View Reports &rsaquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon admin-icon-ban"><i class="bi bi-slash-circle-fill"></i></div>
                    <div>
                        <div class="stat-label">Banned Users</div>
                        <div class="stat-value" id="stat-banned">0</div>
                        <a class="stat-link admin-link" onclick="showSection('banned')">View Banned &rsaquo;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">

            <!-- User Role Breakdown Chart -->
            <div class="col-lg-5">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-pie-chart-fill"></i> Users by Role</div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="role-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Report Activity Chart -->
            <div class="col-lg-7">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Monthly Report Activity</div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="activity-chart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-4">

            <!-- Recent User Registrations -->
            <div class="col-lg-8">
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-person-lines-fill"></i> Recent Registrations</div>
                        <button class="btn btn-sm admin-btn-primary rounded-3" onclick="openAddUserModal()">
                            <i class="bi bi-person-plus me-1"></i> Add User
                        </button>
                    </div>
                    <div class="d-flex flex-column gap-2">

                    <div id="recent-registrations" class="d-flex flex-column gap-2">
                    </div>

                    </div>
                </div>
            </div>

            <!-- System Notifications -->
            <div class="col-lg-4">
                <div class="panel h-100">
                    <div class="panel-header">
                        <div class="panel-title"><i class="bi bi-bell"></i> System Alerts</div>
                        <a class="stat-link admin-link" onclick="showInfo('All Alerts')">View All</a>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon admin-icon-notif-red"><i class="bi bi-slash-circle-fill"></i></div>
                        <div class="notif-text">User <strong>R. Jayasuriya</strong> was banned for policy violation.</div>
                        <div class="notif-time">1h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon green"><i class="bi bi-person-check-fill"></i></div>
                        <div class="notif-text">New user <strong>Dilini Perera</strong> registered successfully.</div>
                        <div class="notif-time">3h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon amber"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="notif-text">5 reports are pending verification for over 48 hours.</div>
                        <div class="notif-time">5h ago</div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-icon blue"><i class="bi bi-info-circle-fill"></i></div>
                        <div class="notif-text">System backup completed successfully.</div>
                        <div class="notif-time">1d ago</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ── SECTION: ALL USERS ── -->
    <div id="section-users" class="d-none">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="fw-700 mb-0">User Management</h5>
                <div class="text-muted" style="font-size:13px">Add, edit, or ban system users</div>
            </div>
            <button class="btn admin-btn-primary rounded-3 px-4" onclick="openAddUserModal()">
                <i class="bi bi-person-plus me-2"></i>Add New User
            </button>
        </div>

        <!-- Role filter tabs -->
        <div class="role-tabs mb-3">
            <button class="role-tab active" onclick="filterRole(this, 'all')">All</button>
            <button class="role-tab" onclick="filterRole(this, 'Citizen')">Citizens</button>
            <button class="role-tab" onclick="filterRole(this, 'Local Authority Officer')">Local Authority</button>
            <button class="role-tab" onclick="filterRole(this, 'DMO Officer')">DMO</button>
            <button class="role-tab" onclick="filterRole(this, 'Financial Officer')">Financial</button>
        </div>

        <div class="panel">
            <div class="table-responsive">
                <table id="users-table" class="table table-borderless" style="width:100%">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Location</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr data-role="Citizen">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar blue-av">D</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Dilini Perera</div>
                                    <div style="font-size:11px;color:var(--muted)">dilini@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill citizen">Citizen</span></td>
                        <td>Colombo</td>
                        <td>2024-05-20</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Dilini Perera')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Dilini Perera')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="Citizen">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar amber-av">R</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Ruwan Gunawardena</div>
                                    <div style="font-size:11px;color:var(--muted)">ruwan@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill citizen">Citizen</span></td>
                        <td>Kandy</td>
                        <td>2024-05-19</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Ruwan Gunawardena')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Ruwan Gunawardena')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="Local Authority Officer">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar green-av">N</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Nimal Fernando</div>
                                    <div style="font-size:11px;color:var(--muted)">nimal.f@gov.lk</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill la">Local Authority Officer</span></td>
                        <td>Kandy</td>
                        <td>2024-05-18</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Nimal Fernando')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Nimal Fernando')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="DMO Officer">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar purple-av">K</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Kamala Silva</div>
                                    <div style="font-size:11px;color:var(--muted)">kamala.s@gov.lk</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill dmo">DMO Officer</span></td>
                        <td>Galle</td>
                        <td>2024-05-15</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Kamala Silva')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Kamala Silva')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="Financial Officer">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar rose-av">S</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Sunil Bandara</div>
                                    <div style="font-size:11px;color:var(--muted)">sunil.b@gov.lk</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill fin">Financial Officer</span></td>
                        <td>Matara</td>
                        <td>2024-05-12</td>
                        <td><span class="badge-status badge-pending">Pending</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Sunil Bandara')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Sunil Bandara')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="Citizen">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar purple-av">P</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Priya Wickrama</div>
                                    <div style="font-size:11px;color:var(--muted)">priya.w@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill citizen">Citizen</span></td>
                        <td>Ratnapura</td>
                        <td>2024-05-10</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Priya Wickrama')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Priya Wickrama')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr data-role="Local Authority Officer">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar amber-av">A</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">Asanka Rathnayake</div>
                                    <div style="font-size:11px;color:var(--muted)">asanka.r@gov.lk</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill la">Local Authority Officer</span></td>
                        <td>Nuwara Eliya</td>
                        <td>2024-05-08</td>
                        <td><span class="badge-status badge-approved">Active</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn blue" onclick="editUser('Asanka Rathnayake')" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="icon-btn red" onclick="banUser('Asanka Rathnayake')" title="Ban"><i class="bi bi-slash-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ── SECTION: BANNED USERS ── -->
    <div id="section-banned" class="d-none">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="fw-700 mb-0">Banned Users</h5>
                <div class="text-muted" style="font-size:13px">Users who have been suspended from the system</div>
            </div>
        </div>

        <div class="panel">
            <div class="table-responsive">
                <table id="banned-table" class="table table-borderless" style="width:100%">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Banned On</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar rose-av">R</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">R. Jayasuriya</div>
                                    <div style="font-size:11px;color:var(--muted)">r.jaya@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill citizen">Citizen</span></td>
                        <td>2024-05-21</td>
                        <td>Policy violation</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn green" onclick="unbanUser('R. Jayasuriya')" title="Unban"><i class="bi bi-check-circle"></i></button>
                                <button class="icon-btn red" onclick="deleteUser('R. Jayasuriya')" title="Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="table-avatar amber-av">M</div>
                                <div>
                                    <div class="fw-600" style="font-size:13px">M. Perera</div>
                                    <div style="font-size:11px;color:var(--muted)">m.perera@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-pill citizen">Citizen</span></td>
                        <td>2024-05-19</td>
                        <td>Fraudulent report submission</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="icon-btn green" onclick="unbanUser('M. Perera')" title="Unban"><i class="bi bi-check-circle"></i></button>
                                <button class="icon-btn red" onclick="deleteUser('M. Perera')" title="Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
                        <label class="form-label fw-600" style="font-size:13px">Role</label>
                        <select id="new-role" class="form-select admin-input">
                            <option value="">Select role...</option>
                            <option>Citizen</option>
                            <option>Local Authority Officer</option>
                            <option>DMO Officer</option>
                            <option>Financial Officer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px">Location</label>
                        <input type="text" id="new-location" class="form-control admin-input" placeholder="Enter district / city" />
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script src="AdminDashboard.js"></script>

</body>
</html>