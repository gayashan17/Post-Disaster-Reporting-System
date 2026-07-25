/* ================================================================
   DSVerifyReports.js  -  Part 1: Verify Reports (DMO Approved)
   ================================================================ */

let verifyReportsTable = null;
let currentReportID = null;
let currentReportType = null;
let currentEstimateAmount = null;

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
// Custom DataTables Divisional Secretariat filter
// ----------------------------------------------------------------
$.fn.dataTable.ext.search.push(function (settings, data) {
    if (settings.nTable.id !== 'verifyReportsTable') return true;

    const selectedDS = $('#dsFilter').val();
    if (!selectedDS) return true;

    return data[2] === selectedDS; // Divisional Secretariat column index = 2
});

// ----------------------------------------------------------------
// Init DataTable + load data
// ----------------------------------------------------------------
function initVerifyReportsTable() {
    verifyReportsTable = $('#verifyReportsTable').DataTable({
        dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            { title: 'Report ID' },
            { title: 'Report Type' },
            { title: 'Divisional Secretariat' },
            { title: 'Estimate Amount' },
            { title: 'Bank Account No' },
            { title: 'Action', orderable: false }
        ]
    });

    loadVerifyReports();
}

function loadVerifyReports() {
    $.ajax({
        url: 'DSVerifyReports.php',
        method: 'GET',
        data: { action: 'list' },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                Swal.fire('Error', res.message || 'Failed to load reports.', 'error');
                return;
            }

            populateDSFilter(res.data);
            renderVerifyReportsTable(res.data);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong while loading reports.', 'error');
        }
    });
}

function populateDSFilter(rows) {
    const dsNames = [...new Set(rows.map(r => r.DS_Name).filter(Boolean))].sort();
    const $select = $('#dsFilter');
    const currentValSel = $select.val();

    $select.find('option:not(:first)').remove();
    dsNames.forEach(name => {
        $select.append(`<option value="${name}">${name}</option>`);
    });

    if (currentValSel) $select.val(currentValSel);
}

function renderVerifyReportsTable(rows) {
    verifyReportsTable.clear();

    rows.forEach(row => {
        verifyReportsTable.row.add([
            safeVal(row.Report_ID),
            safeVal(row.Report_Type),
            safeVal(row.DS_Name),
            formatMoney(row.Estimated_Amount),
            safeVal(row.Bank_Account_No),
            `<button class="icon-btn view" title="View Report" onclick="openReportDetails(${row.Report_ID})">
                <i class="bi bi-eye"></i>
             </button>
             <button class="icon-btn approve" title="Approve" onclick="openApproveModal(${row.Report_ID}, '${safeVal(row.Report_Type)}', ${row.Estimated_Amount || 0})">
                <i class="bi bi-check2-circle"></i>
             </button>
             <button class="icon-btn reject" title="Reject" onclick="rejectReport(${row.Report_ID})">
                <i class="bi bi-x-circle"></i>
             </button>`
        ]);
    });

    verifyReportsTable.draw();
}

// ----------------------------------------------------------------
// Toolbar events (search + DS filter)
// ----------------------------------------------------------------
function bindToolbarEvents() {
    $('#searchInput').on('keyup', function () {
        verifyReportsTable.search(this.value).draw();
    });

    $('#dsFilter').on('change', function () {
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
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2">Loading report details...</p>
        </div>
    `);

    modal.show();

    $.ajax({
        url: 'DSVerifyReports.php',
        method: 'GET',
        data: { action: 'details', report_id: reportID },
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                $('#reportDetailsBody').html(`<div class="alert alert-danger">${res.message}</div>`);
                return;
            }

            currentReportType = res.data.report.Report_Type;
            currentEstimateAmount = res.data.report.Estimated_Amount;

            $('#reportDetailsBody').html(buildReportDetailsHTML(res.data.report, res.data.type_details, res.data.evidence_files));
        },
        error: function () {
            $('#reportDetailsBody').html(`<div class="alert alert-danger">Failed to load report details.</div>`);
        }
    });
}

function buildTypeDetailsHTML(reportType, typeDetails) {
    if (!typeDetails || !typeDetails.length) {
        return `<div class="text-muted">No additional type-specific data recorded.</div>`;
    }

    let html = '';

    typeDetails.forEach((entry, index) => {
        html += `<div class="type-entry-card">`;
        html += `<div class="fw-semibold mb-2">#${index + 1}</div>`;
        html += `<div class="row">`;

        switch (reportType) {
            case 'Property Damage':
                html += entryCol('Property Type', entry.Property_Type);
                html += entryCol('Damage Level', entry.Damage_Level);
                html += entryCol('Estimated Cost', formatMoney(entry.Estimated_Cost));
                html += entryCol('Damage Description', entry.Damage_Description, 12);
                break;

            case 'Death Record':
                html += entryCol('Full Name', entry.Full_Name);
                html += entryCol('Age', entry.Age);
                html += entryCol('Gender', entry.Gender);
                html += entryCol('Cause of Death', entry.Cause_Of_Death, 12);
                break;

            case 'Injured Person':
                html += entryCol('Full Name', entry.Full_Name);
                html += entryCol('Age', entry.Age);
                html += entryCol('Gender', entry.Gender);
                html += entryCol('Injured Level', entry.Injured_Level);
                break;

            case 'Missing Person Record':
                html += entryCol('Full Name', entry.Full_Name);
                html += entryCol('Age', entry.Age);
                html += entryCol('Gender', entry.Gender);
                html += entryCol('Last Seen Location', entry.Last_Seen_Location);
                html += entryCol('Last Seen Date', entry.Last_Seen_Date);
                html += entryCol('Last Seen Time', entry.Last_Seen_Time);
                html += entryCol('Status', entry.Missing_Status || entry.Status);
                html += entryCol('Relationship', entry.Relationship_to_Person);
                break;

            default:
                html += `<div class="col-12 text-muted">No template available for this report type.</div>`;
        }

        html += `</div></div>`;
    });

    return html;
}

