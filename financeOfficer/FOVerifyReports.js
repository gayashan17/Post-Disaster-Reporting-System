/* ================================================================
   FOVerifyReports.js  -  Part 1: Verify Reports (DS Approved list)
   ================================================================ */

let verifyReportsTable = null;
let currentReportID = null;

$(document).ready(function () {
    initVerifyReportsTable();
    bindToolbarEvents();
    bindModalEvents();
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
    if (settings.nTable.id !== 'verifyReportsTable') return true;

    const selectedDistrict = $('#districtFilter').val();
    if (!selectedDistrict) return true;

    return data[1] === selectedDistrict; // District column index = 1
});

// ----------------------------------------------------------------
// Init DataTable + load data
// ----------------------------------------------------------------
function initVerifyReportsTable() {
    verifyReportsTable = $('#verifyReportsTable').DataTable({
        dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            { title: 'Report ID' },
            { title: 'District' },
            { title: 'DS Office' },
            { title: 'Approved Amount' },
            { title: 'Bank Account No' },
            { title: 'Action', orderable: false }
        ]
    });

    loadVerifyReports();
}

function loadVerifyReports() {
    $.ajax({
        url: 'FOVerifyReports.php',
        method: 'GET',
        data: { action: 'list' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load reports.', 'error');
                return;
            }

            populateDistrictFilter(res.data);
            renderVerifyReportsTable(res.data);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong while loading reports.', 'error');
        }
    });
}

function populateDistrictFilter(rows) {
    const districts = [...new Set(rows.map(r => r.District).filter(Boolean))].sort();
    const $select = $('#districtFilter');
    const currentVal = $select.val();

    $select.find('option:not(:first)').remove();
    districts.forEach(d => {
        $select.append(`<option value="${d}">${d}</option>`);
    });

    if (currentVal) $select.val(currentVal);
}

function renderVerifyReportsTable(rows) {
    verifyReportsTable.clear();

    rows.forEach(row => {
        verifyReportsTable.row.add([
            safeVal(row.Report_ID),
            safeVal(row.District),
            safeVal(row.Office_Name),
            formatMoney(row.Estimated_Amount),
            safeVal(row.Bank_Account_No),
            `<button class="icon-btn view" title="View Report" onclick="openReportDetails(${row.Report_ID})">
                <i class="bi bi-eye"></i>
            </button>`
        ]);
    });

    verifyReportsTable.draw();
}

// ----------------------------------------------------------------
// Toolbar events (search + district filter)
// ----------------------------------------------------------------
function bindToolbarEvents() {
    $('#searchInput').on('keyup', function () {
        verifyReportsTable.search(this.value).draw();
    });

    $('#districtFilter').on('change', function () {
        verifyReportsTable.draw();
    });
}

// ----------------------------------------------------------------
// Report details modal
// ----------------------------------------------------------------
function openReportDetails(reportID) {
    currentReportID = reportID;

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
        url: 'FOVerifyReports.php',
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

// ----------------------------------------------------------------
// Process Report button
// ----------------------------------------------------------------
function bindModalEvents() {
    $('#btnProcessReport').on('click', function () {
        if (!currentReportID) return;

        Swal.fire({
            title: 'Process this report?',
            text: 'This will create a compensation record and move the report to Processing.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Yes, Process it'
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: 'FOVerifyReports.php',
                method: 'POST',
                data: { action: 'process', report_id: currentReportID },
                dataType: 'json',
                success: function (res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to process report.', 'error');
                        return;
                    }

                    bootstrap.Modal.getInstance(document.getElementById('reportDetailsModal')).hide();
                    Swal.fire('Success', res.message, 'success');
                    loadVerifyReports();
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong while processing the report.', 'error');
                }
            });
        });
    });
}
