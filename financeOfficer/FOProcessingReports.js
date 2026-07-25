/* ================================================================
   FOProcessingReports.js  -  Part 2: Processing Reports (FO Pending)
   ================================================================ */

let processingReportsTable = null;
let currentReportID = null;
let currentCompensationID = null;
let currentApprovedAmount = null;

$(document).ready(function () {
    initProcessingReportsTable();
    bindToolbarEvents();
    bindViewModalEvents();
    bindPaymentModalEvents();
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
// Custom DataTables district filter
// ----------------------------------------------------------------
$.fn.dataTable.ext.search.push(function (settings, data) {
    if (settings.nTable.id !== 'processingReportsTable') return true;

    const selectedDistrict = $('#districtFilter').val();
    if (!selectedDistrict) return true;

    return data[2] === selectedDistrict; // District column index = 2
});

// ----------------------------------------------------------------
// Init DataTable + load data
// ----------------------------------------------------------------
function initProcessingReportsTable() {
    processingReportsTable = $('#processingReportsTable').DataTable({
        dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            { title: 'Compensation ID' },
            { title: 'Report ID' },
            { title: 'District' },
            { title: 'Divisional Secretariat' },
            { title: 'Estimate Amount' },
            { title: 'Approved Amount' },
            { title: 'Bank Account No' },
            { title: 'Action', orderable: false }
        ]
    });

    loadProcessingReports();
}

function loadProcessingReports() {
    $.ajax({
        url: 'FOProcessingReports.php',
        method: 'GET',
        data: { action: 'list' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load reports.', 'error');
                return;
            }

            populateDistrictFilter(res.data);
            renderProcessingReportsTable(res.data);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong while loading reports.', 'error');
        }
    });
}

function populateDistrictFilter(rows) {
    const districts = [...new Set(rows.map(r => r.District).filter(Boolean))].sort();
    const $select = $('#districtFilter');
    const currentValSel = $select.val();

    $select.find('option:not(:first)').remove();
    districts.forEach(d => {
        $select.append(`<option value="${d}">${d}</option>`);
    });

    if (currentValSel) $select.val(currentValSel);
}

