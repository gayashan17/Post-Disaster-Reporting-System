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

function escapeHtml(text) {
  if (!text) return '';
  return String(text)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
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

