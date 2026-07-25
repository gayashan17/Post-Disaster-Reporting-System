
function confirmLogout() {
    Swal.fire({
        title: 'Logging out?',
        text: 'You will be redirected to the login page.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Stay'
    }).then(result => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Logged out',
                text: 'See you again!',
                icon: 'success',
                timer: 1800,
                showConfirmButton: false
            }).then(() => {

                window.location.replace("../logout.php");

            });
        }
    });
}