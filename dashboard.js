/* datatable initialization */
$(document).ready(function () {
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
});

/* doughnut chart implementation */
document.addEventListener('DOMContentLoaded', function () {
  const chartElement = document.getElementById('report-chart');
  
  if (chartElement) {
    const chartCtx = chartElement.getContext('2d');

    new Chart(chartCtx, {
      type: 'doughnut',
      data: {
        labels: ['Property Damage', 'Missing Person', 'Death Report', 'Flood Damage', 'Other'],
        datasets: [{
          data: [7, 1, 1, 2, 1],
          backgroundColor: ['#2563eb', '#10b981', '#ef4444', '#f59e0b', '#7c3aed'],
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options: {
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
});

/* stat counter animation logic */
function animateCounter(elementId, targetValue) {
  const el = document.getElementById(elementId);
  let current = 0;
  const step = Math.ceil(targetValue / 20) || 1;

  const interval = setInterval(() => {
    current += step;
    if (current >= targetValue) {
      el.textContent = targetValue;
      clearInterval(interval);
    } else {
      el.textContent = current;
    }
  }, 40);
}

window.addEventListener('load', () => {
  animateCounter('stat-total',   12);
  animateCounter('stat-pending',  4);
  animateCounter('stat-approved', 6);
  animateCounter('stat-payment',  2);
});

/* responsive mobile sidebar toggle */
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}

/* sweetalert: general info popup */
function showInfo(page) {
  Swal.fire({
    title: page,
    text: 'This section is under development.',
    icon: 'info',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'Got it'
  });
}

/* sweetalert: detailed report view */
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

/* sweetalert: dynamic notification panel */
function showNotifications() {
  Swal.fire({
    title: 'Notifications',
    width: '440px',
    confirmButtonColor: '#2563eb',
    confirmButtonText: 'View All',
    html: `
      <div style="text-align:left; font-size:13px">
        <div style="padding:10px 0; border-bottom:1px solid #e2e8f0; display:flex; gap:10px; align-items:center">
          <span style="font-size:18px">✅</span>
          <span>Report <b>RPT-2024-0011</b> has been <b>approved</b>.</span>
        </div>
        <div style="padding:10px 0; border-bottom:1px solid #e2e8f0; display:flex; gap:10px; align-items:center">
          <span style="font-size:18px">ℹ️</span>
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

/* sweetalert: application logout handler */
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
      });
    }
  });
}