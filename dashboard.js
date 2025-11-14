document.addEventListener('DOMContentLoaded', () => {
    // Check session
    fetch('check_session.php')
        .then(res => res.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = 'login.html';
            } else {
                // Load initial data
                cargarMarcaciones('', 'nombre_personal');
            }
        })
        .catch(err => {
            console.error('Error checking session:', err);
            window.location.href = 'login.html';
        });

    // Event listeners for search and sort
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchTerm = this.value;
        const sortOption = document.getElementById('sortSelect').value;
        cargarMarcaciones(searchTerm, sortOption);
    });

    document.getElementById('sortSelect').addEventListener('change', function () {
        const searchTerm = document.getElementById('searchInput').value;
        const sortOption = this.value;
        cargarMarcaciones(searchTerm, sortOption);
    });

    // Logout functionality
    document.getElementById('btnLogout').addEventListener('click', logout);
});

let marcacionesData = [];

async function cargarMarcaciones(searchTerm, sortOption) {
    const response = await fetch('fetch_marcaciones.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search: searchTerm, sort: sortOption })
    });
    const result = await response.json();
    if (result.ok) {
        marcacionesData = result.data;
        procesarDatos();
    } else {
        console.error('Error loading data:', result.error);
    }
}

function procesarDatos() {
    // Process and display data
    // Existing code...
}

// Export to Excel functionality
function exportToExcel() {
    const table = document.querySelector('#generalTableContainer table');
    if (!table) return;

    const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.write(workbook, { bookType: 'xlsx', type: 'buffer' });
    XLSX.writeFile(workbook, 'asistencia.xlsx');
}

// Add event listener for export button
document.getElementById('btnExportExcel').addEventListener('click', exportToExcel);
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value;
    const sortOption = document.getElementById('sortSelect').value;
    cargarMarcaciones(searchTerm, sortOption);
});

document.getElementById('sortSelect').addEventListener('change', function() {
    const searchTerm = document.getElementById('searchInput').value;
    const sortOption = this.value;
    cargarMarcaciones(searchTerm, sortOption);
});
function exportToExcel() {
    const table = document.querySelector('#generalTableContainer table');
    if (!table) return;

    const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(workbook, 'asistencia.xlsx');
}

document.getElementById('btnExportExcel').addEventListener('click', exportToExcel);
document.addEventListener('DOMContentLoaded', () => {
    fetch('check_session.php')
        .then(res => res.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = 'login.html';
            } else {
                // Load initial data
                cargarMarcaciones('', 'nombre_personal');
            }
        })
        .catch(err => {
            console.error('Error checking session:', err);
            window.location.href = 'login.html';
        });

    // Event listeners for search and sort
    // Existing code...
});