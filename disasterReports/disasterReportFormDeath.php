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
                                <h4 style="font-weight:bold;">Submit New Disaster Report - Death Record</h4>
                        </div>
                    </div>
                    <div class="reportFormPanel2 mx-auto">

                        <div class="mb-4">Fill the below form to submit a Property Damage report.</div>

                        <label class="text-muted fw-bold" for="disaster-input">Select Disaster</label>
                        <div class="input-group mb-4">
                            <select class="form-select text-muted" id="disaster-input" name="disaster-input">
                                <option value="default">Select</option>
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
                        <div class="input-group mb-4 ">
                            <input type="date" class="form-control text-muted" id="date-input" name="date-input">
                        </div>

                        <label class="text-muted fw-bold" for="prReportDesc-input">Report Description</label>
                        <div class="form-group mb-4">
                            <textarea class="form-control" id="prReportDesc-input" rows="5" placeholder="Write a brief description on what happened"></textarea>
                        </div>

                        <hr class="divider">

                        <label class="fw-bold mb-4" style="text-decoration:underline;">Death Person Information</label><br>

                        <label class="text-muted fw-bold" for="name-input">FullName</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control border-start-1" name="name-input" placeholder="Enter Death person's FullName">
                        </div>

                        <label class="text-muted fw-bold" for="age-input">Age</label>
                        <div class="input-group mb-4">
                            <input type="number" class="form-control border-start-1" name="age-input" placeholder="Enter Death person's Age" oninput="if(this.value.length > 3) this.value = this.value.slice(0,3);">
                        </div>

                        <label class="text-muted fw-bold" for="gender-input">Gender</label>
                        <div class="input-group mb-4 w-100">
                            <select class="form-select text-muted" id="gender-input" name="gender-input">
                                <option value="default">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <label class="text-muted fw-bold" for="cause-input">Cause of Death</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control border-start-1" name="cause-input" placeholder="Enter The Cause of death">
                        </div>

                        <label class="text-muted fw-bold" for="evidence-input">Evidence Upload</label>
                        <div class="input-group mb-4">
                            <input type="file" class="form-control border-start-0" name="evidence-input">
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="declaration-input" name="declaration-input">
                            <label class="form-check-label" style="cursor: pointer; text-align:left;" for="declaration-input">
                                I declare that the information provided is true and accurate.
                            </label>
                        </div>

                        <input type="submit" name="register" class=" btn btn-primary btn-block mb-3 w-75" value="Submit Report">

                        <input type="button" name="register" class=" btn btn-danger  btn-block w-75" value="Cancel" onclick=" window.location.href='../dashboardForm.php'; ">
                    </div>
                </div>
            </main>
        </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>

    <script src="disasterReportDeath.js"></script>
</body>
</html>