// Script untuk mengatur sidebar
document.addEventListener('DOMContentLoaded', function () {
    // Aktifkan menu yang sesuai dengan halaman saat ini
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
            link.classList.add('active');
        }
    });

    // Responsif sidebar
    function handleResize() {
        if (window.innerWidth < 992) {
            document.querySelector('.sidebar').classList.remove('show');
        } else {
            document.querySelector('.sidebar').classList.add('show');
        }
    }

    // Jalankan saat load dan resize
    handleResize();
    window.addEventListener('resize', handleResize);

    // Validasi form
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const password = form.querySelector('#password');
            const passwordConfirm = form.querySelector('#password_confirm');

            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                e.preventDefault();
                alert('Konfirmasi password tidak sesuai!');
            }
        });
    });

    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});