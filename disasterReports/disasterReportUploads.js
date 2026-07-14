
//======================
//Notes - Add confirmation sweet alert to display input data and then insert into database
//======================

let selectedFiles = [];

const fileInput = document.getElementById("report-attachments");
const previewContainer = document.getElementById("preview-container");
const form = document.getElementById("dReportForm");

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

    fetch("disasterReportUploads.php", {

        method: "POST",

        body: formData

    })

    .then(res => res.text())
    .then(data => {
    // prints whatever PHP echoed into browser console
    console.log("Server Debug Info:", data);

    if (data.trim() === "unauthorized") {
        Swal.fire({
            icon: "error",
            title: "Session Expired",
            text: "Please log in again to submit your report.",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../LoginForm.php';
            }
        });
        return;
    }

    if (data.trim() === "success") {
        Swal.fire("Saved!", "Report submitted successfully.", "success");
    }
    else {
        Swal.fire("Error", "Something went wrong on the server.", "error");
    }
    })

    .catch(err => {

        console.error(err);

        Swal.fire({
            icon: "error",
            title: "Upload Failed",
            text: "Something went wrong."
        });

    });

});