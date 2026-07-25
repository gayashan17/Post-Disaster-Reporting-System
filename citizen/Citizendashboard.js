function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}

function showInfo(page) {
  Swal.fire({
    title: page,
    text: 'This section is under development.',
    icon: 'info',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'Got it'
  });
}

function setStatCards(total) {
    animateCounter('stat-total',total);
}

function newReport() {
  Swal.fire({
    title: 'New Report',
    text: 'Select Your Report Type',
    input: 'select',
    inputOptions: {
      'damage': 'Property Damage',
      'death': 'Death Record',
      'injure': 'Injured Person',
      'missing':'Missing Person Record'
    },
    showCancelButton: true,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Okay'
  }).then((result) => {
     if (result.isConfirmed) {
       let selectedType = result.value;

        switch(selectedType)
        {
            case 'damage':
            window.location.href = "../disasterReports/disasterReportFormDmg.php?type=" + selectedType;
            break;

            case'death':
            window.location.href = "../disasterReports/disasterReportFormDeath.php?type=" + selectedType;
            break;

            case'injure':
            window.location.href = "../disasterReports/disasterReportFormInj.php?type=" + selectedType;
            break;

            case'missing':
            window.location.href = "../disasterReports/disasterReportFormMissing.php?type=" + selectedType;
            break;

        }

     }
  });
}

function viewReport(reportId,type,district,status,date)
{

  Swal.fire({
    title: 'Report ID: ' + reportId,
    html: `
      <div style="text-align:left; font-size:13px; line-height:2.2">
        <p><b>Type:</b>${type}</p>
        <p><b>Location:</b>${district}</p>
        <p><b>Status:</b> <span style="color:#2563eb; font-weight:600">${status}</span></p>
        <p><b>Submitted:</b>${date} </p>
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

function showNotifications() {
  let contentHtml = '';

  // Safely grab userNotifications array
  const notificationsList = (typeof userNotifications !== 'undefined' && Array.isArray(userNotifications))
    ? userNotifications
    : [];

  if (notificationsList.length > 0) {
    // Build items list
    contentHtml = notificationsList.map(notif => `
      <div style="padding:10px 4px; border-bottom:1px solid #e2e8f0; display:flex; gap:10px; align-items:flex-start;">
        <span style="font-size:18px; line-height:1;"><i class="bi bi-info-circle-fill"></i></span>
        <div style="flex:1;">
          <div style="font-weight:600; color:#1e293b;">
            Report <b>:${escapeHtml(notif.report_id || notif.Report_ID)}</b>
          </div>
          <div style="color:#475569; margin-top:2px; font-size:12.5px;">
            ${escapeHtml(notif.message || notif.Message)}
          </div>
        </div>
      </div>
    `).join('');
  } else {
    // Fallback for empty notification list
    contentHtml = `
      <div style="padding:20px 0; text-align:center; color:#64748b;">
        <span>You have no notifications.</span>
      </div>
    `;
  }
    const hasNotifications = notificationsList.length > 0;
  // Render SweetAlert2
  Swal.fire({
    title: 'Notifications',
    width: '440px',
    html: `
      <div style="text-align:left; font-size:13px; max-height:320px; overflow-y:auto; padding-right:6px;">
        ${contentHtml}
      </div>
    `,
    showCancelButton: true,
    showConfirmButton: hasNotifications,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#64748b',
    confirmButtonText: 'Mark All as Read',
    cancelButtonText: 'Close',
    focusCancel: true
  }).then((result) => {
      if (result.isConfirmed)
      {
          fetch("../MarkNotificationsRead.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json"
              },
              body: JSON.stringify({
                  notificationIDs: notificationIDs
              })
          })
          .then(response => response.text())
          .then(data => {
              console.log(data);
              location.reload();
          });
      }
  });
}

// Helper function to prevent XSS attacks in dynamic JS content
function escapeHtml(text) {
  if (!text) return '';
  return String(text)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}




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
      }).then(()=>{
        window.location.href = "/Post-Disaster-Reporting-System/LoginForm.php";
      });
    }
  });
}

// Reusable Counter Animation Engine
function animateCounter(id, val) {
  const el = document.getElementById(id);
  if (!el) return; // Failsafe: Stops script execution errors if counter targets are missing

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

window.addEventListener('load', () => {
  // 1. DataTables Setup
  if ($.fn.DataTable && $('#reports-table').length) {
    $('#reports-table').DataTable({
      pageLength: 5,
      lengthMenu: [5, 10, 25],
      order: [[4, 'desc']],
      columnDefs: [{ orderable: false, targets: 5 }],
      language: {
        search: '',
        searchPlaceholder: 'Search reports...',
        lengthMenu: 'Show _MENU_',
        info: 'Showing _START_-_END_ of _TOTAL_ reports',
        paginate: { previous: '&lsaquo;', next: '&rsaquo;' }
      }
    });
  }
});
  // 2. Doughnut Chart Setup
function renderReportChart(labels, data)
{
  const chartElement = document.getElementById('report-chart');
  if (chartElement && typeof Chart !== 'undefined')
  {
    const chartCtx = chartElement.getContext('2d');

    // Modern color palette matching your design
    const colors = ['#2563eb', '#7c3aed', '#ef4444', '#f59e0b', '#10b981', '#06b6d4'];

    new Chart(chartCtx,
    {
      type: 'doughnut',
      data:
      {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colors.slice(0, labels.length),
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options:
      {
        cutout: '65%',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { font: { size: 11 }, padding: 10, boxWidth: 12 }
          }
        }
      }
    });
  }
}