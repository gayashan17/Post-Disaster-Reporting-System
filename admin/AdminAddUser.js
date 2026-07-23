document.getElementById("addUserForm").addEventListener("submit", function (e) {

    const form = e.target;
    const errorMessage = document.getElementById("errorMessage");
    errorMessage.textContent = "";

    const username = form.querySelector('[name="username"]').value.trim();
    const password = form.querySelector('[name="password"]').value;
    const fullName = form.querySelector('[name="fullName"]').value.trim();
    const gender = form.querySelector('[name="gender"]').value;
    const nic = form.querySelector('[name="nic"]').value.trim();
    const email = form.querySelector('[name="email"]').value.trim();
    const phone = form.querySelector('[name="phone"]').value.trim();
    const address = form.querySelector('[name="address"]').value.trim();
    const status = form.querySelector('[name="status"]').value;

    // Required common fields
    if (username === "" || password === "" || fullName === "" || gender === "" ||
        nic === "" || email === "" || phone === "" || address === "" || status === "") {
        errorMessage.textContent = "Please fill all fields to continue";
        e.preventDefault();
        return;
    }

    // Email Validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        e.preventDefault();
        return;
    }

    // Phone Number Validation (Sri Lanka)
    const phonePattern = /^0\d{9}$/;
    if (!phonePattern.test(phone)) {
        alert("Please enter a valid 10-digit mobile number.");
        e.preventDefault();
        return;
    }

    // NIC Validation
    const nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;
    if (!nicPattern.test(nic)) {
        alert("Please enter a valid NIC number.");
        e.preventDefault();
        return;
    }

    // Password Length
    if (password.length < 8) {
        alert("Password must contain at least 8 characters.");
        e.preventDefault();
        return;
    }

    // Role-specific required fields (native "required" attributes cover most,
    // this is a belt-and-braces check with a friendlier combined message)
    const roleRequiredFields = form.querySelectorAll('.card:nth-of-type(2) [required]');
    for (const field of roleRequiredFields) {
        if (field.value.trim() === "") {
            errorMessage.textContent = "Please fill all role-specific fields to continue";
            e.preventDefault();
            return;
        }
    }
});
