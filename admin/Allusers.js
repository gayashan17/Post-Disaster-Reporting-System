/* ==========================================================================
   AllUsers.js
   Handles: search, status/role filtering, and client-side pagination
   for the #users-table on AllUsersForm.php.

   NOTE: Actions like viewUser(), editUser(), banUser(), unbanUser(),
   deleteUser(), openAddUserModal(), submitNewUser() are expected to
   already exist in AdminDashboard.js (shared across admin pages).
   Only viewUser() is added below as a fallback in case it isn't defined yet.
   ========================================================================== */

const ROWS_PER_PAGE = 5;
let currentPage = 1;
let allUsers = [];

function avatarClass(i) {
    const classes = ['blue-av', 'amber-av', 'green-av', 'purple-av', 'rose-av'];
    return classes[i % classes.length];
}

function rolePillClass(role) {
    switch (role) {
        case 'Admin':
            return 'admin';
        case 'Citizen':
            return 'citizen';
        case 'Local Authority Officer':
            return 'la';
        case 'Disaster Management Officer':
            return 'dmo';
        case 'District Secretary':
            return 'ds';
        case 'Financial Officer':
            return 'fin';
        default:
            return 'citizen';
    }
}

function statusBadgeClass(status) {
    switch (status) {
        case 'Active':
            return 'badge-approved';
        case 'Banned':
            return 'badge-banned';
        default:
            return 'badge-pending';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadUsers();

    document.getElementById('search-input').addEventListener('input', () => {
        currentPage = 1;
        applyFilters();
    });
    document.getElementById('status-filter').addEventListener('change', () => {
        currentPage = 1;
        applyFilters();
    });
    document.getElementById('role-filter').addEventListener('change', () => {
        currentPage = 1;
        applyFilters();
    });
    document.getElementById('clear-filters').addEventListener('click', () => {
        document.getElementById('search-input').value = '';
        document.getElementById('status-filter').value = '';
        document.getElementById('role-filter').value = '';
        currentPage = 1;
        applyFilters();
    });
});


async function loadUsers() {
    try {
        const response = await fetch('AllUser.php');

        const text = await response.text();

        console.log('Backend response:', text);

        const data = JSON.parse(text);

        if (!data.success) {
            throw new Error(data.message || 'Failed to load users.');
        }

        allUsers = data.users;

        const tbody = document.querySelector('#users-table tbody');

        tbody.innerHTML = '';

        allUsers.forEach((user, index) => {

            const row = document.createElement('tr');

            row.dataset.name = (user.Full_Name || '').toLowerCase();
            row.dataset.email = (user.Email || '').toLowerCase();
            row.dataset.role = user.Role_Name || '';
            row.dataset.status = user.User_Status || '';

            row.innerHTML = `
            
                <td style="font-size:13px;color:var(--muted)">
                    ${user.User_ID}
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="table-avatar ${avatarClass(index)}">
                            ${(user.Full_Name || 'U').charAt(0).toUpperCase()}
                        </div>
                        <div class="fw-600" style="font-size:13px">
                            ${user.Full_Name || ''}
                        </div>
                    </div>
                </td>

                <td style="font-size:13px;color:var(--muted)">
                    ${user.NIC || ''}
                </td>

                <td style="font-size:13px;color:var(--muted)">
                    ${user.Email || ''}
                </td>

                <td style="font-size:13px;color:var(--muted)">
                    ${user.Phone_Number || ''}
                </td>

                <td>
                    <span class="role-pill ${rolePillClass(user.Role_Name)}">
                        ${user.Role_Name || ''}
                    </span>

                <td>
                    <span class="badge-status ${statusBadgeClass(user.User_Status)}">
                        ${user.User_Status || ''}
                    </span>
                </td>


                <td>
                    <div class="d-flex gap-1">
                        <button class="icon-btn blue"
                                onclick="viewUser(${user.User_ID})"
                                title="View">
                            <i class="bi bi-eye"></i>
                        </button>

                        <button class="icon-btn blue"
                                onclick="editUser(${user.User_ID})"
                                title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>

                        ${user.User_Status === 'Banned'
                            ? `
                            <button class="icon-btn green"
                                    onclick="unbanUser(${user.User_ID})"
                                    title="Unban">
                                <i class="bi bi-check-circle"></i>
                            </button>
                            `
                            : `
                            <button class="icon-btn red"
                                    onclick="banUser(${user.User_ID})"
                                    title="Ban">
                                <i class="bi bi-slash-circle"></i>
                            </button>
                            `
                        }
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });

        // Now apply search, filter and pagination
        applyFilters();

    } catch (error) {
        console.error('Error loading users:', error);

        Swal.fire({
            title: 'Error',
            text: error.message,
            icon: 'error'
        });
    }
}


function getFilteredRows() {
    const search = document.getElementById('search-input').value.trim().toLowerCase();
    const status = document.getElementById('status-filter').value;
    const role = document.getElementById('role-filter').value;

    const rows = Array.from(document.querySelectorAll('#users-table tbody tr'));

    return rows.filter(row => {
        const name = row.dataset.name || '';
        const email = row.dataset.email || '';
        const rowRole = row.dataset.role || '';
        const rowStatus = row.dataset.status || '';

        const matchesSearch = !search || name.includes(search) || email.includes(search);
        const matchesStatus = !status || rowStatus === status;
        const matchesRole = !role || rowRole === role;

        return matchesSearch && matchesStatus && matchesRole;
    });
}

function applyFilters() {
    const allRows = Array.from(document.querySelectorAll('#users-table tbody tr'));
    const filtered = getFilteredRows();

    allRows.forEach(row => row.style.display = 'none');

    const totalPages = Math.max(1, Math.ceil(filtered.length / ROWS_PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const pageRows = filtered.slice(start, start + ROWS_PER_PAGE);
    pageRows.forEach(row => row.style.display = '');

    document.getElementById('no-results').classList.toggle('d-none', filtered.length > 0);

    const countEl = document.getElementById('results-count');
    if (filtered.length === 0) {
        countEl.textContent = '';
    } else {
        countEl.textContent = `Showing ${start + 1}-${Math.min(start + ROWS_PER_PAGE, filtered.length)} of ${filtered.length} users`;
    }

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const wrap = document.getElementById('pagination');
    wrap.innerHTML = '';

    if (totalPages <= 1) return;

    const prev = document.createElement('button');
    prev.className = 'page-btn';
    prev.innerHTML = '<i class="bi bi-chevron-left"></i>';
    prev.disabled = currentPage === 1;
    prev.onclick = () => { currentPage--; applyFilters(); };
    wrap.appendChild(prev);

    for (let p = 1; p <= totalPages; p++) {
        const btn = document.createElement('button');
        btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
        btn.textContent = p;
        btn.onclick = () => { currentPage = p; applyFilters(); };
        wrap.appendChild(btn);
    }

    const next = document.createElement('button');
    next.className = 'page-btn';
    next.innerHTML = '<i class="bi bi-chevron-right"></i>';
    next.disabled = currentPage === totalPages;
    next.onclick = () => { currentPage++; applyFilters(); };
    wrap.appendChild(next);
}

/* Fallback so the button doesn't error if AdminDashboard.js hasn't defined this yet */
if (typeof viewUser !== 'function') {
    function viewUser(name) {
        Swal.fire({
            title: name,
            text: 'Full user profile view coming soon.',
            icon: 'info'
        });
    }
}

///// ban/unban user
function banUser(userId) {
    Swal.fire({
        title: 'Ban User?',
        text: 'Are you sure you want to ban this user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            fetch('AllUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=updateStatus&user_id=${userId}&status=Banned`
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'User Banned',
                        text: 'The user has been banned successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Refresh table
                    loadUsers();

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });

                }

            })
            .catch(error => {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong.'
                });

                console.error(error);

            });

        }
    });
}

