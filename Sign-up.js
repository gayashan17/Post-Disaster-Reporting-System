document.getElementById("signupForm").addEventListener("submit", function (e) {

    const username = document.querySelector('[name="username-input"]').value.trim();
    const fullname = document.querySelector('[name="fullname-input"]').value.trim();
    const nic = document.querySelector('[name="nic-input"]').value.trim();
    const phone = document.querySelector('[name="phoneNo-input"]').value.trim();
    const email = document.querySelector('[name="email-input"]').value.trim();
    const gender = document.querySelector('[name="gender-input"]').value;
    const password = document.querySelector('[name="password-input"]').value;
    const confirmPassword = document.querySelector('[name="confPassword-input"]').value;
    const errorMessage= document.getElementById("errorMessage");

    // Username
    if(username === "" || fullname === "" || nic==="" || phone==="" || email==="" || gender==="" || password==="" || confirmPassword==="")
    {
        errorMessage.textContent="Please fill all fields to continue";
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

    // Gender Validation
    if (gender === "default") {
        alert("Please select a gender.");
        e.preventDefault();
        return;
    }

    // Password Length
    if (password.length < 8) {
        alert("Password must contain at least 8 characters.");
        e.preventDefault();
        return;
    }

    // Password Match
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        e.preventDefault();
        return;
    }
});