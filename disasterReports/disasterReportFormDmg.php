<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Disaster Form</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="..\style.css" rel="stylesheet" />

</head>
<body>
    <form method="post" id="dReportForm" action="" onsubmit="">
        <main id="main"  class="login-wrapper d-flex justify-content-center align-items-center min-vh-100">
            <div class="reportFormPanel">
                <div>
                    <img src="..\pictures\Post-Disaster-Reporting-Logo.png" width="20%">
                </div>

                <div class="panel-header justify-content-center">
                    <div class="panel-title">
                        <h4 style="font-weight:bold;">Submit New Disaster Report - Property Damage</h4>
                    </div>
                </div>
                    <div class="mb-4">Fill the below form to submit a Property Damage report.</div>

                <label class="text-muted fw-bold" for="disaster-input">Select Disaster</label>
                <div class="input-group mb-4 mx-auto" style="width: 60%">
                    <select class="form-select text-muted" id="disaster-input" name="disaster-input">
                        <option value="flood">Flood</option>
                        <option value="landslide">Landslide</option>
                        <option value="cyclone">Cyclone</option>
                        <option value="earthquake">Earthquake</option>
                        <option value="fire">Fire</option>
                        <option value="tsunami">Tsunami</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <label class="text-muted fw-bold " for="date-input">Date of Incident</label>
                <div class="input-group mb-4 mx-auto" style="width: 60%">
                    <input type="date" class="form-control border-start-0 text-muted" id="date-input" name="date-input">
                </div>

                <label class="text-muted fw-bold" for="damage-input">Estimated Damage Level</label>
                <div class="input-group mb-4 mx-auto" style="width: 60%">
                    <select class="form-select text-muted" id="disaster-input" name="disaster-input">
                        <option value="minor">Minor</option>
                        <option value="moderate">Moderate</option>
                        <option value="major">Major</option>
                        <option value="complete">Complete Destruction</option>
                    </select>
                </div>

            </div>
        </main>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

    <script src="disasterReportDmg.js"></script>
</body>
</html>