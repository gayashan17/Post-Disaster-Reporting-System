function toggleSidebar() {
  document.getElementById('sidebarDMO').classList.toggle('open');
}

function showInfo(page) {
  Swal.fire({
    title: page,
    text: 'This section is under development.',
    icon: 'info',
    confirmButtonColor: '#10b981',
    confirmButtonText: 'Got it'
  });
}

function showNotifAlert() {
  Swal.fire({
    title: 'Notifications',
    text: '2 new compensation requests forwarded.',
    icon: 'info',
    confirmButtonColor: '#10b981'
  });
}

function approveCompensation(id, amount) {
  Swal.fire({
    title: 'Review ' + id,
    html: `<div style="text-align:left;font-size:13px;line-height:2.2">
      <p><b>Recommended Amount:</b> Rs. ${amount}</p>
      <p><b>Status:</b> <span style="color:#2563eb;font-weight:600">Awaiting DMO Approval</span></p>
    </div>`,
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: ' Approve Compensation',
    denyButtonText: ' Reject',
    cancelButtonText: 'Close',
    confirmButtonColor: '#10b981',
    denyButtonColor: '#ef4444',
  }).then(result => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Compensation Approved!',
        text: id + ' — Rs. ' + amount + ' approved and sent to Financial Officer.',
        icon: 'success',
        confirmButtonColor: '#10b981'
      });
    } else if (result.isDenied) {
      Swal.fire({
        title: 'Request Rejected',
        text: id + ' has been rejected.',
        icon: 'error',
        confirmButtonColor: '#ef4444'
      });
    }
  });
}

function confirmLogout() {
  Swal.fire({
    title: 'Logging out?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    confirmButtonText: 'Yes, logout',
    cancelButtonText: 'Stay'
  }).then(r => {
    if (r.isConfirmed) Swal.fire({ title: 'Logged out', icon: 'success', timer: 1500, showConfirmButton: false });
  });
}

// Reusable Counter Animation Engine
function animateCounter(id, val) {
  const el = document.getElementById(id);
  if (!el) return; // Prevent errors if an ID is missing on a specific page

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

// Safe Execution Initialization Block
window.addEventListener('load', () => {

  // 1. Initialize Chart Safely after canvas DOM elements exist
  const chartCanvas = document.getElementById('dmo-chart');
  if (chartCanvas) {
    const ctx = chartCanvas.getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Property', 'Missing Person', 'Death', 'Flood', 'Other'],
        datasets: [{
          label: 'Rs. (000s)',
          data: [250, 500, 750, 300, 100],
          backgroundColor: ['#2563eb','#10b981','#ef4444','#f59e0b','#7c3aed'],
          borderRadius: 6,
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } },
          x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
      }
    });
  }

  // 2. Animate Layout Counter Widgets Safely
  animateCounter('s-total', 15);
  animateCounter('s-pending', 3);
  animateCounter('s-approved', 10);
  animateCounter('s-rejected', 2);
});