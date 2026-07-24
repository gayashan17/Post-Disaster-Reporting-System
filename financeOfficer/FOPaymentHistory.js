/* ================================================================
   FOPaymentHistory.js  -  Part 3: Payment History (Paid reports)
   ================================================================ */

let paymentHistoryTable = null;
let allPaymentRows = [];

$(document).ready(function () {
    initPaymentHistoryTable();
    bindToolbarEvents();
});

// ----------------------------------------------------------------
// Format helpers
// ----------------------------------------------------------------
function formatMoney(value) {
    const num = parseFloat(value);
    if (isNaN(num)) return '-';
    return 'Rs. ' + num.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function safeVal(val, fallback = '-') {
    return (val === null || val === undefined || val === '') ? fallback : val;
}

// ----------------------------------------------------------------
// Init DataTable + load data
// ----------------------------------------------------------------
function initPaymentHistoryTable() {
    paymentHistoryTable = $('#paymentHistoryTable').DataTable({
        dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            { title: 'Compensation ID' },
            { title: 'Report ID' },
            { title: 'Estimate Amount' },
            { title: 'Approved Amount' },
            { title: 'Paid Amount' },
            { title: 'Payment Date' },
            { title: 'Status' },
            { title: 'Action', orderable: false }
        ]
    });

    loadPaymentHistory();
}

function loadPaymentHistory() {
    $.ajax({
        url: 'FOPaymentHistory.php',
        method: 'GET',
        data: { action: 'list' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load payment history.', 'error');
                return;
            }

            allPaymentRows = res.data;
            renderPaymentHistoryTable(res.data);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong while loading payment history.', 'error');
        }
    });
}

function renderPaymentHistoryTable(rows) {
    paymentHistoryTable.clear();

    rows.forEach((row, index) => {
        paymentHistoryTable.row.add([
            safeVal(row.Compensation_ID),
            safeVal(row.Report_ID),
            formatMoney(row.Estimate_Amount),
            formatMoney(row.Approved_Amount),
            formatMoney(row.Paid_Amount),
            safeVal(row.Payment_Date),
            `<span class="badge-paid">${safeVal(row.Payment_Status)}</span>`,
            `<button class="icon-btn view" title="View Payment" onclick="openPaymentDetails(${index})">
                <i class="bi bi-eye"></i>
             </button>`
        ]);
    });

    paymentHistoryTable.draw();
}

// ----------------------------------------------------------------
// Toolbar search
// ----------------------------------------------------------------
function bindToolbarEvents() {
    $('#searchInput').on('keyup', function () {
        paymentHistoryTable.search(this.value).draw();
    });
}

// ----------------------------------------------------------------
// Payment details modal (built directly from already-loaded row data,
// no extra backend call needed since compensation_report already
// carries every field required for this view)
// ----------------------------------------------------------------
function openPaymentDetails(index) {
    const d = allPaymentRows[index];
    if (!d) return;

    let receiptHtml = '<span class="text-muted">No receipt uploaded</span>';
    if (d.Receipt_File_Path) {
        receiptHtml = `<a class="receipt-link" href="${d.Receipt_File_Path}" target="_blank">
                           <i class="bi bi-file-earmark-arrow-down"></i> View / Download Receipt
                       </a>`;
    }

    $('#paymentDetailsBody').html(`
        <div class="detail-section-title">Compensation Summary</div>
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Compensation ID</div>
                <div class="detail-value">${safeVal(d.Compensation_ID)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Report ID</div>
                <div class="detail-value">${safeVal(d.Report_ID)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Status</div>
                <div class="detail-value"><span class="badge-paid">${safeVal(d.Payment_Status)}</span></div>
            </div>
        </div>

        <div class="detail-section-title">Amounts</div>
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Estimate Amount</div>
                <div class="detail-value">${formatMoney(d.Estimate_Amount)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Approved Amount</div>
                <div class="detail-value">${formatMoney(d.Approved_Amount)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Paid Amount</div>
                <div class="detail-value"><span class="badge-amount">${formatMoney(d.Paid_Amount)}</span></div>
            </div>
        </div>

        <div class="detail-section-title">Payment Information</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-label">Payment Date</div>
                <div class="detail-value">${safeVal(d.Payment_Date)}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Created Date</div>
                <div class="detail-value">${safeVal(d.Created_Date)}</div>
            </div>
            <div class="col-md-12">
                <div class="detail-label">Description</div>
                <div class="detail-value">${safeVal(d.Description)}</div>
            </div>
            <div class="col-md-12">
                <div class="detail-label">Receipt</div>
                <div class="detail-value">${receiptHtml}</div>
            </div>
        </div>
    `);

    bootstrap.Modal.getOrCreateInstance(document.getElementById('paymentDetailsModal')).show();
}
