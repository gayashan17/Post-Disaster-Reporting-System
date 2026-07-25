/* ================================================================
   DSDashboard.js  -  Part 4: District Secretary Dashboard
   ================================================================ */

let recentActivityTable = null;
let approvalsChart = null;

$(document).ready(function () {
    initRecentActivityTable();
    loadDashboardStats();
});

// ----------------------------------------------------------------
// Format helpers
// ----------------------------------------------------------------
function formatMoney(value) {
    const num = parseFloat(value);
    if (isNaN(num)) return 'Rs. 0.00';
    return 'Rs. ' + num.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function safeVal(val, fallback = '-') {
    return (val === null || val === undefined || val === '') ? fallback : val;
}

function formatMonthLabel(ym) {
    if (!ym) return '-';
    const [year, month] = ym.split('-');
    const date = new Date(year, parseInt(month, 10) - 1);
    return date.toLocaleString('en-US', { month: 'short', year: 'numeric' });
}

function statusBadge(status) {
    if (status === 'Verified') return `<span class="badge-approved">Approved</span>`;
    if (status === 'Rejected') return `<span class="badge-rejected">Rejected</span>`;
    return safeVal(status);
}

// ----------------------------------------------------------------
// Init recent activity table
// ----------------------------------------------------------------
function initRecentActivityTable() {
    recentActivityTable = $('#recentActivityTable').DataTable({
        dom: 't',
        paging: false,
        searching: false,
        info: false,
        columns: [
            { title: 'Report ID' },
            { title: 'Status' },
            { title: 'Date' }
        ]
    });
}

// ----------------------------------------------------------------
// Load stats from backend
// ----------------------------------------------------------------
function loadDashboardStats() {
    $.ajax({
        url: 'DSDashboard.php',
        method: 'GET',
        data: { action: 'stats' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load dashboard stats.', 'error');
                return;
            }
            renderStatCards(res.data);
            renderApprovalsChart(res.data.monthly || []);
            renderRecentActivity(res.data.recent || []);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong while loading the dashboard.', 'error');
        }
    });
}

// ----------------------------------------------------------------
// Stat cards
// ----------------------------------------------------------------
function renderStatCards(data) {
    $('#statPendingVerify').text(safeVal(data.pending_verify_count, 0));
    $('#statApproved').text(safeVal(data.approved_count, 0));
    $('#statRejected').text(safeVal(data.rejected_count, 0));
    $('#statTotalApproved').text(formatMoney(data.total_approved_amount));
}

// ----------------------------------------------------------------
// Approvals chart (Chart.js)
// ----------------------------------------------------------------
function renderApprovalsChart(monthlyData) {
    const labels = monthlyData.map(m => formatMonthLabel(m.ym));
    const values = monthlyData.map(m => parseInt(m.cnt, 10));

    const ctx = document.getElementById('approvalsChart').getContext('2d');

    if (approvalsChart) {
        approvalsChart.destroy();
    }

    approvalsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.length ? labels : ['No Data'],
            datasets: [{
                label: 'Reports Approved',
                data: values.length ? values : [0],
                backgroundColor: '#2563eb',
                borderRadius: 6,
                maxBarThickness: 46
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
}

// ----------------------------------------------------------------
// Recent activity table
// ----------------------------------------------------------------
function renderRecentActivity(rows) {
    recentActivityTable.clear();

    if (!rows.length) {
        recentActivityTable.row.add(['-', '-', '-']).draw();
        return;
    }

    rows.forEach(row => {
        recentActivityTable.row.add([
            safeVal(row.Report_ID),
            statusBadge(row.Report_Status),
            safeVal(row.Verification_Date)
        ]);
    });

    recentActivityTable.draw();
}
