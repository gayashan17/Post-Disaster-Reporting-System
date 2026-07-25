document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('profile-form');
  const submitBtn = document.getElementById('profile-submit-btn');

  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (!validateForm()) {
      form.classList.add('was-validated');
      return;
    }

    const formData = new FormData(form);
    const payload = {};
    formData.forEach((value, key) => (payload[key] = value));

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

    fetch('Citizenprofile.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
      .then(async (res) => {
        const data = await res.json();
        if (!res.ok || !data.success) {
          throw new Error(data.message || 'Something went wrong.');
        }
        return data;
      })
      .then((data) => {
        Swal.fire({
          icon: 'success',
          title: 'Profile Updated',
          text: data.message || 'Your profile information was submitted successfully.',
          confirmButtonColor: '#0d6efd'
        });
        // Clear password fields after successful submit
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
        form.classList.remove('was-validated');
      })
      .catch((err) => {
        Swal.fire({
          icon: 'error',
          title: 'Update Failed',
          text: err.message
        });
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Save Changes';
      });
  });

  function validateForm() {
    let valid = form.checkValidity();


    const nic = document.getElementById('NIC');
    const nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;
    if (!nicPattern.test(nic.value.trim())) {
      nic.setCustomValidity('invalid');
      valid = false;
    } else {
      nic.setCustomValidity('');
    }

    // Custom phone check: 10 digits
    const phone = document.getElementById('phoneNo');
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone.value.trim())) {
      phone.setCustomValidity('invalid');
      valid = false;
    } else {
      phone.setCustomValidity('');
    }

    // Password match check (only if user is trying to change it)
    const newPwd = document.getElementById('newPassword');
    const confirmPwd = document.getElementById('confirmPassword');
    if (newPwd.value || confirmPwd.value) {
      if (newPwd.value.length < 6) {
        newPwd.setCustomValidity('invalid');
        valid = false;
      } else {
        newPwd.setCustomValidity('');
      }
      if (newPwd.value !== confirmPwd.value) {
        confirmPwd.setCustomValidity('invalid');
        valid = false;
      } else {
        confirmPwd.setCustomValidity('');
      }
    } else {
      newPwd.setCustomValidity('');
      confirmPwd.setCustomValidity('');
    }

    return valid;
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const picInput = document.getElementById('profilePicInput');
  const picForm = document.getElementById('profilePicForm');

  if (picInput && picForm) {
    picInput.addEventListener('change', function () {
      if (!this.files || !this.files[0]) return;

      const file = this.files[0];
      const allowedTypes = ['image/png', 'image/jpeg', 'image/webp'];

      if (!allowedTypes.includes(file.type)) {
        Swal.fire('Invalid file', 'Please select a PNG, JPG, or WEBP image.', 'error');
        this.value = '';
        return;
      }
      if (file.size > 5 * 1024 * 1024) {
        Swal.fire('File too large', 'Please select an image under 5MB.', 'error');
        this.value = '';
        return;
      }

      picForm.submit();
    });
  }

  const params = new URLSearchParams(window.location.search);
  if (params.get('pic') === 'success') {
    Swal.fire({
      icon: 'success',
      title: 'Profile Picture Updated',
      confirmButtonColor: '#0d6efd'
    });
    window.history.replaceState({}, document.title, window.location.pathname);
  } else if (params.get('pic') === 'error') {
    Swal.fire({
      icon: 'error',
      title: 'Update Failed',
      text: params.get('msg') || 'Something went wrong while updating your profile picture.'
    });
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});
