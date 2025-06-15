document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const typeFilter = document.getElementById('type-filter');
    const tableBody = document.querySelector('table tbody');

    function filterRows() {
        const searchText = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const typeValue = typeFilter.value.toLowerCase();

        tableBody.querySelectorAll('tr').forEach(row => {
            const nombre = row.children[1].textContent.toLowerCase();
            const email = row.children[2].textContent.toLowerCase();
            const telefono = row.children[3].textContent.toLowerCase();
            const tipo = row.children[4].textContent.toLowerCase();
            const rowStatus = row.getAttribute('data-status');

            const matchesSearch = [nombre, email, telefono].some(field => field.includes(searchText));

            let matchesStatus = true;
            if (statusValue !== '') {
                matchesStatus = (statusValue === rowStatus);
            }

            let matchesType = true;
            if (typeValue !== '') {
                matchesType = tipo === typeValue;
            }

            if (matchesSearch && matchesStatus && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);
    typeFilter.addEventListener('change', filterRows);
});