function renderProcessingReportsTable(rows) {
    processingReportsTable.clear();

    rows.forEach(row => {
        const rowData = JSON.stringify({
            Compensation_ID: row.Compensation_ID,
            Report_ID: row.Report_ID,
            Approved_Amount: row.Approved_Amount
        }).replace(/"/g, '&quot;');

        processingReportsTable.row.add([
            safeVal(row.Compensation_ID),
            safeVal(row.Report_ID),
            safeVal(row.District),
            safeVal(row.DS_Name),
            formatMoney(row.Estimate_Amount),
            formatMoney(row.Approved_Amount),
            safeVal(row.Beneficiary_Bank_Account_No),
            `<button class="icon-btn view" title="View Report" onclick="openReportDetails(${row.Report_ID}, '${rowData}')">
                <i class="bi bi-eye"></i>
             </button>
             <button class="icon-btn edit" title="Process Payment" onclick="openPaymentModalDirect('${rowData}')">
                <i class="bi bi-pencil-square"></i>
             </button>`
        ]);
    });

    processingReportsTable.draw();
}

// ----------------------------------------------------------------
// Toolbar events (search + district filter)
// ----------------------------------------------------------------
function bindToolbarEvents() {
    $('#searchInput').on('keyup', function () {
        processingReportsTable.search(this.value).draw();
    });

    $('#districtFilter').on('change', function () {
        processingReportsTable.draw();
    });
}

// ----------------------------------------------------------------
// View details modal (same data source as Part 1)
// ----------------------------------------------------------------
function openReportDetails(reportID, rowDataStr) {
    const rowData = JSON.parse(rowDataStr.replace(/&quot;/g, '"'));
    currentReportID = rowData.Report_ID;
    currentCompensationID = rowData.Compensation_ID;
    currentApprovedAmount = rowData.Approved_Amount;

    const modalEl = document.getElementById('reportDetailsModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    $('#reportDetailsBody').html(`
        <div class="text-center text-muted py-5">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2">Loading report details...</p>
        </div>
    `);

    modal.show();

    $.ajax({
        url: 'FOProcessingReports.php',
        method: 'GET',
        data: { action: 'details', report_id: reportID },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                $('#reportDetailsBody').html(`<div class="alert alert-danger">${res.message}</div>`);
                return;
            }
            $('#reportDetailsBody').html(buildReportDetailsHTML(res.data));
        },
        error: function () {
            $('#reportDetailsBody').html(`<div class="alert alert-danger">Failed to load report details.</div>`);
        }
    });
}

function buildReportDetailsHTML(d) {
    return `
        <div class="detail-section-title">Report Information</div>
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Report ID</div>
                <div class="detail-value">${safeVal(d.Report_ID)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Report Type</div>
                <div class="detail-value">${safeVal(d.Report_Type)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Report Date</div>
                <div class="detail-value">${safeVal(d.Report_Date)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">District</div>
                <div class="detail-value">${safeVal(d.District)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Divisional Secretariat</div>
                <div class="detail-value">${safeVal(d.DS_Name)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Street Address</div>
                <div class="detail-value">${safeVal(d.Street_Address)}</div>
            </div>
        </div>

        <div class="detail-section-title">Reporter Information</div>
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Full Name</div>
                <div class="detail-value">${safeVal(d.Full_Name)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">NIC</div>
                <div class="detail-value">${safeVal(d.NIC)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Phone Number</div>
                <div class="detail-value">${safeVal(d.Phone_Number)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Email</div>
                <div class="detail-value">${safeVal(d.Email)}</div>
            </div>
            <div class="col-md-8">
                <div class="detail-label">Address</div>
                <div class="detail-value">${safeVal(d.Address)}</div>
            </div>
        </div>

        <div class="detail-section-title">Beneficiary Bank Details</div>
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Beneficiary Name</div>
                <div class="detail-value">${safeVal(d.Beneficiary_Name)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Bank</div>
                <div class="detail-value">${safeVal(d.Beneficiary_Bank)}</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Account No</div>
                <div class="detail-value">${safeVal(d.Beneficiary_Bank_Account_No)}</div>
            </div>
        </div>

        <div class="detail-section-title">Verification / Estimate</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-label">Approved Amount</div>
                <div class="detail-value"><span class="badge-amount">${formatMoney(d.Estimated_Amount)}</span></div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Verification Date</div>
                <div class="detail-value">${safeVal(d.Verification_Date)}</div>
            </div>
        </div>
    `;
}

function bindViewModalEvents() {
    $('#btnGoToProcess').on('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('reportDetailsModal')).hide();
        openPaymentModal(currentCompensationID, currentReportID, currentApprovedAmount);
    });
}

// ----------------------------------------------------------------
// Payment modal (opened directly via edit icon, or via view->Process)
// ----------------------------------------------------------------
function openPaymentModalDirect(rowDataStr) {
    const rowData = JSON.parse(rowDataStr.replace(/&quot;/g, '"'));
    openPaymentModal(rowData.Compensation_ID, rowData.Report_ID, rowData.Approved_Amount);
}

function openPaymentModal(compensationID, reportID, approvedAmount) {
    currentCompensationID = compensationID;
    currentReportID = reportID;
    currentApprovedAmount = approvedAmount;

    $('#paySummaryCompID').text(safeVal(compensationID));
    $('#paySummaryReportID').text(safeVal(reportID));
    $('#paySummaryApprovedAmount').text(formatMoney(approvedAmount));

    $('#paymentForm')[0].reset();

    const modalEl = document.getElementById('paymentModal');
    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}

function bindPaymentModalEvents() {
    $('#btnSubmitPayment').on('click', function () {
        const paidAmount = $('#paidAmount').val();
        const description = $('#paymentDescription').val().trim();
        const receiptFile = $('#receiptFile')[0].files[0];

        if (!paidAmount || parseFloat(paidAmount) <= 0) {
            Swal.fire('Missing Data', 'Please enter a valid paid amount.', 'warning');
            return;
        }
        if (!description) {
            Swal.fire('Missing Data', 'Please enter a description.', 'warning');
            return;
        }
        if (!receiptFile) {
            Swal.fire('Missing Data', 'Please attach a receipt file.', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'pay');
        formData.append('compensation_id', currentCompensationID);
        formData.append('report_id', currentReportID);
        formData.append('paid_amount', paidAmount);
        formData.append('description', description);
        formData.append('receipt_file', receiptFile);

        Swal.fire({
            title: 'Confirm payment?',
            text: 'This will mark the compensation as paid and cannot be undone.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Yes, Confirm Payment'
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: 'FOProcessingReports.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to process payment.', 'error');
                        return;
                    }

                    bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                    Swal.fire('Success', res.message, 'success');
                    loadProcessingReports();
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong while processing the payment.', 'error');
                }
            });
        });
    });
}
