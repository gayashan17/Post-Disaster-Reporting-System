function toggleSidebar() {
  document.getElementById('sidebarLAO').classList.toggle('open');
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

function showNotifAlert() {
  Swal.fire({
    title: 'Notifications',
    text: '2 new reports have been assigned to you.',
    icon: 'info',
    confirmButtonColor: '#2563eb'
  });
}

function reviewReport(id, type, reporter) {
  Swal.fire({
    title: id,
    html: `
      <div style="text-align:left;font-size:13px;line-height:2.2">
        <p><b>Type:</b> ${type}</p>
        <p><b>Reported by:</b> ${reporter}</p>
        <p><b>Status:</b> <span style="color:#f59e0b;font-weight:600">Pending Review</span></p>
      </div>
    `,
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: '<i class="bi bi-check-lg"></i> Verify',
    denyButtonText: '<i class="bi bi-x-lg"></i> Reject',
    cancelButtonText: 'Close',
    confirmButtonColor: '#10b981',
    denyButtonColor: '#ef4444',
  }).then(result => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Report Verified!',
        text: id + ' has been verified and forwarded.',
        icon: 'success',
        confirmButtonColor: '#10b981'
      });
    } else if (result.isDenied) {
      Swal.fire({
        title: 'Report Rejected',
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
    if (r.isConfirmed)
    Swal.fire({
        title: 'Logged out',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(()=>{
        window.location.href = "/Post-Disaster-Reporting-System/LoginForm.php";
    });;
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

