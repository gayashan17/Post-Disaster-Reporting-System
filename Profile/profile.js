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

    fetch('profile.php', {
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

    // Custom NIC check: old format (9 digits + V/X) or new format (12 digits)
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
