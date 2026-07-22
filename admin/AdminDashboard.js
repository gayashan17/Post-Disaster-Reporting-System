/* ==========================================================================
   1. NAVIGATION, SIDEBAR & DASHBOARD INTERACTION ACTIONS
   ========================================================================== */
let roleChart = null;
let activityChart = null;

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  if (sidebar) {
    sidebar.classList.toggle('open');
  }
}

// Global placeholder for under-development features
function showInfo(page) {
  Swal.fire({
    title: page,
    text: 'This section is under development.',
    icon: 'info',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'Got it'
  });
}

// Redirect and handle new report generation matching your actual routes
function newReport() {
  Swal.fire({
    title: 'New Report',
    text: 'Select Your Report Type',
    input: 'select',
    inputOptions: {
      'damage': 'Property Damage',
      'death': 'Death Record',
      'injure': 'Injured Person',
      'missing': 'Missing Person Record'
    },
    showCancelButton: true,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Okay'
  }).then((result) => {
    if (result.isConfirmed) {
      const selectedType = result.value;
      switch (selectedType) {
        case 'damage':
          window.location.href = "disasterReports/disasterReportFormDmg.php?type=" + selectedType;
          break;
        case 'death':
          window.location.href = "disasterReports/disasterReportFormDeath.php?type=" + selectedType;
          break;
        case 'injure':
          window.location.href = "disasterReports/disasterReportFormInj.php?type=" + selectedType;
          break;
        case 'missing':
          window.location.href = "disasterReports/disasterReportFormMissing.php?type=" + selectedType;
          break;
      }
    }
  });
}

// View details of a specific report modal
function viewReport(reportId) {
  Swal.fire({
    title: reportId,
    html: `
      <div style="text-align:left; font-size:13px; line-height:2.2">
        <p><b>Type:</b> Property Damage</p>
        <p><b>Location:</b> Colombo</p>
        <p><b>Status:</b> <span style="color:#2563eb; font-weight:600">Under Review</span></p>
        <p><b>Submitted:</b> 2024-05-20</p>
        <p><b>Assigned Officer:</b> Local Authority Officer</p>
      </div>
    `,
    icon: 'info',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'Close',
    showCancelButton: true,
    cancelButtonText: 'Track Report',
    cancelButtonColor: '#10b981'
  });
}

// System alerts/notifications panel
function showNotifications() {
  Swal.fire({
    title: 'Notifications',
    width: '440px',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'View All',
    html: `
      <div style="text-align:left; font-size:13px">
        <div style="padding:10px 0; border-bottom:1px solid #e2e8f0; display:flex; gap:10px; align-items:center">
          <span style="font-size:18px">🔔</span>
          <span>Report <b>RPT-2024-0011</b> has been <b>approved</b>.</span>
        </div>
        <div style="padding:10px 0; border-bottom:1px solid #e2e8f0; display:flex; gap:10px; align-items:center">
          <span style="font-size:18px">⏳</span>
          <span>Report <b>RPT-2024-0012</b> is under verification.</span>
        </div>
        <div style="padding:10px 0; display:flex; gap:10px; align-items:center">
          <span style="font-size:18px">💳</span>
          <span>Payment for <b>RPT-2024-0009</b> has been completed.</span>
        </div>
      </div>
    `
  });
}

// Hook to topbar bell icon click matching HTML
function showNotifAlert() {
  showNotifications();
}

function addUser() {
  Swal.fire({
    title: 'New User',
    text: 'Select User Role To Create a new Account',
    input: 'select',
    inputOptions: {
      'citizen': 'Citizen',
      'admin': 'Admin',
      'lao': 'Local Authority Officer',
      'dmo':'Disaster Management Officer',
      'ds':'District Secretary',
      'fo':'Financial Officer'
    },
    showCancelButton: true,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Okay'
  }).then((result) => {
    if(result.isConfirmed)
    {
        let selectedType = result.value;
        window.location.href = "AdminAddUser.php?type=" + selectedType;
    }
  });


  }
// Confirm Admin Sign Out
function confirmLogout() {
  Swal.fire({
    title: 'Logging out?',
    text: 'You will be redirected to the login page.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#64748b',
    confirmButtonText: 'Yes, logout',
    cancelButtonText: 'Stay'
  }).then(result => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Logged out',
        text: 'See you again!',
        icon: 'success',
        confirmButtonColor: '#2563eb',
        timer: 1800,
        showConfirmButton: false
      }).then(() => {
        window.location.href = "../LoginForm.php";
      });
    }
  });
}


/* ==========================================================================
   2. REUSABLE COUNTER ANIMATION ENGINE
   ========================================================================== */
function animateCounter(id, val) {
  const el = document.getElementById(id);
  if (!el) return; // Failsafe check

  let c = 0, step = Math.ceil(val / 20) || 1;
  const iv = setInterval(() => {
    c += step;
    if (c >= val) {
      el.textContent = val;
      clearInterval(iv);
    } else {
      el.textContent = c;
    }
  }, 40);
}


/* ==========================================================================
   3. INITIALIZING SYSTEM TABLES & CHARTS ON WINDOW LOAD
   ========================================================================== */
