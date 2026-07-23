
//======================
//Notes - Add confirmation sweet alert to display input data and then insert into database
//======================

let selectedFiles = [];

const fileInput = document.getElementById("report-attachments");
const previewContainer = document.getElementById("preview-container");
const form = document.getElementById("dReportForm");

// ===========================
// District → Divisional Secretariat
// Shared by All Report Types
// ===========================

const districtInput = document.getElementById("district-input");
const dsInput = document.getElementById("ds-input");

if (districtInput && dsInput)
{
    districtInput.addEventListener("change", function () {

        const district = this.value;

        // Reset DS dropdown
        dsInput.innerHTML =
            '<option value="">Select Divisional Secretariat</option>';

        if (!district || district === "default")
        {
            dsInput.disabled = true;

            dsInput.innerHTML =
                '<option value="">Select District First</option>';

            return;
        }

        // Determine backend file
        let backendFile = "";

        switch (reportType)
        {
            case "prDmg":
                backendFile = "disasterReportDmg.php";
                break;

            case "death":
                backendFile = "disasterReportDeath.php";
                break;

            case "inj":
                backendFile = "disasterReportInj.php";
                break;

            case "missing":
                backendFile = "disasterReportMissing.php";
                break;

            default:
                console.error("Invalid report type.");
                return;
        }

        // Show loading
        dsInput.disabled = true;

        dsInput.innerHTML =
            '<option value="">Loading...</option>';


        fetch(backendFile, {
            method: "POST",

            headers: {
                "Content-Type":
                    "application/x-www-form-urlencoded"
            },

            body:
                "action=getDSByDistrict&district=" +
                encodeURIComponent(district)
        })

        .then(response => response.json())

        .then(data => {

            console.log("DS Response:", data);

            dsInput.innerHTML =
                '<option value="">Select Divisional Secretariat</option>';


            if (!data.success)
            {
                Swal.fire({
                    icon: "error",
                    title: "Failed to Load",
                    text: data.message ||
                        "Unable to load Divisional Secretariats."
                });

                dsInput.disabled = true;

                return;
            }


            if (data.data.length === 0)
            {
                dsInput.innerHTML =
                    '<option value="">No Divisional Secretariat Found</option>';

                dsInput.disabled = true;

                return;
            }


            // Add DS records
            data.data.forEach(ds => {

                const option =
                    document.createElement("option");

                // Value stored in database
                option.value = ds.DS_ID;

                // Displayed to user
                option.textContent = ds.DS_Name;

                dsInput.appendChild(option);

            });


            dsInput.disabled = false;

        })

        .catch(error => {

            console.error(
                "DS Loading Error:",
                error
            );

            dsInput.innerHTML =
                '<option value="">Failed to Load</option>';

            dsInput.disabled = true;

            Swal.fire({
                icon: "error",
                title: "Connection Error",
                text: "Unable to load Divisional Secretariats."
            });

        });

    });
}


// Allowed types
const validImageTypes = ["image/jpeg","image/png","image/gif","image/webp"];

const validPdfType = "application/pdf";

// ===========================
// File Selection
// ===========================

fileInput.addEventListener("change", function (e) {




    const files = Array.from(e.target.files);

    if (selectedFiles.length + files.length > 10)  //check
    {
        Swal.fire({
            icon: "warning",
            title: "Upload Limit Reached",
            text: `You can upload a maximum of 10 files.`
        });

        fileInput.value = "";
        return;
    }



    files.forEach(file => {

        // Validate file type
        if (!validImageTypes.includes(file.type) &&
            file.type !== validPdfType) {

            Swal.fire({
                icon: "error",
                title: "Invalid File",
                text: `${file.name} is not a supported file type.`
            });

            return;
        }

        // Prevent duplicates
        const exists = selectedFiles.some(f =>
            f.name === file.name &&
            f.size === file.size
        );

        if (exists)
            return;

        selectedFiles.push(file);

        createPreview(file);

    });

    // Reset input so same file can be selected again
    fileInput.value = "";

});


