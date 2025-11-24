function logoutconfirm() {
    Swal.fire({
        icon : 'warning',
        title: 'Yakin ingin keluar ?',
        text : 'Anda akan diarahkan ke halaman login',
        showConfirmButton: true,
        confirmButtonText: 'Keluar',
        showCancelButton: true,
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';
        }
    });
}