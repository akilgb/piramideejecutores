<?php
session_start();
// Si la sesión NO está iniciada, redirige a login.html
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Completo</title>
    <!-- Estilos de la aplicación -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f5;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
        }
        .logout {
            background-color: #dc3545;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .table-section, .cards-section, .charts-section {
            margin-top: 20px;
        }
        .cards-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .attendance-count {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        .thumb {
            width: 50px;
            height: auto;
        }
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 50px auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 90%; 
            max-width: 1000px;
            border-radius: 10px;
            position: relative;
        }
        .close {
            color: #aaa;
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
        .export-button {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .export-button:hover {
            background-color: #218838;
        }
        .charts-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        /* Calendar Styles */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 20px;
        }
        .calendar .day {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 40px;
            position: relative;
        }
        .calendar .header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .green {
            background-color: #28a745;
            color: white;
        }
        .yellow {
            background-color: #ffc107;
            color: white;
        }
        .red {
            background-color: #dc3545;
            color: white;
        }
        /* Responsive Table */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Header con título y botón de logout -->
        <div class="header">
            <h1>Dashboard</h1>
            <a class="logout" href="logout.php">Cerrar Sesión</a>
        </div>

        <!-- Sección de tarjetas (PERSONAL) -->
        <div class="cards-section" id="cards-section">
            <!-- Se generarán dinámicamente con fetch a list_images.php -->
        </div>

        <!-- Sección de gráficos -->
        <div class="charts-section">
            <h2>Estadísticas de Asistencias</h2>
            <canvas id="attendanceChart" width="400" height="200"></canvas>
        </div>

        <!-- Sección de tabla de asistencias -->
        <div class="table-section">
            <h2>Reporte de Asistencias</h2>
            <button class="export-button" id="exportTableButton">Exportar a Excel</button>
            <div class="table-responsive">
                <table id="asistenciasTable">
                    <thead>
                        <tr id="tableHeader">
                            <!-- Encabezados dinámicos -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para el calendario y detalles del personal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div style="display: flex; align-items: center;">
                <img src="" alt="" id="modalImage" style="width: 100px; height: 100px; border-radius: 50%; margin-right: 20px;">
                <div>
                    <h3 id="modalName"></h3>
                    <div class="attendance-count" id="modalAttendanceCount"></div>
                </div>
            </div>
            <h3>Calendario de Asistencias</h3>
            <div id="calendar" class="calendar">
                <!-- Calendario generado dinámicamente -->
            </div>
            <h3>Detalle de Asistencias</h3>
            <button class="export-button" id="exportIndividualButton">Exportar a Excel</button>
            <div class="table-responsive">
                <table id="individualAsistenciasTable">
                    <thead>
                        <tr id="individualTableHeader">
                            <!-- Encabezados dinámicos -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script principal: carga tarjetas, asistencias, etc. -->
    <script>
        // Endpoints/rutas ajustadas a tu proyecto
        const LIST_IMAGES_ENDPOINT = 'recursos/personal/list_images.php';
        const GET_ASISTENCIAS_ENDPOINT = 'recursos/api/get_asistencias.php';
        const IMAGE_BASE_PATH = 'recursos/personal/';

        // Objetos para contar asistencias
        let attendancesByPerson = {};
        let overallAttendances = {}; // Para gráficos
        let allAsistencias = []; // Almacenar todas las asistencias

        document.addEventListener('DOMContentLoaded', () => {
            initDashboard();
            cargarAsistencias();
            initExportButton();
        });

        // Inicializar el Dashboard: Cargar tarjetas y asignar eventos
        async function initDashboard() {
            try {
                const response = await fetch(LIST_IMAGES_ENDPOINT);
                if (!response.ok) throw new Error('Error al obtener datos de imágenes');
                const data = await response.json();
                console.log('Datos de list_images.php:', data);

                const container = document.getElementById('cards-section');

                // Si 'data' es un array (["juan_perez.jpg", "maria_gomez.jpg", ...])
                if (Array.isArray(data)) {
                    data.forEach(fileName => {
                        const card = createCardFromFileName(fileName);
                        container.appendChild(card);
                    });
                } 
                // Si 'data' es un objeto ({ "1": "Juan Pérez", "2": "María Gómez", ... })
                else {
                    Object.keys(data).forEach(personalId => {
                        const nombre = data[personalId];
                        const card = createCardFromName(nombre, personalId);
                        container.appendChild(card);
                    });
                }

                // Inicializar los eventos de los modales después de crear las tarjetas
                initModal();

            } catch (error) {
                console.error('Error cargando las tarjetas:', error);
            }
        }

        // Crear una tarjeta a partir del nombre de archivo de la imagen
        function createCardFromFileName(fileName) {
            const personName = fileName.substring(0, fileName.lastIndexOf('.')) || fileName;
            const personNameFormatted = personName.replace(/_/g, ' ');

            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.person = personNameFormatted; 

            const img = document.createElement('img');
            img.src = IMAGE_BASE_PATH + fileName;
            img.alt = personNameFormatted;

            const nameHeading = document.createElement('h3');
            nameHeading.textContent = personNameFormatted;

            card.appendChild(img);
            card.appendChild(nameHeading);
            return card;
        }

        // Crear una tarjeta a partir del nombre y ID del personal
        function createCardFromName(name, personalId) {
            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.person = name;
            card.dataset.id = personalId;

            // Asumimos convención "Juan Pérez" => "juan_perez.jpg"
            const imageFileName = name.replace(/\s+/g, '_').toLowerCase() + '.jpg';
            const imgPath = IMAGE_BASE_PATH + imageFileName;

            const img = document.createElement('img');
            img.src = imgPath;
            img.alt = name;

            const nameHeading = document.createElement('h3');
            nameHeading.textContent = name;

            card.appendChild(img);
            card.appendChild(nameHeading);
            return card;
        }

        // Cargar las asistencias desde el endpoint y procesarlas
        async function cargarAsistencias() {
            try {
                const response = await fetch(GET_ASISTENCIAS_ENDPOINT);
                if (!response.ok) throw new Error('Error al obtener los datos de asistencias');
                const asistencias = await response.json();
                allAsistencias = asistencias; // Guardar todas las asistencias

                const tableHeader = document.getElementById('tableHeader');
                const tbody = document.querySelector('#asistenciasTable tbody');

                tableHeader.innerHTML = '';
                tbody.innerHTML = '';

                if (!Array.isArray(asistencias) || asistencias.length === 0) {
                    tableHeader.innerHTML = '<th>No hay datos</th>';
                    return;
                }

                // Columnas dinámicas basadas en la primera fila
                const columnas = Object.keys(asistencias[0]);
                columnas.forEach(col => {
                    const th = document.createElement('th');
                    th.textContent = col;
                    tableHeader.appendChild(th);
                });

                // Renderizar filas
                asistencias.forEach(registro => {
                    const tr = document.createElement('tr');
                    columnas.forEach(col => {
                        const td = document.createElement('td');
                        if (col === 'foto_evidencia' && registro[col]) {
                            let src;
                            if (registro[col].startsWith('data:image/')) {
                                src = registro[col];
                            } else {
                                src = `data:image/jpeg;base64,${registro[col]}`;
                            }
                            td.innerHTML = `<img src="${src}" alt="Evidencia" class="thumb">`;
                        } else {
                            td.textContent = registro[col];
                        }
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });

                // Calcular asistencias por persona
                calcularAsistencias(asistencias);
                // Actualizar tarjetas con conteo de asistencias
                updateCardsWithAsistencias();
                // Generar gráfico de asistencias
                generarGraficos();
            } catch (error) {
                console.error('Error al cargar asistencias:', error);
            }
        }

        // Calcular asistencias por persona y asistencias generales para gráficos
        function calcularAsistencias(asistencias) {
            attendancesByPerson = {};
            overallAttendances = {};
            asistencias.forEach(reg => {
                const name = reg.nombre_personal;
                const fecha = reg.fecha;
                const observacion = reg.observaciones; // Asegúrate de que este campo existe

                if (name && fecha) {
                    if (!attendancesByPerson[name]) {
                        attendancesByPerson[name] = {};
                    }
                    // Solo considerar la primera asistencia del día
                    if (!attendancesByPerson[name][fecha]) {
                        attendancesByPerson[name][fecha] = observacion;
                    }

                    // Para gráficos: contar asistencias exitosas
                    if (observacion === 'Marcación Exitosa') {
                        if (!overallAttendances[name]) {
                            overallAttendances[name] = 0;
                        }
                        overallAttendances[name]++;
                    }
                }
            });
        }

        // Actualizar las tarjetas con el conteo de días asistidos
        function updateCardsWithAsistencias() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                const personName = card.dataset.person;
                const existingCount = card.querySelector('.attendance-count');
                if (existingCount) existingCount.remove();

                const count = overallAttendances[personName] || 0;
                const countDiv = document.createElement('div');
                countDiv.className = 'attendance-count';
                countDiv.textContent = `Días asistidos: ${count}`;
                card.appendChild(countDiv);
            });
        }

        // Generar el gráfico de barras de asistencias
        function generarGraficos() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            const labels = Object.keys(overallAttendances);
            const data = Object.values(overallAttendances);

            // Eliminar el gráfico anterior si existe
            if (window.attendanceChartInstance) {
                window.attendanceChartInstance.destroy();
            }

            window.attendanceChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Días Asistidos',
                        data: data,
                        backgroundColor: 'rgba(0, 123, 255, 0.6)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision:0
                            }
                        }
                    }
                }
            });
        }

        // Inicializar el botón para exportar la tabla general a Excel
        function initExportButton() {
            const exportButton = document.getElementById('exportTableButton');
            exportButton.addEventListener('click', () => {
                exportTableToExcel('asistenciasTable', 'Reporte_Asistencias');
            });
        }

        // Función para exportar cualquier tabla a Excel
        function exportTableToExcel(tableID, filename = ''){
            const wb = XLSX.utils.book_new();
            const table = document.getElementById(tableID);
            const ws = XLSX.utils.table_to_sheet(table);
            XLSX.utils.book_append_sheet(wb, ws, "Asistencias");
            XLSX.writeFile(wb, `${filename}.xlsx`);
        }

        // Inicializar el modal y asignar eventos a las tarjetas
        function initModal() {
            const modal = document.getElementById("detailsModal");
            const span = document.getElementsByClassName("close")[0];
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const personName = card.dataset.person;
                    const personalId = card.dataset.id || null;
                    console.log('Tarjeta clicada:', personName, 'ID:', personalId);
                    mostrarDetalles(personName, personalId);
                    modal.style.display = "block";
                });
            });

            // Cuando el usuario hace clic en <span> (x), cierra el modal
            span.onclick = function() {
                modal.style.display = "none";
                limpiarModal();
            }

            // Cuando el usuario hace clic fuera del modal, lo cierra
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    limpiarModal();
                }
            }

            // Export individual button
            const exportIndividualButton = document.getElementById('exportIndividualButton');
            exportIndividualButton.addEventListener('click', () => {
                exportIndividualToExcel();
            });
        }

        let currentIndividualData = [];
        let currentIndividualName = '';

        // Mostrar detalles en el modal para el personal seleccionado
        function mostrarDetalles(name, id) {
            currentIndividualName = name;
            const modalName = document.getElementById('modalName');
            const modalImage = document.getElementById('modalImage');
            const modalAttendanceCount = document.getElementById('modalAttendanceCount');

            modalName.textContent = name;
            modalAttendanceCount.textContent = `Días asistidos: ${overallAttendances[name] || 0}`;

            // Asumimos que la imagen sigue la convención
            const imageFileName = name.replace(/\s+/g, '_').toLowerCase() + '.jpg';
            modalImage.src = IMAGE_BASE_PATH + imageFileName;
            modalImage.alt = name;

            // Generar calendario
            generarCalendario(name);

            // Generar tabla individual
            generarTablaIndividual(name);

            // Filtrar datos individuales para exportar
            currentIndividualData = filtrarDatosIndividual(name);
        }

        // Filtrar los datos individuales del personal para exportar
        function filtrarDatosIndividual(name) {
            // Filtrar asistencias para la persona específica
            const asistencias = allAsistencias.filter(reg => reg.nombre_personal === name);
            // Ordenar por fecha
            asistencias.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
            // Solo la primera asistencia por día ya está manejada en attendancesByPerson
            return asistencias.map(reg => ({
                "Nombre": reg.nombre_personal,
                "Fecha": reg.fecha,
                "Observaciones": reg.observaciones,
                "Foto Evidencia": reg.foto_evidencia ? "Sí" : "No"
            }));
        }

        // Generar el calendario de asistencias en la modal
        function generarCalendario(name) {
            const calendarDiv = document.getElementById('calendar');
            calendarDiv.innerHTML = '';

            // Obtener el mes actual
            const today = new Date();
            const month = today.getMonth(); // 0-11
            const year = today.getFullYear();

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const totalDays = lastDay.getDate();

            const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
            diasSemana.forEach(dia => {
                const div = document.createElement('div');
                div.className = 'day header';
                div.textContent = dia;
                calendarDiv.appendChild(div);
            });

            // Espacios en blanco para los días anteriores al primer día del mes
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'day';
                calendarDiv.appendChild(emptyDiv);
            }

            // Generar los días del mes
            for (let day = 1; day <= totalDays; day++) {
                const date = new Date(year, month, day);
                const dateStr = date.toISOString().split('T')[0]; // Formato YYYY-MM-DD

                const dayDiv = document.createElement('div');
                dayDiv.className = 'day';
                dayDiv.textContent = day;

                if (attendancesByPerson[name] && attendancesByPerson[name][dateStr]) {
                    const observacion = attendancesByPerson[name][dateStr];
                    if (observacion === 'Marcación Exitosa') {
                        dayDiv.classList.add('green');
                    } else if (['Fraude Detectado', 'Dispositivo electrónico', 'Cambio de Rostro'].includes(observacion)) {
                        dayDiv.classList.add('yellow');
                    } else {
                        dayDiv.classList.add('red');
                    }
                } else {
                    dayDiv.classList.add('red');
                }

                calendarDiv.appendChild(dayDiv);
            }
        }

        // Generar la tabla individual de asistencias en la modal
        function generarTablaIndividual(name) {
            const individualTableHeader = document.getElementById('individualTableHeader');
            const individualTbody = document.querySelector('#individualAsistenciasTable tbody');

            individualTableHeader.innerHTML = '';
            individualTbody.innerHTML = '';

            // Filtrar asistencias para la persona específica
            const asistencias = allAsistencias.filter(reg => reg.nombre_personal === name);

            if (asistencias.length === 0) {
                individualTableHeader.innerHTML = '<th>No hay datos</th>';
                return;
            }

            // Columnas dinámicas basadas en la primera fila
            const columnas = Object.keys(asistencias[0]);
            columnas.forEach(col => {
                const th = document.createElement('th');
                th.textContent = col;
                individualTableHeader.appendChild(th);
            });

            // Renderizar filas
            asistencias.forEach(registro => {
                const tr = document.createElement('tr');
                columnas.forEach(col => {
                    const td = document.createElement('td');
                    if (col === 'foto_evidencia' && registro[col]) {
                        let src;
                        if (registro[col].startsWith('data:image/')) {
                            src = registro[col];
                        } else {
                            src = `data:image/jpeg;base64,${registro[col]}`;
                        }
                        td.innerHTML = `<img src="${src}" alt="Evidencia" class="thumb">`;
                    } else {
                        td.textContent = registro[col];
                    }
                    tr.appendChild(td);
                });
                individualTbody.appendChild(tr);
            });
        }

        // Limpiar el contenido del modal al cerrarlo
        function limpiarModal() {
            const modalName = document.getElementById('modalName');
            const modalImage = document.getElementById('modalImage');
            const modalAttendanceCount = document.getElementById('modalAttendanceCount');
            const calendarDiv = document.getElementById('calendar');
            const individualTableHeader = document.getElementById('individualTableHeader');
            const individualTbody = document.querySelector('#individualAsistenciasTable tbody');

            modalName.textContent = '';
            modalImage.src = '';
            modalImage.alt = '';
            modalAttendanceCount.textContent = '';
            calendarDiv.innerHTML = '';
            individualTableHeader.innerHTML = '';
            individualTbody.innerHTML = '';
            currentIndividualData = [];
            currentIndividualName = '';
        }

        // Exportar la tabla individual a Excel
        function exportIndividualToExcel() {
            if (currentIndividualData.length === 0) {
                alert('No hay datos para exportar.');
                return;
            }

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(currentIndividualData);
            XLSX.utils.book_append_sheet(wb, ws, "Asistencias_Individual");
            XLSX.writeFile(wb, `${currentIndividualName}_Asistencias.xlsx`);
        }
    </script>
</body>
</html>
