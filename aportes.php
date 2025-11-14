<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aportes y Sugerencias - Pirámide Ejecutores EIRL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
      .form-section { padding: 4rem 0; background-color: #f8f9fa; }
      .form-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="https://www.piramideejecutores.com/recursos/logo%20piramide.svg" alt="Pirámide Ejecutores Logo" style="max-height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="servicios.html">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.html">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.html">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="form-section mt-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container">
                        <h2 class="text-center">Aportes y Sugerencias</h2>
                        <p class="text-muted text-center">Tu opinión es importante para nosotros. Usa este canal para enviarnos tus ideas, felicitaciones o cualquier sugerencia que nos ayude a mejorar.</p>
                        <hr>
                        <div id="form-message" class="mb-3"></div>
                        <form id="aportesForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre (Opcional)</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Correo Electrónico (Opcional)</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <small class="text-muted">Úsalo si deseas que podamos contactarte de vuelta.</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_aporte" class="form-label">Tipo de Aporte</label>
                                <select class="form-select" id="tipo_aporte" name="tipo_aporte">
                                    <option value="Sugerencia">Sugerencia para mejorar</option>
                                    <option value="Felicitación">Felicitación o comentario positivo</option>
                                    <option value="Idea">Nueva idea o propuesta</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="6" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Aporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2024 Pirámide Ejecutores EIRL. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('aportesForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const messageDiv = document.getElementById('form-message');

            messageDiv.innerHTML = '<div class="alert alert-info">Enviando...</div>';
            
            formData.append('form_type', 'aporte'); // Add form_type

            fetch('api/form_handler.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    form.reset();
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.innerHTML = '<div class="alert alert-danger">Ocurrió un error inesperado. Por favor, intente de nuevo.</div>';
            });
        });
    </script>
</body>
</html>