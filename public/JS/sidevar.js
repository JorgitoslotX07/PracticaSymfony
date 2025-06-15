const btnOpen = document.getElementById('mobileMenuButton');
const btnClose = document.getElementById('mobileCloseButton');
const sidebar = document.getElementById('sidebar');

btnOpen.addEventListener('click', () => {
    sidebar.classList.remove('-translate-x-full');
});

btnClose.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
});


document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('userMenuButton');
    const dropdown = document.getElementById('userDropdown');

    button.addEventListener('click', function (event) {
        event.stopPropagation(); // Evitar que el click se propague al documento
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    });

    // Cerrar dropdown si se hace click fuera
    document.addEventListener('click', function () {
        dropdown.style.display = 'none';
    });
});