function unbanUser(userId) {
    Swal.fire({
        title: 'Unban User?',
        text: 'Are you sure you want to activate this user again?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            fetch('AllUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=updateStatus&user_id=${userId}&status=Active`
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'User Activated',
                        text: 'The user has been activated successfully.'
                    }).then(() => {
                        loadUsers();
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });

                }

            })
            .catch(error => {

                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong.'
                });

            });

        }

    });
}

///////////// View userdata

function viewUser(userId) {

    fetch('AllUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=viewUser&user_id=${userId}`
    })
    .then(response => response.json())
    .then(data => {

        if (!data.success) {
            Swal.fire('Error', data.message, 'error');
            return;
        }

        const u = data.user;

        const photo = u.Profile_Pic
            ? `../uploads/Profile_Pic/${u.Profile_Pic}`
            : '../images/default-user.png';

        // Status badge color
        const statusColors = {
            'Active': '#16a34a',
            'Inactive': '#dc2626',
            'Pending': '#d97706'
        };
        const statusColor = statusColors[u.User_Status] || '#6b7280';

        Swal.fire({
            title: '',
            width: 650,
            padding: '2rem',
            confirmButtonText: 'Close',
            confirmButtonColor: '#3085d6',
            html: `
                <div class="text-center">

                    <img src="${photo}" 
                         alt="Profile Picture"
                         style="
                            width:110px;
                            height:110px;
                            border-radius:50%;
                            object-fit:cover;
                            border:4px solid #e5e7eb;
                            box-shadow:0 2px 8px rgba(0,0,0,0.1);
                         ">

                    <h4 class="mt-3 mb-1">${u.Full_Name}</h4>

                    <div class="text-muted mb-2">
                        ${u.Role_Name}
                    </div>

                    <span style="
                        display:inline-block;
                        padding:4px 14px;
                        border-radius:20px;
                        font-size:12px;
                        font-weight:600;
                        color:#fff;
                        background:${statusColor};
                        margin-bottom:20px;
                    ">
                        ${u.User_Status}
                    </span>

                    <div style="
                        display:grid;
                        grid-template-columns:1fr 1fr;
                        gap:12px 20px;
                        text-align:left;
                        margin-top:10px;
                        border-top:1px solid #e5e7eb;
                        padding-top:16px;
                    ">
                        <div>
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">USER ID</div>
                            <div style="font-size:14px;color:#111827;">${u.User_ID}</div>
                        </div>
                        <div>
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">USERNAME</div>
                            <div style="font-size:14px;color:#111827;">${u.Username}</div>
                        </div>
                        <div>
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">NIC</div>
                            <div style="font-size:14px;color:#111827;">${u.NIC}</div>
                        </div>
                        <div>
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">PHONE</div>
                            <div style="font-size:14px;color:#111827;">${u.Phone_Number}</div>
                        </div>
                        <div>
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">EMAIL</div>
                            <div style="font-size:14px;color:#111827;word-break:break-word;">${u.Email}</div>
                        </div>
                        <div style="grid-column:1 / -1;">
                            <div style="font-size:12px;color:#9ca3af;font-weight:600;">ADDRESS</div>
                            <div style="font-size:14px;color:#111827;">${u.Address}</div>
                        </div>
                    </div>

                </div>
            `
        });

    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire(
            'Error',
            'Something went wrong while loading user details.',
            'error'
        );
    });
}