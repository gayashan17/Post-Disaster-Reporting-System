/* ================================================================
   FODashboard.js  -  Part 4: Financial Officer Dashboard
   ================================================================ */

let recentPaymentsTable = null;
let paymentsChart = null;

$(document).ready(function () {
    initRecentPaymentsTable();
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
    // ym format: 'YYYY-MM'
    if (!ym) return '-';
    const [year, month] = ym.split('-');
    const date = new Date(year, parseInt(month, 10) - 1);
    return date.toLocaleString('en-US', { month: 'short', year: 'numeric' });
}

// ----------------------------------------------------------------
// Init recent payments table
// ----------------------------------------------------------------
function initRecentPaymentsTable() {
    recentPaymentsTable = $('#recentPaymentsTable').DataTable({
        dom: 't',
        paging: false,
        searching: false,
        info: false,
        columns: [
            { title: 'Comp. ID' },
            { title: 'Report ID' },
            { title: 'Paid Amount' },
            { title: 'Date' }
        ]
    });
}

// ----------------------------------------------------------------
// Load stats from backend
// ----------------------------------------------------------------
function loadDashboardStats() {
    $.ajax({
        url: 'FODashboard.php',
        method: 'GET',
        data: { action: 'stats' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load dashboard stats.', 'error');
                return;
            }
            renderStatCards(res.data);
            renderPaymentsChart(res.data.monthly || []);
            renderRecentPayments(res.data.recent || []);
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
    $('#statDsApproved').text(safeVal(data.ds_approved_count, 0));
    $('#statFoPending').text(safeVal(data.fo_pending_count, 0));
    $('#statPaidCount').text(safeVal(data.paid_count, 0));
    $('#statTotalPaid').text(formatMoney(data.total_paid_amount));
}

// ----------------------------------------------------------------
// Payments chart (Chart.js)
// ----------------------------------------------------------------
function renderPaymentsChart(monthlyData) {
    const labels = monthlyData.map(m => formatMonthLabel(m.ym));
    const values = monthlyData.map(m => parseFloat(m.total));

    const ctx = document.getElementById('paymentsChart').getContext('2d');

    if (paymentsChart) {
        paymentsChart.destroy();
    }

    paymentsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.length ? labels : ['No Data'],
            datasets: [{
                label: 'Amount Paid (Rs.)',
                data: values.length ? values : [0],
                backgroundColor: '#10b981',
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
                    ticks: {
                        callback: function (value) {
                            return 'Rs. ' + value.toLocaleString('en-LK');
                        }
                    }
                }
            }
        }
    });
}

// ----------------------------------------------------------------
// Recent payments table
// ----------------------------------------------------------------
function renderRecentPayments(rows) {
    recentPaymentsTable.clear();

    if (!rows.length) {
        recentPaymentsTable.row.add(['-', '-', '-', '-']).draw();
        return;
    }

    rows.forEach(row => {
        recentPaymentsTable.row.add([
            safeVal(row.Compensation_ID),
            safeVal(row.Report_ID),
            formatMoney(row.Paid_Amount),
            safeVal(row.Payment_Date)
        ]);
    });

    recentPaymentsTable.draw();
}
