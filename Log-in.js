function showMessage(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: '#0d6efd'
    });
}

const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password-input");
const eyeIcon = document.getElementById("eyeIcon");

togglePassword.addEventListener("click", function () {

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("bi-eye");
        eyeIcon.classList.add("bi-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("bi-eye-slash");
        eyeIcon.classList.add("bi-eye");
    }

});


document.getElementById("loginForm").addEventListener("submit", function(e){

    const username = document.querySelector('[name="username-input"]').value.trim();
    const password = document.querySelector('[name="password-input"]').value.trim();

    if(username === ""){
        e.preventDefault();

        showMessage(
            "Username Required",
            "Please enter your username.",
            "warning"
        );

        return;
    }

    if(password === ""){
        e.preventDefault();

        showMessage(
            "Password Required",
            "Please enter your password.",
            "warning"
        );

        return;
    }
});