function entryCol(label, value, colSize = 4) {
    return `<div class="col-md-${colSize}">
                <div class="detail-label">${label}</div>
                <div class="detail-value">${safeVal(value)}</div>
            </div>`;
}

function buildEvidenceHTML(files) {
    if (!files || !files.length) {
        return `<div class="text-muted">No evidence files uploaded.</div>`;
    }

    let html = '';
    files.forEach(f => {
        const icon = (f.File_Type && f.File_Type.includes('pdf')) ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image';
        html += `
            <div class="evidence-item">
                <div><i class="bi ${icon} me-2"></i>${safeVal(f.File_Name)}</div>
                <a href="${f.File_Path}" target="_blank" download>
                    <i class="bi bi-download"></i> Download
                </a>
            </div>
        `;
    });
    return html;
}

function buildReportDetailsHTML(d, typeDetails, evidenceFiles) {
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

        <div class="detail-section-title">${safeVal(d.Report_Type)} Details</div>
        ${buildTypeDetailsHTML(d.Report_Type, typeDetails)}

        <div class="detail-section-title">Evidence Files</div>
        ${buildEvidenceHTML(evidenceFiles)}

        <div class="detail-section-title">DMO Estimate</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-label">Estimated Amount</div>
                <div class="detail-value"><span class="badge-amount">${formatMoney(d.Estimated_Amount)}</span></div>
            </div>
        </div>
    `;
}

// ----------------------------------------------------------------
// Approve / Reject bindings (from modal footer)
// ----------------------------------------------------------------
function bindModalEvents() {
    $('#btnApproveFromModal').on('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('reportDetailsModal')).hide();
        openApproveModal(currentReportID, currentReportType, currentEstimateAmount);
    });

    $('#btnRejectFromModal').on('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('reportDetailsModal')).hide();
        rejectReport(currentReportID);
    });

    $('#btnConfirmApprove').on('click', function () {
        submitApprove();
    });
}

// ----------------------------------------------------------------
// Approve modal
// ----------------------------------------------------------------
function openApproveModal(reportID, reportType, estimateAmount) {
    currentReportID = reportID;
    currentReportType = reportType;
    currentEstimateAmount = estimateAmount;

    $('#apprSummaryReportID').text(safeVal(reportID));
    $('#apprSummaryReportType').text(safeVal(reportType));
    $('#apprSummaryEstimateAmount').text(formatMoney(estimateAmount));

    $('#approveForm')[0].reset();

    bootstrap.Modal.getOrCreateInstance(document.getElementById('approveModal')).show();
}

function submitApprove() {
    const approvedAmount = $('#approvedAmount').val();
    const description = $('#approveDescription').val().trim();

    if (!approvedAmount || parseFloat(approvedAmount) <= 0) {
        Swal.fire('Missing Data', 'Please enter a valid approved amount.', 'warning');
        return;
    }
    if (!description) {
        Swal.fire('Missing Data', 'Please enter a description.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Confirm approval?',
        text: 'This will approve the report and move it to the DS Approved stage.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Yes, Approve'
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: 'DSVerifyReports.php',
            method: 'POST',
            data: {
                action: 'approve',
                report_id: currentReportID,
                approved_amount: approvedAmount,
                description: description
            },
            dataType: 'json',
            success: function (res) {
                if (!res.success) {
                    Swal.fire('Error', res.message || 'Failed to approve report.', 'error');
                    return;
                }

                bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
                Swal.fire('Success', res.message, 'success');
                loadVerifyReports();
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong while approving the report.', 'error');
            }
        });
    });
}

// ----------------------------------------------------------------
// Reject flow (reason textarea via SweetAlert2)
// ----------------------------------------------------------------
function rejectReport(reportID) {
    Swal.fire({
        title: 'Reject Report',
        input: 'textarea',
        inputLabel: 'Reason for rejection',
        inputPlaceholder: 'Enter the reason for rejecting this report...',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        confirmButtonColor: '#dc2626',
        inputValidator: (value) => {
            if (!value || !value.trim()) {
                return 'A reason is required to reject this report.';
            }
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: 'DSVerifyReports.php',
            method: 'POST',
            data: {
                action: 'reject',
                report_id: reportID,
                description: result.value.trim()
            },
            dataType: 'json',
            success: function (res) {
                if (!res.success) {
                    Swal.fire('Error', res.message || 'Failed to reject report.', 'error');
                    return;
                }

                Swal.fire('Rejected', res.message, 'success');
                loadVerifyReports();
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong while rejecting the report.', 'error');
            }
        });
    });
}