window.addEventListener('load', () => {

  // 1. DataTables Setup for main dashboard grid framework
  if ($.fn.DataTable && $('#users-table').length) {
    $('#users-table').DataTable({
      pageLength: 5,
      lengthMenu: [5, 10, 25],
      responsive: true,
      dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-3"f>t<"d-flex flex-wrap justify-content-between align-items-center mt-3"ip>',
      language: {
        search: '',
        searchPlaceholder: 'Search users...',
        lengthMenu: 'Show _MENU_',
        paginate: { previous: '&lsaquo;', next: '&rsaquo;' }
      }
    });
  }

  // 3. Monthly Activity Bar Chart Initialization

  // 4. Run Metric Counters matching your main panel template IDs
  loadDashboardStats()

});


// ================================================================//
//                         Load Dashboard                          //
// ================================================================//

/////// load dashboard status

function loadDashboardStats()
{
fetch("Admindashboard.php")
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data);

        try {
            const jsonData = JSON.parse(data);

            if (!jsonData.success) {
                console.error(jsonData.message);
                return;
            }

            document.getElementById("stat-users").textContent = jsonData.totalUsers;
            document.getElementById("stat-active").textContent = jsonData.activeUsers;
            document.getElementById("stat-banned").textContent = jsonData.bannedUsers;
            document.getElementById("stat-reports").textContent = jsonData.totalReports;

            loadRoleChart(jsonData.roleCounts);

            loadActivityChart(jsonData.monthlyReportActivity);

            loadRecentRegistrations(jsonData.recentRegistrations);
        }
        catch (error) {
            console.error("Invalid JSON received from PHP:", error);
            console.log(data);
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
    });
}

/////////// Role data

function loadRoleChart(roleCounts)
{
    const roleChartEl = document.getElementById('role-chart');

    if (!roleChartEl)
    {
        return;
    }

    const chartCtx = roleChartEl.getContext('2d');

    if(roleChart)
    {
        roleChart.destroy();
    }

    roleChart = new Chart(chartCtx,
    {
        type: 'pie',
        data:
        {
            labels:
            [
                'Admin',
                'Citizen',
                'Local Authority Officer',
                'Disaster Management Officer',
                'District Secretary',
                'Finance Officer'
            ],
            datasets:
            [{
                data:
                [
                    roleCounts.Admin,
                    roleCounts.Citizen,
                    roleCounts["Local Authority Officer"],
                    roleCounts["Disaster Management Officer"],
                    roleCounts["District Secretary"],
                    roleCounts["Finance Officer"]
                ],
                backgroundColor:
                [
                    '#ef4444',
                    '#2563eb',
                    '#10b981',
                    '#7c3aed',
                    '#f59e0b',
                    '#ec4899'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options:
        {
            responsive: true,
            maintainAspectRatio: false,

            plugins:
            {
                legend:
                {
                    position: 'bottom'
                }
            }
        }
    });
  
}

////////// Activity chart

function loadActivityChart(monthlyData)
{
    const activityChartEl = document.getElementById('activity-chart');

    if (!activityChartEl)
    {
        return;
    }

    const chartCtx = activityChartEl.getContext('2d');

    if(activityChart)
    {
        activityChart.destroy();
    }

    activityChart = new Chart(chartCtx,
    {
        type: 'bar',
        data:
        {
            labels:
            [
                'Jan', 'Feb', 'Mar', 'Apr',
                'May', 'Jun', 'Jul', 'Aug',
                'Sep', 'Oct', 'Nov', 'Dec'
            ],
            datasets:
            [{
                label: 'Disaster Reports Filed',
                data: monthlyData,
                backgroundColor: '#f59e0b',
                borderRadius: 6
            }]
        },
        options:
        {
            responsive: true,
            maintainAspectRatio: false,

            plugins:
            {
                legend:
                {
                    display: false
                }
            },

            scales:
            {
                y:
                {
                    beginAtZero: true
                }
            }
        }
    });
}

////////// Recent Registration 

function loadRecentRegistrations(users)
{
    const container = document.getElementById("recent-registrations");

    if (!container)
    {
        return;
    }

    container.innerHTML = "";

    users.forEach(user =>
    {
        const statusClass =
            user.User_Status === "Active"
                ? "badge-approved"
                : "badge-rejected";

        const roleClassMap = {
            "Citizen": "citizen",
            "Local Authority Officer": "lao",
            "Disaster Management Officer": "dmo",
            "District Secretary": "ds",
            "Finance Officer": "finance",
            "Admin": "admin"
        };

        const avatarClassMap = {
              "Citizen": "blue-av",
              "Local Authority Officer": "green-av",
              "Disaster Management Officer": "purple-av",
              "District Secretary": "rose-av",
              "Finance Officer": "amber-av",
              "Admin": "teal-av"
        };

        const roleClass = roleClassMap[user.Role] || "admin";
        const avatarClass = avatarClassMap[user.Role] || "blue-av";

        container.innerHTML += `
            <div class="user-row">

                  <div class="user-row-avatar ${avatarClass}">
                      ${user.Full_Name.charAt(0).toUpperCase()}
                  </div>

                <div class="user-row-info">

                    <div class="user-row-name">
                        ${user.Full_Name}
                    </div>

                    <div class="user-row-meta">
                        <span class="role-pill ${roleClass}">
                            ${user.Role}
                        </span>
                        • ${user.Email}
                        • Joined ${user.Created_Date}
                    </div>

                </div>

                <span class="badge-status ${statusClass}">
                    ${user.User_Status}
                </span>

            </div>
        `;
    });
}