// ===========================
// Create Preview Card
// ===========================

function createPreview(file)
{
    const card = document.createElement("div");

    card.className =
        "position-relative border rounded shadow-sm bg-white p-2";

    card.style.width = "120px";

    // Remove button
    const removeBtn = document.createElement("button");

    removeBtn.type = "button";
    removeBtn.className =
        "btn btn-danger btn-sm position-absolute top-0 end-0";

    removeBtn.style.width = "25px";
    removeBtn.style.height = "25px";
    removeBtn.style.borderRadius = "50%";
    removeBtn.style.transform = "translate(40%,-40%)";

    removeBtn.innerHTML = "&times;";

    removeBtn.onclick = function () {

        selectedFiles = selectedFiles.filter(f => f !== file);

        card.remove();

    };

    // IMAGE
    if (validImageTypes.includes(file.type))
    {
        const reader = new FileReader();

        reader.onload = function (e)
        {
            const img = document.createElement("img");

            img.src = e.target.result;
            img.className = "img-fluid rounded";

            img.style.height = "80px";
            img.style.width = "100%";
            img.style.objectFit = "cover";

            card.appendChild(img);

            addFileInfo(card, file);

            card.appendChild(removeBtn);

            previewContainer.appendChild(card);

        };

        reader.readAsDataURL(file);
    }

    // PDF
    else
    {
        card.innerHTML = `
            <div class="text-center mt-2">
                <i class="bi bi-file-earmark-pdf-fill text-danger"
                    style="font-size:60px"></i>
            </div>
        `;

        addFileInfo(card, file);

        card.appendChild(removeBtn);

        previewContainer.appendChild(card);
    }

}


// ===========================
// File Name + Size
// ===========================

function addFileInfo(card, file)
{

    const name = document.createElement("div");

    name.className =
        "small text-truncate mt-2 fw-semibold";

    name.title = file.name;

    name.textContent = file.name;

    const size = document.createElement("div");

    size.className = "small text-muted";

    size.textContent =
        (file.size / 1024).toFixed(1) + " KB";

    card.appendChild(name);

    card.appendChild(size);

}


// ===========================
// Form Submit
// ===========================

form.addEventListener("submit", function (e) {

    e.preventDefault();

    if (selectedFiles.length === 0)
    {
        Swal.fire({
            icon: "warning",
            title: "No Evidence",
            text: "Please upload at least one evidence file."
        });

        return;
    }

    const formData = new FormData(form);

    selectedFiles.forEach(file => {
        formData.append("report-attachments[]", file);
    });

    let backendFile = "";

    switch (reportType)
    {
        case "prDmg":
            backendFile = "disasterReportDmg.php";
            break;

        case "death":
            backendFile = "disasterReportDeath.php";
            break;

        case "inj":
            backendFile = "disasterReportInj.php";
            break;

        case "missing":
            backendFile = "disasterReportMissing.php";
            break;

        default:
            window.location.href = "../citizen/CitizendashboardForm.php";
            return;
    }

    fetch(backendFile, {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {

        console.log(data);

        if (data.trim() === "unauthorized")
        {
            Swal.fire({
                icon: "error",
                title: "Session Expired",
                text: "Please log in again."
            }).then(() => {
                window.location.href = "../LoginForm.php";
            });

            return;
        }

        if (data.trim() === "success")
        {
            Swal.fire({
                icon: "success",
                title: "Report Submitted!",
                text: "Your report has been submitted successfully."
            }).then(() => {
                window.location.href = "../citizen/CitizendashboardForm.php";
            });
        }

        else
        {
            Swal.fire({
                icon: "error",
                title: "Report Submission Failed",
                text: "Something went wrong while trying to submit your report."

            })
            console.log(data.trim());
        }

    })
    .catch(error => {

        console.error(error);

        Swal.fire({
            icon: "error",
            title: "Upload Failed",
            text: "Something went wrong."
        });

    });

});